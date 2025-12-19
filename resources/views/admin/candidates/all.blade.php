@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        <h6 class="mb-3 text-uppercase fw-bold">Manajemen Kandidat</h6>

        @foreach ($events as $event)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <strong>{{ $event->title }}</strong>
                    <span class="badge bg-secondary">
                        {{ $event->candidates->count() }} Kandidat
                    </span>
                    <a href="{{ route('events.candidates.index', $event->id) }}">detail</a>
                    <a href="{{ route('events.candidates.create', $event->id) }}">tambah</a>
                </div>

                <div class="card-body">

                    {{-- LIST KANDIDAT --}}
                    @forelse ($event->candidates as $candidate)
                         <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">

                            <div>
                                <strong>{{ $candidate->name }}</strong>
                                <div class="text-muted small">
                                    {{ $candidate->description }}
                                </div>
                            </div>

                            <div class="d-flex gap-2">
                                {{-- EDIT --}}
                                <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#editCandidate{{ $candidate->id }}">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>

                                {{-- DELETE --}}
                                {{-- <form action="{{ route('candidates.destroy', $candidate->id) }}" method="POST"
                                    onsubmit="return confirm('Hapus kandidat ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </form> --}}
                            </div>
                        </div>

                        {{-- MODAL EDIT --}}
                        {{-- @include('admin.candidates.partials.edit', ['candidate' => $candidate]) --}}
                    @empty
                        <div class="text-muted">Belum ada kandidat</div>
                    @endforelse

                    {{-- TAMBAH KANDIDAT --}}
                    <hr>
                    {{-- @include('admin.candidates.partials.create', ['event' => $event]) --}}

                </div>
            </div>
        @endforeach

    </main>
@endsection
