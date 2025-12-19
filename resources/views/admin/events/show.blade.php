@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-uppercase">Detail Event</h6>

        <div>
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

    <hr />

    {{-- INFO UTAMA --}}
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-4">

                <div class="col-md-12">
                    <label class="fw-bold">Judul Event</label>
                    <div class="form-control bg-light">
                        {{ $event->title }}
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="fw-bold">Deskripsi</label>
                    <div class="form-control bg-light" style="min-height:90px;">
                        {{ $event->description ?? '-' }}
                    </div>
                </div>

                <div class="col-md-12">
                    <label class="fw-bold">Status</label>
                    <div class="form-control bg-light">
                        @if ($event->is_locked)
                            <span class="badge bg-danger">Locked</span>
                        @elseif ($event->is_published)
                            <span class="badge bg-success">Published</span>
                        @else
                            <span class="badge bg-secondary">Draft</span>
                        @endif
                    </div>
                </div>


                <div class="col-md-6">
                    <label class="fw-bold">Waktu Mulai</label>
                    <div class="form-control bg-light">
                        {{ $event->start_time->format('d M Y H:i') }}
                    </div>
                </div>

                <div class="col-md-6">
                    <label class="fw-bold">Waktu Selesai</label>
                    <div class="form-control bg-light">
                        {{ $event->end_time->format('d M Y H:i') }}
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- RINGKASAN DATA --}}
    <div class="row">

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="mb-0">{{ $event->candidates->count() }}</h3>
                    <small class="text-muted">Jumlah Kandidat</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="mb-0">{{ $event->tokens->count() }}</h3>
                    <small class="text-muted">Total Token</small>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h3 class="mb-0">{{ $event->votes->count() }}</h3>
                    <small class="text-muted">Suara Masuk</small>
                </div>
            </div>
        </div>

    </div>

</main>
@endsection
