@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="mb-0 text-uppercase fw-bold">Detail Kandidat</h6>
            <small class="text-muted">Informasi lengkap kandidat</small>
        </div>

        <a href="{{ route('events.candidates.index', $event->id) }}"
           class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1">
            <i class="bi bi-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-6">

            <div class="card shadow-sm">
                <div class="card-body text-center p-4">

                    {{-- FOTO --}}
                    <div class="mb-3">
                        <img src="{{ $candidate->photo
                                ? asset('storage/'.$candidate->photo)
                                : asset('landing/img/speaker_placeholder.png') }}"
                             class="rounded-circle border"
                             style="width:140px; height:140px; object-fit:cover;">
                    </div>

                    {{-- NAMA --}}
                    <h4 class="fw-bold mb-1">
                        {{ $candidate->name }}
                    </h4>

                    {{-- DESKRIPSI --}}
                    <p class="text-muted mb-3">
                        {{ $candidate->description ?? 'Tidak ada deskripsi' }}
                    </p>

                    <hr>

                    {{-- STATISTIK --}}
                    <div class="row text-center">

                        <div class="col-12">
                            <div class="p-3 rounded bg-light">
                                <h3 class="fw-bold mb-0 text-primary">
                                    {{ $candidate->votes_count ?? $candidate->votes->count() }}
                                </h3>
                                <small class="text-muted">
                                    Total Suara
                                </small>
                            </div>
                        </div>

                    </div>

                </div>
            </div>

        </div>
    </div>

</main>
@endsection
