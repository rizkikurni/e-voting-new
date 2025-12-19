<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Vote;
use App\Models\VoterToken;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        $totalEvents = Event::where('user_id', $userId)->count();

        $publishedEvents = Event::where('user_id', $userId)
            ->where('is_published', true)
            ->count();

        $totalCandidates = Event::where('user_id', $userId)
            ->withCount('candidates')
            ->get()
            ->sum('candidates_count');

        $totalTokens = VoterToken::whereHas('event', fn ($q) =>
            $q->where('user_id', $userId)
        )->count();

        $usedTokens = VoterToken::whereHas('event', fn ($q) =>
            $q->where('user_id', $userId)
        )->where('is_used', true)->count();

        $totalVotes = Vote::whereHas('event', fn ($q) =>
            $q->where('user_id', $userId)
        )->count();

        // Event terakhir + hasilnya
        $latestEvents = Event::where('user_id', $userId)
            ->latest()
            ->with(['candidates' => fn ($q) => $q->withCount('votes')])
            ->take(5)
            ->get();

        return view('admin.dashboard-customer', compact(
            'totalEvents',
            'publishedEvents',
            'totalCandidates',
            'totalTokens',
            'usedTokens',
            'totalVotes',
            'latestEvents'
        ));
    }
}
