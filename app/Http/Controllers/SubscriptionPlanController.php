<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

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
}
