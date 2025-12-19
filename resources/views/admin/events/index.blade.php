@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Data Events</h6>
                <small class="text-muted">Manajemen event pemilihan</small>
            </div>

            <a href="{{ route('events.create') }}"
                class="btn btn-primary btn-sm px-4 radius-30 d-flex align-items-center gap-2">
                <i class="bi bi-plus-circle"></i>
                Tambah Event
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Judul</th>
                                <th>Pemilik</th>
                                <th>Paket</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th width="150">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($events as $event)
                                <tr>
                                    <td>
                                        <strong>{{ $event->title }}</strong>
                                        @if ($event->is_trial_event)
                                            <span class="badge bg-info ms-1">Trial</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{ $event->owner->name ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        {{ $event->userPlan?->plan?->name ?? '-' }}
                                    </td>

                                    <td class="text-center">
                                        <div>{{ $event->start_time->format('d M Y') }}</div>
                                        <small class="text-muted">
                                            s/d {{ $event->end_time->format('d M Y') }}
                                        </small>
                                    </td>

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
                                        <div class="d-flex justify-content-center gap-2">

                                            {{-- VIEW --}}
                                            <a href="{{ route('events.show', $event->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Detail">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>

                                            {{-- PUBLISH --}}
                                            @if (!$event->is_published)
                                                <form action="{{ route('events.publish', $event->id) }}" method="POST"
                                                    onsubmit="return confirm('Publish event ini? Setelah publish, event tidak bisa diedit.')">
                                                    @csrf
                                                    <button class="btn btn-outline-success btn-sm" title="Publish">
                                                        <i class="bi bi-upload"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- LOCK --}}
                                            @if ($event->is_published && !$event->is_locked)
                                                <form action="{{ route('events.lock', $event->id) }}" method="POST"
                                                    onsubmit="return confirm('Lock event ini? Event akan terkunci permanen.')">
                                                    @csrf
                                                    <button class="btn btn-outline-dark btn-sm" title="Lock">
                                                        <i class="bi bi-lock-fill"></i>
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- EDIT --}}
                                            @if ($event->isEditable())
                                                <a href="{{ route('events.edit', $event->id) }}"
                                                    class="btn btn-outline-warning btn-sm" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                            @endif

                                            {{-- DELETE --}}
                                            @if ($event->isEditable())
                                                <button class="btn btn-outline-danger btn-sm"
                                                    onclick="event.preventDefault();
                if(confirm('Yakin hapus event ini?'))
                document.getElementById('delete-event-{{ $event->id }}').submit();">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>

                                                <form id="delete-event-{{ $event->id }}"
                                                    action="{{ route('events.destroy', $event->id) }}" method="POST"
                                                    hidden>
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            @endif

                                        </div>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
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
