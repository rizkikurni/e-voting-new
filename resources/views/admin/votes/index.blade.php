@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="mb-3">
        <h6 class="mb-0 text-uppercase fw-bold">Rekap Hasil Voting</h6>
        <small class="text-muted">Ringkasan hasil voting seluruh event</small>
    </div>
            <x-alert/>

    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle" id="example2">
                        <thead class="table-primary">
                        <tr>
                            <th>Event</th>
                            <th>Pemenang</th>
                            <th>Perolehan Kandidat</th>
                            <th>Token</th>
                            <th width="120">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($events as $item)
                            @php
                                $event = $item['event'];
                            @endphp
                            <tr>
                                {{-- EVENT --}}
                                <td>
                                    <strong>{{ $event->title }}</strong><br>
                                    <small class="text-muted">
                                        {{ $event->start_time->format('d M Y') }}
                                    </small>
                                </td>

                                {{-- PEMENANG --}}
                                <td class="text-center">
                                    @if ($item['winner'])
                                        <span class="badge bg-success">
                                            {{ $item['winner']->name }}
                                        </span><br>
                                        <small>{{ $item['winner']->votes_count }} suara</small>
                                    @else
                                        <span class="badge bg-secondary">Belum ada</span>
                                    @endif
                                </td>

                                {{-- PEROLEHAN --}}
<td>
    @foreach ($item['candidates']->take(3) as $candidate)
        <div class="d-flex justify-content-between">
            <span>{{ $candidate->name }}</span>
            <strong>{{ $candidate->votes_count }}</strong>
        </div>
    @endforeach

    @if ($item['candidates']->count() > 3)
        <div class="text-muted small fst-italic">
            +{{ $item['candidates']->count() - 3 }} kandidat lainnya…
        </div>
    @endif
</td>


                                {{-- TOKEN --}}
                                <td class="text-center">
                                    <span class="badge bg-primary">
                                        Total: {{ $item['total_tokens'] }}
                                    </span><br>
                                    <span class="badge bg-success">
                                        Digunakan: {{ $item['used_tokens'] }}
                                    </span><br>
                                    <span class="badge bg-warning text-dark">
                                        Sisa: {{ $item['remaining'] }}
                                    </span>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <a href="{{ route('votes.show', $event->id) }}"
                                       class="btn btn-outline-primary btn-sm"
                                       title="Detail Voting">
                                        <i class="bi bi-bar-chart-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">
                                    Belum ada data voting
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
