@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="d-flex justify-content-between mb-3">
        <h6 class="mb-0 text-uppercase">Detail Kandidat</h6>
        <a href="{{ route('events.candidates.index', $event->id) }}"
           class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body text-center">

            @if ($candidate->photo)
                <img src="{{ asset('storage/' . $candidate->photo) }}"
                     class="rounded mb-3" width="120">
            @endif

            <h5>{{ $candidate->name }}</h5>
            <p class="text-muted">{{ $candidate->description ?? '-' }}</p>

            <span class="badge bg-primary">
                {{ $candidate->votes_count ?? $candidate->votes->count() }} Suara
            </span>

        </div>
    </div>

</main>
@endsection
