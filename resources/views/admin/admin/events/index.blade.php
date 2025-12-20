@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Semua Event</h6>
                <small class="text-muted">Daftar seluruh event yang dibuat user</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example2" class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Judul Event</th>
                                <th>Owner</th>
                                <th>Plan</th>
                                <th>Status</th>
                                <th>Waktu</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($events as $event)
                                <tr>
                                    <td>{{ $event->title }}</td>

                                    <td>
                                        {{ $event->owner->name }} <br>
                                        <small class="text-muted">{{ $event->owner->email }}</small>
                                    </td>

                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            {{ $event->plan?->name ?? '-' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if ($event->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif

                                        @if ($event->is_locked)
                                            <span class="badge bg-danger">Locked</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{ $event->start_time?->format('d M Y') }} <br>
                                        <small class="text-muted">
                                            s/d {{ $event->end_time?->format('d M Y') }}
                                        </small>
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('admin.events.show', $event->id) }}"
                                            class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip" title="Detail">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </main>
@endsection
