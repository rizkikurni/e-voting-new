<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Vote;
use App\Models\Event;
use App\Models\Payment;
use App\Models\UserPlan;
use App\Models\Candidate;
use App\Models\VoterToken;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
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

        $totalTokens = VoterToken::whereHas(
            'event',
            fn($q) =>
            $q->where('user_id', $userId)
        )->count();

        $usedTokens = VoterToken::whereHas(
            'event',
            fn($q) =>
            $q->where('user_id', $userId)
        )->where('is_used', true)->count();

        $totalVotes = Vote::whereHas(
            'event',
            fn($q) =>
            $q->where('user_id', $userId)
        )->count();

        // Event terakhir + hasilnya
        $latestEvents = Event::where('user_id', $userId)
            ->latest()
            ->with(['candidates' => fn($q) => $q->withCount('votes')])
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

    public function admin(Request $request)
    {
        // =============================
        // VALIDASI FILTER TANGGAL
        // =============================
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date|after_or_equal:start_date',
        ]);

        // =============================
        // RANGE TANGGAL (GLOBAL FILTER)
        // =============================
        $startDate = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $endDate = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfDay();

        // =============================
        // STATISTIK UTAMA
        // =============================

        // Total customer (role customer)
        $totalCustomers = User::where('role', 'customer')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Total event
        $totalEvents = Event::whereBetween('created_at', [$startDate, $endDate])->count();

        // Event aktif
        $activeEvents = Event::where('is_published', true)
            ->where('is_locked', false)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Trial event
        $trialEvents = Event::where('is_trial_event', true)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->count();

        // Total vote
        $totalVotes = Vote::whereBetween('created_at', [$startDate, $endDate])->count();

        // =============================
        // PEMBAYARAN & PENDAPATAN
        // =============================

        // Total pendapatan (paid only)
        $totalRevenue = Payment::whereIn('transaction_status', ['settlement', 'capture'])
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->sum('amount');

        // Pembayaran terakhir
        $latestPayments = Payment::with(['user', 'plan'])
            ->whereBetween('created_at', [$startDate, $endDate])
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // =============================
        // SUBSCRIPTION PLAN
        // =============================

        // Plan paling laku
        $topPlans = UserPlan::selectRaw('plan_id, COUNT(*) as total')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('plan_id')
            ->with('plan')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Distribusi user plan (DONUT CHART)
        $planDistribution = UserPlan::selectRaw('plan_id, COUNT(*) as total')
            ->where('payment_status', 'paid')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('plan_id')
            ->with('plan:id,name')
            ->get()
            ->map(fn($item) => [
                'plan'  => $item->plan->name ?? 'Unknown',
                'total' => $item->total,
            ]);

        // =============================
        // CHART PENDAPATAN (LINE CHART)
        // =============================
        $revenueChart = Payment::selectRaw('DATE(paid_at) as date, SUM(amount) as total')
            ->whereIn('transaction_status', ['settlement', 'capture'])
            ->whereBetween('paid_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // =============================
        // AKTIVITAS TERBARU
        // =============================

        // Customer terbaru
        $latestCustomers = User::where('role', 'customer')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // Event terbaru
        $latestEvents = Event::with('owner')
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        // =============================
        // RESPONSE KE VIEW
        // =============================
        return view('admin.admin.dashboard.index', [
            'startDate' => $startDate,
            'endDate'   => $endDate,

            // Statistik
            'totalCustomers' => $totalCustomers,
            'totalEvents'    => $totalEvents,
            'activeEvents'   => $activeEvents,
            'trialEvents'    => $trialEvents,
            'totalVotes'     => $totalVotes,
            'totalRevenue'   => $totalRevenue,

            // Subscription
            'topPlans'        => $topPlans,
            'planDistribution' => $planDistribution,

            // Chart
            'revenueChart' => $revenueChart,

            // Aktivitas
            'latestPayments' => $latestPayments,
            'latestCustomers' => $latestCustomers,
            'latestEvents'   => $latestEvents,
        ]);
    }
}
