@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Detail Hasil Voting</h6>
                <small class="text-muted">{{ $event->title }}</small>
            </div>

            <a href="{{ route('votes.index') }}" class="btn btn-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

       {{-- PEMENANG --}}
<div class="card mb-4 shadow-sm border-0">
    <div class="card-body text-center p-4">

        <div class="mb-2 text-uppercase text-muted fw-semibold">
            Pemenang Voting
        </div>

        @if ($winner)

            {{-- FOTO --}}
            <div class="position-relative d-inline-block mb-3">
                <img src="{{ $winner->photo
                        ? asset('storage/'.$winner->photo)
                        : asset('landing/img/speaker_1.png') }}"
                     class="rounded-circle border border-3 border-success"
                     style="width:150px; height:150px; object-fit:cover;">

                {{-- ICON TROPHY --}}
                <span class="position-absolute bottom-0 end-0 translate-middle p-2 bg-success rounded-circle">
                    <i class="bi bi-trophy-fill text-white"></i>
                </span>
            </div>

            {{-- NAMA --}}
            <h3 class="fw-bold text-success mb-1">
                {{ $winner->name }}
            </h3>

            {{-- SUBTITLE --}}
            <small class="text-muted d-block mb-3">
                Kandidat dengan suara terbanyak
            </small>

            {{-- SUARA --}}
            <div class="d-inline-flex align-items-center gap-2 px-4 py-2
                        rounded-pill bg-light-success">
                <i class="bi bi-bar-chart-fill text-success fs-5"></i>
                <span class="fw-bold text-success fs-5">
                    {{ $winner->votes_count }} suara
                </span>
            </div>

        @else
            <div class="py-4">
                <i class="bi bi-hourglass-split fs-1 text-secondary mb-2"></i>
                <p class="mb-0 text-muted fw-semibold">
                    Belum ada suara masuk
                </p>
            </div>
        @endif

    </div>
</div>


        {{-- PEROLEHAN --}}
        <div class="card mb-3">
            <div class="card-body">

                <h6 class="mb-3">Perolehan Suara</h6>

                <table class="table table-bordered table-striped align-middle" id="example2">
                    <thead class="table-primary">
                        <tr>
                            <th class="text-center">Kandidat</th>
                            <th class="text-center">Jumlah Suara</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($event->candidates as $candidate)
                            <tr>
                                <td class="text-center">

                                    {{ $candidate->name }}
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        {{ $candidate->votes_count }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        {{-- STATISTIK TOKEN --}}
<div class="card shadow-sm border-0 mb-4">
    <div class="card-body">

        <div class="d-flex align-items-center mb-3">
            <i class="bi bi-key-fill fs-4 text-primary me-2"></i>
            <h6 class="mb-0 fw-bold text-uppercase">Statistik Token</h6>
        </div>

        <div class="row g-3 text-center">

            {{-- TOTAL --}}
            <div class="col-md-4">
                <div class="p-4 rounded bg-light-primary h-100">
                    <i class="bi bi-collection fs-2 text-primary mb-2"></i>
                    <div class="fw-semibold text-muted">Total Token</div>
                    <h3 class="fw-bold text-primary mb-0">
                        {{ $event->tokens->count() }}
                    </h3>
                </div>
            </div>

            {{-- DIGUNAKAN --}}
            <div class="col-md-4">
                <div class="p-4 rounded bg-light-success h-100">
                    <i class="bi bi-check-circle-fill fs-2 text-success mb-2"></i>
                    <div class="fw-semibold text-muted">Digunakan</div>
                    <h3 class="fw-bold text-success mb-0">
                        {{ $event->tokens->where('is_used', true)->count() }}
                    </h3>
                </div>
            </div>
            
            {{-- SISA --}}
            <div class="col-md-4">
                <div class="p-4 rounded bg-light-warning h-100">
                    <i class="bi bi-hourglass-split fs-2 text-warning mb-2"></i>
                    <div class="fw-semibold text-muted">Sisa Token</div>
                    <h3 class="fw-bold text-warning mb-0">
                        {{ $event->tokens->where('is_used', false)->count() }}
                    </h3>
                </div>
            </div>

        </div>

    </div>
</div>


    </main>
@endsection
