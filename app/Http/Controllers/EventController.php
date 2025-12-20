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
        $user = Auth::user();

        // Ambil semua user_plan milik user yang:
        // - status paid
        // - masih punya sisa kuota event
        $userPlans = $user->plans()
            ->where('payment_status', 'paid')
            ->get()
            ->filter(fn($plan) => $plan->hasAvailableEvent());

        if ($userPlans->isEmpty()) {
            abort(403, 'Tidak ada paket aktif dengan sisa kuota event.');
        }

        return view('admin.events.create', compact('userPlans'));
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
