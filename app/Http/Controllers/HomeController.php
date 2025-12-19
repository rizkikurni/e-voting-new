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

    /**
     * Tampilkan halaman voting
     */
    public function vote(Event $event)
    {
        $now = now();

        $isStarted = $now->greaterThanOrEqualTo($event->start_time);
        $isEnded   = $now->greaterThan($event->end_time);
        $isRunning = $isStarted && !$isEnded;


        // Ambil kandidat
        $candidates = $event->candidates;

        // Hitung pemenang (jika event selesai)
        $winner = null;
        if ($now->gt($event->end_time)) {
            $winner = $event->candidates()
                ->withCount(['votes'])
                ->orderByDesc('votes_count')
                ->first();
        }
        // dd($event,$candidates,$winner,$isRunning);
        // dd($isRunning,$isStarted,$isEnded);
        // dd($event->start_time, $event->end_time);
        // dd($now);

        return view('landing.vote', [
            'event'      => $event,
            'candidates' => $candidates,
            'winner'     => $winner,
            'isRunning'  => $isRunning,
            'isStarted'  => $isStarted,
            'isEnded'  => $isEnded,
        ]);
    }

    /**
     * Proses submit vote
     */
    public function voteStore(Request $request, Event $event)
    {
        $request->validate([
            'candidate_id' => 'required|exists:candidates,id',
            'token'        => 'required|string',
        ]);

        $candidate = Candidate::where('id', $request->candidate_id)
            ->where('event_id', $event->id)
            ->firstOrFail();

        $token = VoterToken::where('token', $request->token)
            ->where('event_id', $event->id)
            ->first();

        if (!$token) {
            return back()->withErrors(['token' => 'Token tidak valid.']);
        }

        if ($token->is_used) {
            return back()->withErrors(['token' => 'Token sudah digunakan.']);
        }

        $now = Carbon::now();
        if (!$now->between($event->start_time, $event->end_time)) {
            return back()->withErrors(['event' => 'Voting belum dimulai atau sudah berakhir.']);
        }

        // Simpan vote
        Vote::create([
            'event_id'     => $event->id,
            'candidate_id' => $candidate->id,
            'token_id'     => $token->id,
            'voted_at'     => $now,
        ]);

        // Tandai token sudah digunakan
        $token->update(['is_used' => true]);

        return redirect()->back()->with('success', 'Suara berhasil dikirim.');
    }


    public function voteResult(Event $event)
    {
         // Ambil semua kandidat + jumlah vote
        $candidates = Candidate::withCount([
                'votes as votes_count' => function ($q) use ($event) {
                    $q->where('event_id', $event->id);
                }
            ])
            ->where('event_id', $event->id)
            ->orderByDesc('votes_count')
            ->get();

        // Total suara
        $totalVotes = $candidates->sum('votes_count');

        // Hitung persentase per kandidat
        $results = $candidates->map(function ($candidate) use ($totalVotes) {
            $candidate->percentage = $totalVotes > 0
                ? round(($candidate->votes_count / $totalVotes) * 100, 1)
                : 0;

            return $candidate;
        });

        // Tentukan pemenang (jika voting sudah selesai)
        $winner = null;
        if (now()->greaterThan($event->end_time) && $results->count() > 0) {
            $winner = $results->first(); // karena sudah orderByDesc
        }

        return view('landing.vote-result', [
            'event'       => $event,
            'results'     => $results,
            'totalVotes'  => $totalVotes,
            'winner'      => $winner,
        ]);

    }
}
