<?php

namespace App\Http\Controllers;

use App\Models\UserPlan;
use Illuminate\Http\Request;
use App\Models\SubscriptionPlan;
use Illuminate\Support\Facades\Auth;

class SubscriptionPlanController extends Controller
{
    public function index()
    {
        $plans = SubscriptionPlan::latest()->get();
        return view('admin.subscription-plans.index', compact('plans'));
    }

    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string',
            'price'          => 'required|numeric',
            'max_event'      => 'required|integer|min:1',
            'max_candidates' => 'required|integer|min:1',
            'max_voters'     => 'required|integer|min:1',
            'is_recommended' => 'required|in:yes,no'
        ]);

        // Samakan dengan seeder (boolean feature)
        $features = [
            'report' => $request->has('feature_report'),
            'export' => $request->has('feature_export'),
            'custom' => $request->has('feature_custom'),
        ];

        SubscriptionPlan::create([
            'name'           => $request->name,
            'price'          => $request->price,
            'features'       => $features,
            'max_event'      => $request->max_event,
            'max_candidates' => $request->max_candidates,
            'max_voters'     => $request->max_voters,
            'is_recommended' => $request->is_recommended,
        ]);

        return redirect()
            ->route('subscription-plans.index')
            ->with('success', 'Subscription plan berhasil ditambahkan');
    }

    public function show(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.show', compact('subscriptionPlan'));
    }

    public function edit(SubscriptionPlan $subscriptionPlan)
    {
        return view('admin.subscription-plans.edit', compact('subscriptionPlan'));
    }

    public function update(Request $request, SubscriptionPlan $subscriptionPlan)
    {
        $request->validate([
            'name'           => 'required|string',
            'price'          => 'required|numeric',
            'max_event'      => 'required|integer|min:1',
            'max_candidates' => 'required|integer|min:1',
            'max_voters'     => 'required|integer|min:1',
            'is_recommended' => 'required|in:yes,no'
        ]);

        $features = [
            'report' => $request->has('feature_report'),
            'export' => $request->has('feature_export'),
            'custom' => $request->has('feature_custom'),
        ];

        $subscriptionPlan->update([
            'name'           => $request->name,
            'price'          => $request->price,
            'features'       => $features,
            'max_event'      => $request->max_event,
            'max_candidates' => $request->max_candidates,
            'max_voters'     => $request->max_voters,
            'is_recommended' => $request->is_recommended,
        ]);

        return redirect()
            ->route('subscription-plans.index')
            ->with('success', 'Subscription plan berhasil diperbarui');
    }

    public function destroy(SubscriptionPlan $subscriptionPlan)
    {
        $subscriptionPlan->delete();

        return redirect()
            ->route('subscription-plans.index')
            ->with('success', 'Subscription plan berhasil dihapus');
    }

    public function subscriptions()
    {
        $userPlans = UserPlan::with('plan')
            ->where('user_id', Auth::id())
            ->where('payment_status', 'paid')
            ->orderByDesc('purchased_at')
            ->get()
            ->map(function ($userPlan) {

                $maxEvent   = $userPlan->plan->max_event;
                $usedEvent  = $userPlan->used_event;
                $remaining  = max($maxEvent - $usedEvent, 0);
                $percentage = $maxEvent > 0
                    ? round(($usedEvent / $maxEvent) * 100)
                    : 0;

                return [
                    'id'            => $userPlan->id,
                    'plan_name'     => $userPlan->plan->name,
                    'max_event'     => $maxEvent,
                    'used_event'    => $usedEvent,
                    'remaining'     => $remaining,
                    'percentage'    => $percentage,
                    'purchased_at'  => $userPlan->purchased_at,
                    'is_available'  => $remaining > 0,
                ];
            });

        return view('admin.subscriptions.index', compact('userPlans'));
    }

    public function plans()
    {
        $user = Auth::user();

        $plans = SubscriptionPlan::with(['userPlans' => function ($q) use ($user) {
            $q->where('user_id', $user->id)
                ->where('payment_status', 'paid');
        }])->get();

        $plans = $plans->map(function ($plan) {

            $count = $plan->userPlans->count();
            $totalQuota = $count * $plan->max_event;
            $used = $plan->userPlans->sum('used_event');
            $remaining = max($totalQuota - $used, 0);

            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'price' => $plan->price,
                'features' => $plan->features,
                'max_event' => $plan->max_event,
                'max_candidates' => $plan->max_candidates,
                'max_voters' => $plan->max_voters,

                // STACK INFO
                'owned_count' => $count,
                'total_quota' => $totalQuota,
                'used_event' => $used,
                'remaining' => $remaining,
                'percentage' => $totalQuota > 0
                    ? round(($used / $totalQuota) * 100)
                    : 0,
            ];
        });

        return view('admin.subscriptions.plans', compact('plans'));
    }
}
