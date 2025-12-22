<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\UserPlan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::with(['userPlan.plan'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        $userPlans = $user->plans()
            ->where('payment_status', 'paid')
            ->get()
            ->filter(fn($plan) => $plan->hasAvailableEvent());

        // Flag untuk view
        $hasActivePlan = $userPlans->isNotEmpty();

        return view('admin.events.create', compact('userPlans', 'hasActivePlan'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_plan_id' => 'required|exists:user_plans,id',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'start_time'   => 'required|date',
            'end_time'     => 'required|date|after:start_time',
        ]);

        $user = Auth::user();

        // Ambil user_plan yang dipilih, pastikan:
        // - milik user
        // - status paid
        $userPlan = UserPlan::where('id', $request->user_plan_id)
            ->where('user_id', $user->id)
            ->where('payment_status', 'paid')
            ->firstOrFail();

        // Cek kuota
        if (! $userPlan->hasAvailableEvent()) {
            abort(403, 'Kuota event pada paket ini sudah habis.');
        }

        DB::transaction(function () use ($request, $user, $userPlan) {

            Event::create([
                'user_id'        => $user->id,
                'user_plan_id'   => $userPlan->id,
                'plan_id'        => $userPlan->plan_id,
                'title'          => $request->title,
                'description'    => $request->description,
                'start_time'     => $request->start_time,
                'end_time'       => $request->end_time,
                'is_trial_event' => false,
            ]);

            // Kurangi kuota
            $userPlan->increment('used_event');
        });

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        $this->authorizeOwner($event);

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

        return view('admin.events.show', compact(
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

    public function exportPdf(Event $event)
    {
        $this->authorizeOwner($event);

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
        $pdf = Pdf::loadView('admin.events.pdf', compact(
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
     * PERBAIKAN: Convert ke base64 untuk reliability di PDF
     */
    private function generateChartImages($event, $candidates, $totalVotes, $timelineData)
    {
        $chartColors = [
            '#667eea',
            '#764ba2',
            '#11998e',
            '#38ef7d',
            '#f093fb',
            '#f5576c',
            '#4facfe',
            '#00f2fe',
            '#fa709a',
            '#fee140',
            '#30cfd0',
            '#330867'
        ];

        // Data untuk charts
        $candidateLabels = $candidates->pluck('name')->toArray();
        $candidateVotes = $candidates->pluck('votes_count')->toArray();

        // 1. PIE CHART - Simplified
        $pieConfig = [
            'type' => 'doughnut',
            'data' => [
                'labels' => $candidateLabels,
                'datasets' => [[
                    'data' => $candidateVotes,
                    'backgroundColor' => array_slice($chartColors, 0, count($candidateLabels)),
                ]]
            ],
            'options' => [
                'plugins' => [
                    'legend' => ['position' => 'bottom'],
                ]
            ]
        ];

        // 2. BAR CHART - Simplified
        $barConfig = [
            'type' => 'bar',
            'data' => [
                'labels' => $candidateLabels,
                'datasets' => [[
                    'label' => 'Suara',
                    'data' => $candidateVotes,
                    'backgroundColor' => array_slice($chartColors, 0, count($candidateLabels)),
                ]]
            ],
            'options' => [
                'scales' => ['y' => ['beginAtZero' => true]],
                'plugins' => ['legend' => ['display' => false]]
            ]
        ];

        // 3. LINE CHART - Simplified
        $lineDatasets = [];
        foreach ($timelineData['datasets'] as $index => $dataset) {
            $lineDatasets[] = [
                'label' => $dataset['name'],
                'data' => $dataset['data'],
                'borderColor' => $chartColors[$index % count($chartColors)],
                'fill' => false,
                'tension' => 0.4
            ];
        }

        $lineConfig = [
            'type' => 'line',
            'data' => [
                'labels' => $timelineData['labels'],
                'datasets' => $lineDatasets
            ],
            'options' => [
                'scales' => ['y' => ['beginAtZero' => true]],
                'plugins' => ['legend' => ['position' => 'top']]
            ]
        ];

        // Generate base64 images untuk PDF
        try {
            return [
                'pie' => $this->getChartBase64($pieConfig, 500, 300),
                'bar' => $this->getChartBase64($barConfig, 500, 300),
                'line' => $this->getChartBase64($lineConfig, 800, 400)
            ];
        } catch (\Exception $e) {
            Log::error('Chart generation failed: ' . $e->getMessage());

            // Fallback: return placeholder images
            return [
                'pie' => $this->getPlaceholderImage('Pie Chart'),
                'bar' => $this->getPlaceholderImage('Bar Chart'),
                'line' => $this->getPlaceholderImage('Line Chart')
            ];
        }
    }

    /**
     * Get chart as base64 image dari QuickChart
     */
    private function getChartBase64($config, $width, $height)
    {
        $url = 'https://quickchart.io/chart';

        // Gunakan POST untuk menghindari URL terlalu panjang
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            'width' => $width,
            'height' => $height,
            'format' => 'png',
            'chart' => $config
        ]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);

        $imageData = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode === 200 && $imageData) {
            return 'data:image/png;base64,' . base64_encode($imageData);
        }

        throw new \Exception('Failed to generate chart: HTTP ' . $httpCode);
    }

    /**
     * Generate placeholder image jika chart generation gagal
     */
    private function getPlaceholderImage($text)
    {
        // Simple SVG placeholder
        $svg = '<?xml version="1.0" encoding="UTF-8"?>
    <svg width="500" height="300" xmlns="http://www.w3.org/2000/svg">
        <rect width="500" height="300" fill="#f8f9fa" stroke="#dee2e6" stroke-width="2"/>
        <text x="250" y="150" font-family="Arial" font-size="20" fill="#6c757d" text-anchor="middle">
            ' . htmlspecialchars($text) . ' - Data tidak tersedia
        </text>
    </svg>';

        return 'data:image/svg+xml;base64,' . base64_encode($svg);
    }
    /**
     * Export PDF Recaps untuk Customer
     */
    /**
     * Export PDF Recaps untuk Customer
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        $this->authorizeOwner($event);

        if (!$event->isEditable()) {
            abort(403, 'Event tidak dapat diedit.');
        }

        return view('admin.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeOwner($event);

        if (!$event->isEditable()) {
            abort(403, 'Event tidak dapat diubah.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
        ]);

        $event->update($request->only([
            'title',
            'description',
            'start_time',
            'end_time',
        ]));

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $this->authorizeOwner($event);

        if ($event->is_published) {
            abort(403, 'Event yang sudah dipublish tidak dapat dihapus.');
        }

        DB::transaction(function () use ($event) {
            // kembalikan kuota
            $event->userPlan->decrement('used_event');
            $event->delete();
        });

        return redirect()
            ->route('events.index')
            ->with('success', 'Event berhasil dihapus.');
    }

    /* =====================================================
     | NON-RESOURCE METHODS (PERLU)
     ===================================================== */

    /**
     * Publish event (lock & publish)
     */
    public function publish(Event $event)
    {
        $this->authorizeOwner($event);

        if ($event->is_published) {
            abort(400, 'Event sudah dipublish.');
        }

        $event->update([
            'is_published' => true,
        ]);

        return back()->with('success', 'Event berhasil dipublish.');
    }

    /**
     * Force lock event (admin / owner)
     */
    public function lock(Event $event)
    {
        $this->authorizeOwner($event);

        $event->update(['is_locked' => true]);

        return back()->with('success', 'Event dikunci.');
    }

    public function adminIndex()
    {
        $events = Event::with([
            'owner:id,name,email',
            'plan:id,name',
        ])
            ->latest()
            ->get();

        return view('admin.admin.events.index', compact('events'));
    }

    /**
     * ADMIN - Detail event
     */
    public function adminShow(Event $event)
    {
        $event->load([
            'owner:id,name,email',
            'plan:id,name',
            'candidates.votes', // penting
        ]);

        // Hitung suara tiap kandidat
        $candidates = $event->candidates->map(function ($candidate) {
            $candidate->vote_count = $candidate->votes->count();
            return $candidate;
        });

        // Tentukan kandidat unggul (sementara / final)
        $winner = null;
        if ($candidates->count() > 0) {
            $winner = $candidates->sortByDesc('vote_count')->first();
        }

        // Event sudah berakhir?
        $isFinished = now()->greaterThan($event->end_time);

        return view('admin.admin.events.show', compact(
            'event',
            'candidates',
            'winner',
            'isFinished'
        ));
    }
}
