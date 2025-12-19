<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\VoterToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VoterTokenController extends Controller
{
    /**
     * 1️⃣ Tampilkan semua event + total token & terpakai
     */
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->withCount([
                'tokens as total_tokens',
                'tokens as used_tokens' => function ($q) {
                    $q->where('is_used', true);
                }
            ])
            ->get();

        return view('admin.voter_tokens.index', compact('events'));
    }

    /**
     * 2️⃣ Detail token berdasarkan event
     */
    public function show(Event $event)
    {
        $this->authorizeOwner($event);

        $tokens = $event->tokens()->latest()->get();

        return view('admin.voter_tokens.show', compact('event', 'tokens'));
    }

    public function create(Event $event)
    {
        $this->authorizeOwner($event);

        // total token sekarang
        $currentTotal = $event->tokens()->count();

        // batas maksimal dari paket
        $maxVoters = $event->userPlan->plan->max_voters;

        if ($currentTotal >= $maxVoters) {
            abort(403, 'Jumlah token sudah mencapai batas paket.');
        }

        $remaining = $maxVoters - $currentTotal;

        return view('admin.voter_tokens.create', compact(
            'event',
            'currentTotal',
            'maxVoters',
            'remaining'
        ));
    }


    /**
     * 3️⃣ Generate token awal
     */
    public function store(Request $request, Event $event)
    {
        $this->authorizeOwner($event);

        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $this->generateTokens($event, $request->amount);

        return back()->with('success', 'Token berhasil digenerate');
    }

    /**
 * Tampilkan form tambah token
 */
public function addView(Event $event)
{
    $this->authorizeOwner($event);

    $currentTotal = $event->tokens()->count();
    $maxVoters    = $event->userPlan->plan->max_voters;

    if ($currentTotal >= $maxVoters) {
        abort(403, 'Jumlah token sudah mencapai batas paket.');
    }

    $remaining = $maxVoters - $currentTotal;

    return view('admin.voter_tokens.add', compact(
        'event',
        'currentTotal',
        'maxVoters',
        'remaining'
    ));
}

    /**
     * 4️⃣ Tambah token jika belum mencapai batas
     */
    public function add(Request $request, Event $event)
    {
        $this->authorizeOwner($event);

        $request->validate([
            'amount' => 'required|integer|min:1',
        ]);

        $this->generateTokens($event, $request->amount);

        return back()->with('success', 'Token berhasil ditambahkan');
    }

    /**
     * ==============================
     * HELPER: Generate token AMAN
     * ==============================
     */
    protected function generateTokens(Event $event, int $amount)
    {
        $userPlan = $event->userPlan;
        $maxVoters = $userPlan->plan->max_voters;

        $currentCount = $event->tokens()->count();

        if ($currentCount + $amount > $maxVoters) {
            abort(403, 'Jumlah token melebihi batas paket.');
        }

        $length = 6;

        for ($i = 0; $i < $amount; $i++) {

            do {
                $token = strtoupper(Str::random($length));

                // jika kombinasi mulai penuh, naikkan panjang token
                if (VoterToken::where('token', $token)->exists()) {
                    $length++;
                }
            } while (VoterToken::where('token', $token)->exists());

            VoterToken::create([
                'event_id' => $event->id,
                'token'    => $token,
            ]);
        }
    }
}
