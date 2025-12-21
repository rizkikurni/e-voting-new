@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Rekap Voting Event</h6>
                <small class="text-muted">Ringkasan seluruh event dan hasil voting</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example2" class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Judul Event</th>
                                <th>Penyelenggara</th>
                                <th>Paket</th>
                                <th>Kandidat</th>
                                <th>Token</th>
                                <th>Suara Masuk</th>
                                <th>Status</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($events as $event)
                                <tr>

                                    {{-- JUDUL EVENT --}}
                                    <td class="fw-semibold">
                                        {{ $event->title }}
                                    </td>

                                    {{-- PENYELENGGARA --}}
                                    <td>
                                        {{ $event->owner?->name ?? '-' }} <br>
                                        <small class="text-muted">
                                            {{ $event->owner?->email ?? '' }}
                                        </small>
                                    </td>

                                    {{-- PLAN --}}
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            {{ $event->plan?->name ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- KANDIDAT --}}
                                    <td class="text-center">
                                        {{ $event->candidates_count }}
                                    </td>

                                    {{-- TOKEN --}}
                                    <td class="text-center">
                                        {{ $event->tokens_count }}
                                    </td>

                                    {{-- SUARA --}}
                                    <td class="text-center fw-semibold">
                                        {{ $event->votes_count }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="text-center">
                                        @if ($event->is_locked)
                                            <span class="badge bg-danger">Locked</span>
                                        @elseif ($event->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <a href="{{ route('event-recaps.show', $event->id) }}"
                                            class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                            title="Lihat Rekap Voting">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Belum ada event
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
