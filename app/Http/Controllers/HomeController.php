<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use App\Models\Vote;
use App\Models\VoterToken;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price', 'asc')->get();
        return view('landing.index', compact('plans'));
    }

     public function vote(Event $eventId)
    {
        $event = Event::with(['candidates.votes', 'tokens'])
            ->where('is_published', true)
            ->findOrFail($eventId);

        // status waktu event
        $isRunning = now()->between($event->start_time, $event->end_time);

        // tentukan pemenang (hanya jika event selesai)
        $winner = null;
        if (now()->greaterThan($event->end_time)) {
            $winner = $event->candidates
                ->sortByDesc(fn ($c) => $c->votes->count())
                ->first();
        }

        return view('landing.vote', [
            'event'      => $event,
            'candidates' => $event->candidates,
            'winner'     => $winner,      // null kalau belum selesai
            'isRunning'  => $isRunning,   // true kalau voting aktif
        ]);
    }

    /**
     * Simpan vote dari pemilih
     */
    public function voteStore(Request $request, $eventId)
    {
       $event = Event::with('tokens')->findOrFail($eventId);

        // validasi waktu
        if (! now()->between($event->start_time, $event->end_time)) {
            return back()->withErrors([
                'token' => 'Voting belum dimulai atau sudah berakhir.'
            ]);
        }

        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'token'        => 'required|string',
        ]);

        DB::transaction(function () use ($request, $event) {

            // cari token
            $token = VoterToken::where('event_id', $event->id)
                ->where('token', $request->token)
                ->where('is_used', false)
                ->lockForUpdate()
                ->first();

            if (! $token) {
                abort(422, 'Token tidak valid atau sudah digunakan.');
            }

            // simpan vote
            Vote::create([
                'event_id'     => $event->id,
                'candidate_id' => $request->candidate_id,
                'token_id'     => $token->id,
                'voted_at'     => now(),
            ]);

            // tandai token terpakai
            $token->update(['is_used' => true]);
        });

        return back()->with('success', 'Terima kasih, suara Anda berhasil dikirim.');
    }


    // public function vote()
    // {
    //     return view('landing.vote');
    // }
    public function voteResult()
    {
        return view('landing.vote-result');
    }
}
