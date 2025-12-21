<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Payment;
use App\Models\VoterToken;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class AdminController extends Controller
{
    /**
     * ADMIN - List semua pembayaran
     */
    public function index(Request $request)
    {
        $payments = Payment::with([
            'user:id,name,email',
            'plan:id,name,price',
        ])
            ->latest('transaction_time')
            ->get()
            ->map(function ($payment) {
                return [
                    'id'                 => $payment->id,
                    'order_id'           => $payment->order_id,
                    'user_name'          => $payment->user?->name,
                    'user_email'         => $payment->user?->email,
                    'plan_name'          => $payment->plan?->name,
                    'amount'             => $payment->amount,
                    'payment_method'     => $payment->payment_method,
                    'bank'               => $this->resolveBank($payment),
                    'transaction_status' => $payment->transaction_status,
                    'paid_at'            => $payment->paid_at,
                ];
            });

        return view('admin.admin.payments.index', compact('payments'));
    }

    /**
     * ADMIN - Detail pembayaran
     */
    public function show(Payment $payment)
    {
        $payment->load([
            'user:id,name,email',
            'plan:id,name,price,features',
            'userPlan',
        ]);

        return view('admin.admin.payments.show', [
            'payment' => $payment,
            'bank'    => $this->resolveBank($payment),
        ]);
    }

    /**
     * Helper: Ambil bank / channel dari payload Midtrans
     */
    private function resolveBank(Payment $payment): string
    {
        $payload = $payment->payload_response ?? [];

        // Bank Transfer (BCA, BNI, Mandiri, dll)
        if (!empty($payload['va_numbers'][0]['bank'])) {
            return strtoupper($payload['va_numbers'][0]['bank']);
        }

        if (!empty($payload['permata_va_number'])) {
            return 'PERMATA';
        }

        // QRIS
        if ($payment->payment_method === 'qris') {
            return strtoupper($payload['qris_acquirer'] ?? 'QRIS');
        }

        // Credit Card
        if ($payment->payment_method === 'credit_card') {
            return 'CREDIT CARD';
        }

        return strtoupper($payload['payment_type'] ?? '-');
    }

    /**
     * INDEX
     * List semua subscription plan
     */
    public function index_subscriptions()
    {
        $plans = SubscriptionPlan::withCount([
            'userPlans as total_subscribers' => function ($q) {
                $q->where('payment_status', 'paid');
            }
        ])->latest()->get();

        return view('admin.admin.subscriptions.index', compact('plans'));
    }

    /**
     * SHOW
     * Detail user yang berlangganan plan tertentu
     */
    public function show_subscription(SubscriptionPlan $plan)
    {
        $plan->load([
            'userPlans' => function ($q) {
                $q->where('payment_status', 'paid')
                    ->with([
                        'user:id,name,email',
                        'payment:id,order_id,amount,transaction_status',
                        'events:id,title,user_plan_id'
                    ]);
            }
        ]);

        return view('admin.admin.subscriptions.show', compact('plan'));
    }

    public function index_tokens(Request $request)
    {
        $search = $request->input('search');

        $tokens = VoterToken::query()
            // Select hanya kolom yang diperlukan
            ->select('id', 'token', 'event_id', 'is_used', 'created_at')

            // Eager loading dengan select spesifik
            ->with([
                'event' => function ($query) {
                    $query->select('id', 'title', 'user_id');
                },
                'event.owner' => function ($query) {
                    $query->select('id', 'name', 'email');
                }
            ])

            // Search optimization
            ->when($search, function ($query) use ($search) {
                $searchTerm = "%{$search}%";

                $query->where(function ($q) use ($searchTerm) {
                    $q->where('token', 'like', $searchTerm)
                        ->orWhereHas('event', function ($eventQuery) use ($searchTerm) {
                            $eventQuery->where('title', 'like', $searchTerm)
                                ->orWhereHas('owner', function ($ownerQuery) use ($searchTerm) {
                                    $ownerQuery->where('name', 'like', $searchTerm)
                                        ->orWhere('email', 'like', $searchTerm);
                                });
                        });
                });
            })

            // Ordering
            ->latest('created_at')

            // Pagination dengan query string
            ->paginate(20)
            ->withQueryString();

        return view('admin.admin.tokens.index', compact('tokens'));
    }

    /**
     * ADMIN - Detail token
     */
    public function show_token(VoterToken $token)
    {
        $token->load([
            'event.owner',
            'vote.candidate',
        ]);

        return view('admin.admin.tokens.show', compact('token'));
    }

    public function index_recaps(Request $request)
    {
        $events = Event::with([
            'owner:id,name,email',
            'plan:id,name',
        ])
            ->withCount([
                'candidates',
                'votes',
                'tokens',
            ])
            ->latest()
            ->get();

        return view('admin.admin.event-recaps.index', compact('events'));
    }


    public function show_recaps(Event $event)
    {
        // Load relasi dengan optimal query
        $event->load([
            'owner:id,name,email',
            'candidates' => function ($q) {
                $q->withCount('votes')
                    ->orderByDesc('votes_count');
            }
        ]);

        // Ambil kandidat yang sudah tersortir
        $candidates = $event->candidates;

        // Hitung total votes
        $totalVotes = $event->votes()->count();

        // Tentukan pemenang
        $winner = $candidates->first();

        // Cek apakah event sudah selesai
        $isEnded = $event->end_time && now()->greaterThan($event->end_time);

        // DATA TIMELINE: Ambil voting per jam untuk chart timeline
        $timelineData = $this->getVotingTimeline($event);

        return view('admin.admin.event-recaps.show', compact(
            'event',
            'candidates',
            'totalVotes',
            'winner',
            'isEnded',
            'timelineData'
        ));
    }

    /**
     * Generate data timeline voting per kandidat berdasarkan waktu vote (voted_at)
     */
    private function getVotingTimeline(Event $event)
    {
        $startTime = $event->start_time;
        $endTime = $event->end_time ?? now();

        // Hitung durasi event dalam jam
        $durationHours = $startTime->diffInHours($endTime);

        // Tentukan interval berdasarkan durasi
        if ($durationHours <= 24) {
            $intervalHours = 3; // Setiap 3 jam untuk event 1 hari
        } elseif ($durationHours <= 168) {
            $intervalHours = 12; // Setiap 12 jam untuk event 1 minggu
        } else {
            $intervalHours = 24; // Setiap 1 hari untuk event > 1 minggu
        }

        $timeLabels = [];
        $timePoints = []; // Waktu checkpoint untuk kumulatif

        // Generate time labels
        $currentTime = $startTime->copy();

        while ($currentTime <= $endTime) {
            $timeLabels[] = $currentTime->format('d M H:i');
            $timePoints[] = $currentTime->copy();

            $currentTime->addHours($intervalHours);

            // Pastikan include endTime sebagai point terakhir
            if ($currentTime > $endTime && end($timePoints) < $endTime) {
                $timeLabels[] = $endTime->format('d M H:i');
                $timePoints[] = $endTime->copy();
                break;
            }
        }

        // Ambil data voting per kandidat per waktu (KUMULATIF dari awal)
        $candidateTimeline = [];

        foreach ($event->candidates as $candidate) {
            $voteCounts = [];

            foreach ($timePoints as $timePoint) {
                // ✅ PERBAIKAN: Hitung KUMULATIF dari START sampai timePoint
                $cumulativeVotes = $candidate->votes()
                    ->where('voted_at', '>=', $startTime->toDateTimeString())
                    ->where('voted_at', '<=', $timePoint->toDateTimeString())
                    ->count();

                $voteCounts[] = $cumulativeVotes;
            }

            $candidateTimeline[] = [
                'name' => $candidate->name,
                'data' => $voteCounts
            ];
        }

        return [
            'labels' => $timeLabels,
            'datasets' => $candidateTimeline
        ];
    }

    public function export_pdf_recaps(Event $event)
    {
        // Load relasi dengan optimal query
        $event->load([
            'owner:id,name,email',
            'candidates' => function ($q) {
                $q->withCount('votes')
                    ->orderByDesc('votes_count');
            }
        ]);

        // Ambil kandidat yang sudah tersortir
        $candidates = $event->candidates;

        // Hitung total votes
        $totalVotes = $event->votes()->count();

        // Tentukan pemenang
        $winner = $candidates->first();

        // Cek apakah event sudah selesai
        $isEnded = $event->end_time && now()->greaterThan($event->end_time);

        // DATA TIMELINE: Ambil voting per jam untuk chart timeline
        $timelineData = $this->getVotingTimeline($event);

        // Generate chart images untuk PDF
        $chartImages = $this->generateChartImages($event, $candidates, $totalVotes, $timelineData);

        // Load view PDF
        $pdf = Pdf::loadView('admin.admin.event-recaps.pdf', compact(
            'event',
            'candidates',
            'totalVotes',
            'winner',
            'isEnded',
            'timelineData',
            'chartImages'
        ));

        // Set paper size dan orientation
        $pdf->setPaper('a4', 'portrait');

        // Generate filename
        $filename = 'Rekap_Event_' . Str::slug($event->title) . '_' . now()->format('Ymd_His') . '.pdf';

        // Download PDF
        return $pdf->download($filename);
    }

    /**
     * Generate chart images untuk PDF menggunakan QuickChart API
     */


    /**
     * Generate chart images untuk PDF menggunakan QuickChart API
     * Download sebagai base64 agar bisa di-render DomPDF
     */
    private function generateChartImages($event, $candidates, $totalVotes, $timelineData)
    {
        $labels = $candidates->pluck('name')->toArray();
        $votes = $candidates->pluck('votes_count')->toArray();

        $colors = [
            'rgb(102, 126, 234)',
            'rgb(118, 75, 162)',
            'rgb(17, 153, 142)',
            'rgb(56, 239, 125)',
            'rgb(240, 147, 251)',
            'rgb(245, 87, 108)',
            'rgb(79, 172, 254)',
            'rgb(0, 242, 254)',
            'rgb(247, 112, 154)',
            'rgb(254, 225, 64)',
            'rgb(48, 207, 208)',
            'rgb(51, 8, 103)'
        ];

        // PIE CHART CONFIG
        $pieConfig = [
            'type' => 'doughnut',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'data' => $votes,
                    'backgroundColor' => array_slice($colors, 0, count($labels)),
                    'borderWidth' => 2,
                    'borderColor' => '#fff'
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => [
                        'position' => 'bottom',
                        'labels' => ['font' => ['size' => 14]]
                    ]
                ]
            ]
        ];

        // BAR CHART CONFIG
        $barConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $labels,
                'datasets' => [[
                    'label' => 'Jumlah Suara',
                    'data' => $votes,
                    'backgroundColor' => array_slice($colors, 0, count($labels)),
                ]]
            ],
            'options' => [
                'scales' => [
                    'y' => ['beginAtZero' => true, 'ticks' => ['font' => ['size' => 12]]]
                ],
                'plugins' => [
                    'legend' => ['display' => false]
                ]
            ]
        ];

        // LINE CHART CONFIG (Timeline)
        $lineDatasets = [];
        foreach ($timelineData['datasets'] as $index => $dataset) {
            $lineDatasets[] = [
                'label' => $dataset['name'],
                'data' => $dataset['data'],
                'borderColor' => $colors[$index] ?? $colors[0],
                'backgroundColor' => 'rgba(0,0,0,0)',
                'tension' => 0.4,
                'borderWidth' => 3,
                'fill' => false
            ];
        }

        $lineConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $timelineData['labels'],
                'datasets' => $lineDatasets
            ],
            'options' => [
                'scales' => [
                    'y' => ['beginAtZero' => true, 'ticks' => ['font' => ['size' => 12]]],
                    'x' => ['ticks' => ['font' => ['size' => 10]]]
                ],
                'plugins' => [
                    'legend' => [
                        'position' => 'top',
                        'labels' => ['font' => ['size' => 12]]
                    ]
                ]
            ]
        ];

        // Generate URLs
        $pieUrl = 'https://quickchart.io/chart?width=500&height=300&c=' . urlencode(json_encode($pieConfig));
        $barUrl = 'https://quickchart.io/chart?width=500&height=300&c=' . urlencode(json_encode($barConfig));
        $lineUrl = 'https://quickchart.io/chart?width=800&height=400&c=' . urlencode(json_encode($lineConfig));

        // Download images dan convert ke base64
        try {
            $pieBase64 = $this->downloadChartAsBase64($pieUrl);
            $barBase64 = $this->downloadChartAsBase64($barUrl);
            $lineBase64 = $this->downloadChartAsBase64($lineUrl);

            return [
                'pie' => $pieBase64,
                'bar' => $barBase64,
                'line' => $lineBase64
            ];
        } catch (\Exception $e) {
            // Jika gagal, return placeholder
            Log::error('Chart generation failed: ' . $e->getMessage());

            return [
                'pie' => $this->getPlaceholderImage(),
                'bar' => $this->getPlaceholderImage(),
                'line' => $this->getPlaceholderImage()
            ];
        }
    }

    /**
     * Download chart image dari URL dan convert ke base64
     */
    private function downloadChartAsBase64($url)
    {
        $response = Http::timeout(30)->get($url);

        if ($response->successful()) {
            $imageData = $response->body();
            $base64 = base64_encode($imageData);
            return 'data:image/png;base64,' . $base64;
        }

        throw new \Exception('Failed to download chart from: ' . $url);
    }

    /**
     * Generate placeholder image jika chart gagal di-load
     */
    private function getPlaceholderImage()
    {
        // Simple 1x1 transparent PNG
        $transparentPng = base64_encode(file_get_contents('data://text/plain;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNk+M9QDwADhgGAWjR9awAAAABJRU5ErkJggg=='));
        return 'data:image/png;base64,' . $transparentPng;
    }
}
