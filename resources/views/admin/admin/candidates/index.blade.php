@extends('admin.layouts.app')


@section('content')
<main class="page-content">
    <div class="container-fluid">

        {{-- PAGE HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Data Kandidat</h4>
        </div>

        {{-- CARD --}}
        <div class="card shadow-sm">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="datatable-candidates" class="table table-bordered table-hover align-middle w-100">
                        <thead class="table-light">
                            <tr>
                                <th width="5%">No</th>
                                <th width="10%">Foto</th>
                                <th>Nama Kandidat</th>
                                <th>Event</th>
                                <th>Pemilik Event</th>
                                <th>Status Event</th>
                                <th>Waktu Event</th>
                                <th class="text-center">Suara</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($candidates as $index => $candidate)
                                <tr>
                                    <td>{{ $index + 1 }}</td>

                                    {{-- FOTO --}}
                                    <td class="text-center">
                                        @if ($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}"
                                                alt="{{ $candidate->name }}"
                                                class="rounded"
                                                width="60">
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    {{-- NAMA --}}
                                    <td>
                                        <strong>{{ $candidate->name }}</strong>
                                    </td>

                                    {{-- EVENT --}}
                                    <td>
                                        {{ $candidate->event->title ?? '-' }}
                                    </td>

                                    {{-- OWNER EVENT --}}
                                    <td>
                                        {{ $candidate->event->owner->name ?? '-' }} <br>
                                        <small class="text-muted">
                                            {{ $candidate->event->owner->email ?? '' }}
                                        </small>
                                    </td>

                                    {{-- STATUS EVENT --}}
                                    <td>
                                        @if ($candidate->event?->is_published)
                                            <span class="badge bg-success">Published</span>
                                        @else
                                            <span class="badge bg-secondary">Draft</span>
                                        @endif
                                    </td>

                                    {{-- WAKTU EVENT --}}
                                    <td>
                                        @if ($candidate->event)
                                            <small>
                                                {{ $candidate->event->start_time?->format('d M Y H:i') }} <br>
                                                s/d <br>
                                                {{ $candidate->event->end_time?->format('d M Y H:i') }}
                                            </small>
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- JUMLAH SUARA --}}
                                    <td class="text-center">
                                        <span class="badge bg-primary">
                                            {{ $candidate->votes_count }} suara
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <a href="{{ route('candidates.admin.show', $candidate->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#datatable-candidates').DataTable({
            responsive: true,
            autoWidth: false,
            pageLength: 10,
            order: [[0, 'asc']],
            columnDefs: [
                { orderable: false, targets: [1, 8] }
            ]
        });
    });
</script>
@endpush
