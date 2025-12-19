<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Vote;
use Illuminate\Support\Facades\Auth;

class VoteController extends Controller
{
    /**
     * 1️⃣ Rekap hasil semua event milik user
     * - Judul event
     * - Pemenang
     * - Perolehan kandidat
     * - Sisa token
     */
    public function index()
    {
        $events = Event::where('user_id', Auth::id())
            ->with([
                'candidates' => function ($q) {
                    $q->withCount('votes');
                },
                'tokens'
            ])
            ->get()
            ->map(function ($event) {
                $winner = $event->candidates
                    ->sortByDesc('votes_count')
                    ->first();

                return [
                    'event'        => $event,
                    'winner'       => $winner,
                    'candidates'   => $event->candidates,
                    'total_tokens' => $event->tokens->count(),
                    'used_tokens'  => $event->tokens->where('is_used', true)->count(),
                    'remaining'    => $event->tokens->where('is_used', false)->count(),
                ];
            });

        return view('admin.votes.index', compact('events'));
    }

    /**
     * 2️⃣ Detail hasil voting per event
     */
    public function show(Event $event)
    {
        $this->authorizeOwner($event);

        $event->load([
            'candidates' => function ($q) {
                $q->withCount('votes');
            },
            'votes.candidate',
            'tokens'
        ]);

        $winner = $event->candidates
            ->sortByDesc('votes_count')
            ->first();

        return view('admin.votes.show', compact(
            'event',
            'winner'
        ));
    }
}
