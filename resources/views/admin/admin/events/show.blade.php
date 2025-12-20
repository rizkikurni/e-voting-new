@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- BACK --}}
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
                ← Kembali
            </a>

            {{-- LINK VOTING --}}
            <a href="{{ route('voting.show', $event->id) }}" target="_blank"
                class="btn btn-primary btn-sm d-flex align-items-center gap-2">
                <i class="bi bi-box-arrow-up-right"></i>
                Buka Halaman Voting
            </a>
        </div>

        {{-- INFO EVENT --}}
        <div class="card mb-4">
            <div class="card-body">

                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <h4 class="fw-bold mb-1">{{ $event->title }}</h4>
                        <p class="text-muted mb-2">{{ $event->description }}</p>
                    </div>

                    {{-- STATUS EVENT --}}
                    <div class="text-end">
                        @if ($isFinished)
                            <span class="badge bg-dark px-3 py-2">Event Berakhir</span>
                        @else
                            <span class="badge bg-info px-3 py-2">Sedang Berjalan</span>
                        @endif
                    </div>
                </div>

                <hr>

                <div class="row">
                    <div class="col-md-4">
                        <small class="text-muted">Owner</small>
                        <p class="mb-0 fw-semibold">{{ $event->owner->name }}</p>
                        <small>{{ $event->owner->email }}</small>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Plan Digunakan</small>
                        <p class="mb-0 fw-semibold">{{ $event->plan?->name ?? '-' }}</p>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Periode Event</small>
                        <p class="mb-0">
                            {{ $event->start_time?->format('d M Y') }} –
                            {{ $event->end_time?->format('d M Y') }}
                        </p>
                    </div>
                </div>

            </div>
        </div>

        {{-- HASIL VOTING --}}
        <div class="card">
            <div class="card-body">

                <h5 class="fw-bold mb-3">Hasil Voting Kandidat</h5>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th width="80">Foto</th>
                                <th>Nama Kandidat</th>
                                <th width="150">Jumlah Suara</th>
                                <th width="200">Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($candidates as $candidate)
                                <tr
                                    class="text-center
                                {{ $winner && $candidate->id === $winner->id ? 'table-success' : '' }}">

                                    {{-- FOTO --}}
                                    <td>
                                        @if ($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}" width="60"
                                                height="60" class="rounded-circle object-fit-cover">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- NAMA --}}
                                    <td class="fw-semibold">
                                        {{ $candidate->name }}
                                    </td>

                                    {{-- JUMLAH SUARA --}}
                                    <td>
                                        <span class="fw-bold fs-6">
                                            {{ $candidate->vote_count }}
                                        </span>
                                    </td>

                                    {{-- STATUS --}}
                                    <td>
                                        @if ($winner && $candidate->id === $winner->id)
                                            @if ($isFinished)
                                                <span class="badge bg-success px-3 py-2">
                                                    🏆 Pemenang
                                                </span>
                                            @else
                                                <span class="badge bg-warning px-3 py-2">
                                                    Unggul Sementara
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge bg-secondary px-3 py-2">
                                                -
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Belum ada kandidat
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </main>
@endsection
