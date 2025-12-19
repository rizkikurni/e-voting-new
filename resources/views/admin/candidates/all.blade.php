@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Manajemen Kandidat</h6>
                <small class="text-muted">Kelola kandidat berdasarkan event</small>
            </div>
        </div>

        {{-- ALERT --}}
<x-alert></x-alert>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="example2">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th>Event</th>
                                <th width="180">Jumlah Kandidat</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($events as $event)
                                <tr>
                                    {{-- EVENT --}}
                                    <td>
                                        <strong>{{ $event->title }}</strong>
                                    </td>

                                    {{-- JUMLAH KANDIDAT --}}
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            {{ $event->candidates->count() }} Kandidat
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- DETAIL --}}
                                            <a href="{{ route('events.candidates.index', $event->id) }}"
                                                class="btn btn-outline-primary btn-sm"
                                                title="Detail Kandidat">
                                                <i class="bi bi-eye-fill"></i>
                                                Detail
                                            </a>

                                            {{-- TAMBAH --}}
                                            <a href="{{ route('events.candidates.create', $event->id) }}"
                                                class="btn btn-outline-success btn-sm"
                                                title="Tambah Kandidat">
                                                <i class="bi bi-plus-circle"></i>
                                                Tambah
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted">
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
