@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Voter Token</h6>
                <small class="text-muted">Ringkasan token per event</small>
            </div>
        </div>

            <x-alert/>


        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="example2">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th>Judul Event</th>
                                <th>Link Event</th>
                                <th>Total Token</th>
                                <th>Sudah Digunakan</th>
                                <th>Sisa Token</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>
                                    <td class="text-center">
    <a href="{{ route('voting.show', $event->id) }}" target="_blank">
        {{ route('voting.show', $event->id) }}
    </a>
</td>


                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            {{ $event->total_tokens }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            {{ $event->used_tokens }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            {{ $event->total_tokens - $event->used_tokens }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('voter-tokens.show', $event->id) }}"
                                            class="btn btn-outline-primary btn-sm" title="Detail Token">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        {{-- GENERATE TOKEN AWAL (jika belum ada token sama sekali) --}}
                                        @if ($event->total_tokens == 0)
                                            <a href="{{ route('voter-tokens.create', $event->id) }}"
                                                class="btn btn-outline-success btn-sm" title="Generate Token">
                                                <i class="bi bi-plus-circle"></i>
                                            </a>
                                        @endif

                                        {{-- TAMBAH TOKEN --}}
                                        @if ($event->total_tokens > 0)
                                            <a href="{{ route('voter-tokens.add-view', $event->id) }}"
                                                class="btn btn-outline-warning btn-sm" title="Tambah Token">
                                                <i class="bi bi-plus-square"></i>
                                            </a>
                                        @endif

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
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
