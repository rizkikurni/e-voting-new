<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        // ambil 1 user_plan yang masih punya kuota
        $userPlan = Auth::user()->getAvailablePlan();

        if (!$userPlan) {
            abort(403, 'Tidak ada paket aktif dengan sisa kuota event.');
        }

        return view('admin.events.create', compact('userPlan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time'  => 'required|date',
            'end_time'    => 'required|date|after:start_time',
        ]);

        $user = Auth::user();
        $userPlan = $user->getAvailablePlan();

        if (!$userPlan || !$userPlan->hasAvailableEvent()) {
            abort(403, 'Kuota event habis.');
        }

        DB::transaction(function () use ($request, $user, $userPlan) {

            Event::create([
                'user_id'       => $user->id,
                'user_plan_id'  => $userPlan->id,
                'plan_id'       => $userPlan->plan_id, // redundant tapi konsisten
                'title'         => $request->title,
                'description'   => $request->description,
                'start_time'    => $request->start_time,
                'end_time'      => $request->end_time,
                'is_trial_event' => false,
            ]);

            // naikkan pemakaian kuota
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

        $event->load(['candidates', 'tokens', 'votes']);

        return view('admin.events.show', compact('event'));
    }

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

}
