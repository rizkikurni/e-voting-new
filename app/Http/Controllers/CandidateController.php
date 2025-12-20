<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Candidate;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class CandidateController extends Controller
{

    /**
     * Menampilkan semua event + kandidatnya
     */
    public function all()
    {
        $events = Event::with('candidates')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($events);

        return view('admin.candidates.all', compact('events'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Event $event)
    {
        $this->authorizeOwner($event);

        $candidates = $event->candidates()->withCount('votes')->get();

        return view('admin.candidates.index', compact('event', 'candidates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Event $event)
    {
        $this->authorizeOwner($event);

        if (! $event->isEditable()) {
            abort(403, 'Event sudah dipublish atau dikunci.');
        }

        return view('admin.candidates.create', compact('event'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Event $event)
    {
        $this->authorizeOwner($event);

        if (! $event->isEditable()) {
            abort(403);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'description');
        $data['event_id'] = $event->id;

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')
                ->store('candidates', 'public');
        }

        Candidate::create($data);

        return redirect()
            ->route('events.candidates.index', $event->id)
            ->with('success', 'Kandidat berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Event $event, Candidate $candidate)
    {
        $this->authorizeOwner($event);

        if ($candidate->event_id !== $event->id) {
            abort(404);
        }

        $candidate->loadCount('votes');

        return view('admin.candidates.show', compact('event', 'candidate'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event, Candidate $candidate)
    {
        $this->authorizeOwner($event);

        if (! $event->isEditable()) {
            abort(403);
        }

        if ($candidate->event_id !== $event->id) {
            abort(404);
        }

        return view('admin.candidates.edit', compact('event', 'candidate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Event $event, Candidate $candidate)
    {
        $this->authorizeOwner($event);

        if (! $event->isEditable()) {
            abort(403);
        }

        if ($candidate->event_id !== $event->id) {
            abort(404);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'photo'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'description');

        if ($request->hasFile('photo')) {
            if ($candidate->photo) {
                Storage::disk('public')->delete($candidate->photo);
            }

            $data['photo'] = $request->file('photo')
                ->store('candidates', 'public');
        }

        $candidate->update($data);

        return redirect()
            ->route('events.candidates.index', $event->id)
            ->with('success', 'Kandidat berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event, Candidate $candidate)
    {
        $this->authorizeOwner($event);

        if (! $event->isEditable()) {
            abort(403);
        }

        if ($candidate->event_id !== $event->id) {
            abort(404);
        }

        if ($candidate->photo) {
            Storage::disk('public')->delete($candidate->photo);
        }

        $candidate->delete();

        return back()->with('success', 'Kandidat berhasil dihapus');
    }

    public function index_admin()
    {
        $candidates = Candidate::with([
            'event:id,user_id,title,start_time,end_time,is_published',
            'event.owner:id,name,email',
        ])
            ->withCount('votes')
            ->latest()
            ->get();

        return view('admin.admin.candidates.index', compact('candidates'));
    }


    /**
     * ADMIN - Detail kandidat
     */
    public function show_admin(Candidate $candidate)
    {
        $candidate->load([
            'event:id,user_id,title,description,start_time,end_time,is_published',
            'event.owner:id,name,email',
            'votes',
        ]);

        $now = now();

        $isEnded = $candidate->event->end_time
            && $now->greaterThan($candidate->event->end_time);

        $totalVotes = $candidate->event->votes()->count();
        $candidateVotes = $candidate->votes()->count();

        $winner = $candidate->event
            ->candidates()
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->first();

        $isWinner = $winner && $winner->id === $candidate->id;

        $percentage = $totalVotes > 0
            ? round(($candidateVotes / $totalVotes) * 100, 2)
            : 0;

        // Data untuk grafik perbandingan semua kandidat
        $allCandidates = $candidate->event
            ->candidates()
            ->withCount('votes')
            ->get();

        $sortedCandidates = $allCandidates
            ->sortByDesc('votes_count')
            ->values();

        // Ambil suara kandidat ini
        $currentVotes = $candidateVotes;

        // Kandidat dengan suara lebih besar
        $higherVotesCount = $sortedCandidates
            ->where('votes_count', '>', $currentVotes)
            ->count();

        // Ranking = jumlah kandidat dengan suara lebih besar + 1
        $rank = $higherVotesCount + 1;

        // Cek draw (suara sama, tapi bukan dirinya sendiri)
        $drawCandidates = $sortedCandidates
            ->where('votes_count', $currentVotes)
            ->where('id', '!=', $candidate->id)
            ->values();

        $isDraw = $drawCandidates->count() > 0;


        return view('admin.admin.candidates.show', compact(
            'candidate',
            'candidateVotes',
            'totalVotes',
            'percentage',
            'winner',
            'isWinner',
            'isEnded',
            'allCandidates',
            'rank',
            'isDraw',
            'drawCandidates'
        ));
    }

    public function export(Candidate $candidate)
    {
        $candidate->load([
            'event:id,user_id,title,description,start_time,end_time,is_published',
            'event.owner:id,name,email',
            'votes',
        ]);

        $now = now();
        $isEnded = $candidate->event->end_time
            && $now->greaterThan($candidate->event->end_time);

        $totalVotes = $candidate->event->votes()->count();
        $candidateVotes = $candidate->votes()->count();

        $winner = $candidate->event
            ->candidates()
            ->withCount('votes')
            ->orderByDesc('votes_count')
            ->first();

        $isWinner = $winner && $winner->id === $candidate->id;

        $percentage = $totalVotes > 0
            ? round(($candidateVotes / $totalVotes) * 100, 2)
            : 0;

        $allCandidates = $candidate->event
            ->candidates()
            ->withCount('votes')
            ->get();

        // Generate PDF menggunakan DomPDF - Gunakan Facade dengan namespace lengkap
        $pdf = Pdf::loadView('admin.admin.candidates.pdf', compact(
            'candidate',
            'candidateVotes',
            'totalVotes',
            'percentage',
            'isWinner',
            'isEnded',
            'allCandidates'
        ));

        $filename = 'kandidat-' . Str::slug($candidate->name) . '-' . date('YmdHis') . '.pdf';

        return $pdf->download($filename);
    }
}
