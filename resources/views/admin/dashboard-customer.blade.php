@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- SUMMARY CARDS --}}
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">


            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-pink">
                                <p>Total Event</p>
                                <h4 class="text-pink">{{ $totalEvents }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-purple">
                                <p>Event Dipublish</p>
                                <h4 class="text-purple">{{ $publishedEvents }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-success">
                                <p>Total Kandidat</p>
                                <h4 class="text-success">{{ $totalCandidates }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-orange">
                                <p>Total Vote Masuk</p>
                                <h4 class="text-orange">{{ $totalVotes }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        {{-- TOKEN STAT --}}
        <div class="row mt-3">

            <div class="col-lg-6">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-pink">
                                <p>Total Token</p>
                                <h4 class="text-pink">{{ $totalTokens }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">
                            <div class="w-100 p-3 bg-light-purple">
                                <p>Token Terpakai</p>
                                <h4 class="text-purple">{{ $usedTokens }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- EVENT TERAKHIR --}}
        <div class="row mt-4">
            <div class="col-12">
                <div class="card radius-10">
                    <div class="card-header">
                        <h6>Event Terakhir</h6>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Judul Event</th>
                                        <th>Status</th>
                                        <th>Pemenang Sementara</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($latestEvents as $event)
                                        @php
                                            $winner = $event->candidates->sortByDesc('votes_count')->first();
                                        @endphp
                                        <tr>
                                            <td>{{ $event->title }}</td>
                                            <td>
                                                @if ($event->is_published)
                                                    <span class="badge bg-success">Published</span>
                                                @else
                                                    <span class="badge bg-secondary">Draft</span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $winner?->name ?? '-' }}
                                            </td>
                                            <td>
                                                <a href="{{ route('events.show', $event->id) }}"
                                                    class="btn btn-sm btn-outline-primary">
                                                    Detail
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted">
                                                Belum ada event
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </main>
@endsection
