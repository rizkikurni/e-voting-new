@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h5 class="mb-0 fw-bold text-uppercase">Detail Event</h5>
            <small class="text-muted">Informasi lengkap event pemilihan</small>
        </div>

        <div class="d-flex gap-2">
            @if ($event->isEditable())
                <a href="{{ route('events.edit', $event->id) }}"
                   class="btn btn-warning btn-sm radius-30">
                    <i class="bi bi-pencil-fill"></i> Edit
                </a>
            @endif

            <a href="{{ route('events.index') }}"
               class="btn btn-secondary btn-sm radius-30">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    {{-- INFO UTAMA --}}
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <div class="row g-4 align-items-start">

            {{-- KIRI: JUDUL & DESKRIPSI --}}
            <div class="col-md-8">
                <div class="mb-3">
                    <small class="text-muted fw-bold">Judul Event</small>
                    <h4 class="fw-bold mb-1">{{ $event->title }}</h4>
                </div>

                <div>
                    <small class="text-muted fw-bold">Deskripsi</small>
                    <p class="mb-0 text-muted">
                        {{ $event->description ?? 'Tidak ada deskripsi' }}
                    </p>
                </div>
            </div>

            {{-- KANAN: STATUS & WAKTU --}}
            <div class="col-md-4">
                <div class="border rounded p-3 h-100 bg-light">

                    {{-- STATUS --}}
                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block mb-1">Status Event</small>
                        @if ($event->is_locked)
                            <span class="badge bg-danger px-3 py-2">Locked</span>
                        @elseif ($event->is_published)
                            <span class="badge bg-success px-3 py-2">Published</span>
                        @else
                            <span class="badge bg-secondary px-3 py-2">Draft</span>
                        @endif
                    </div>

                    {{-- WAKTU --}}
                    <div class="mb-2">
                        <small class="text-muted fw-bold d-block">Waktu Mulai</small>
                        <div class="fw-semibold">
                            {{ $event->start_time->format('d M Y H:i') }}
                        </div>
                    </div>

                    <div>
                        <small class="text-muted fw-bold d-block">Waktu Selesai</small>
                        <div class="fw-semibold">
                            {{ $event->end_time->format('d M Y H:i') }}
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

    {{-- STATISTIK --}}
    <div class="row g-3">

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="fs-2 text-primary mb-1">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $event->candidates->count() }}</h3>
                    <small class="text-muted">Jumlah Kandidat</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="fs-2 text-warning mb-1">
                        <i class="bi bi-key-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $event->tokens->count() }}</h3>
                    <small class="text-muted">Total Token</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm text-center h-100">
                <div class="card-body">
                    <div class="fs-2 text-success mb-1">
                        <i class="bi bi-bar-chart-fill"></i>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $event->votes->count() }}</h3>
                    <small class="text-muted">Suara Masuk</small>
                </div>
            </div>
        </div>

    </div>

</main>
@endsection
