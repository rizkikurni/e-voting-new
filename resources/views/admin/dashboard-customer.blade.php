@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- SUMMARY CARDS --}}
        <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-4">

            {{-- TOTAL EVENT --}}
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">

                            <div class="w-50 p-3 bg-light-pink">
                                <p class="mb-1">Total Event</p>
                                <h4 class="text-pink mb-0">{{ $totalEvents }}</h4>
                            </div>

                            <div class="w-50 bg-pink p-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-calendar-event-fill text-white fs-1"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- EVENT DIPUBLISH --}}
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">

                            <div class="w-50 p-3 bg-light-purple">
                                <p class="mb-1">Event Dipublish</p>
                                <h4 class="text-purple mb-0">{{ $publishedEvents }}</h4>
                            </div>

                            <div class="w-50 bg-purple p-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-upload text-white fs-1"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL KANDIDAT --}}
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">

                            <div class="w-50 p-3 bg-light-success">
                                <p class="mb-1">Total Kandidat</p>
                                <h4 class="text-success mb-0">{{ $totalCandidates }}</h4>
                            </div>

                            <div class="w-50 bg-success p-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-people-fill text-white fs-1"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- TOTAL VOTE --}}
            <div class="col">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">

                            <div class="w-50 p-3 bg-light-orange">
                                <p class="mb-1">Total Vote Masuk</p>
                                <h4 class="text-orange mb-0">{{ $totalVotes }}</h4>
                            </div>

                            <div class="w-50 bg-orange p-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-check2-square text-white fs-1"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>


        {{-- TOKEN STAT --}}
        <div class="row mt-3">

            {{-- TOTAL TOKEN --}}
            <div class="col-lg-6">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">

                            <div class="w-50 p-3 bg-light-pink">
                                <p class="mb-1">Total Token</p>
                                <h4 class="text-pink mb-0">{{ $totalTokens }}</h4>
                            </div>

                            <div class="w-50 bg-pink p-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-key-fill text-white fs-1"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            {{-- TOKEN TERPAKAI --}}
            <div class="col-lg-6">
                <div class="card overflow-hidden radius-10">
                    <div class="card-body p-2">
                        <div class="d-flex align-items-stretch justify-content-between radius-10 overflow-hidden">

                            <div class="w-50 p-3 bg-light-purple">
                                <p class="mb-1">Token Terpakai</p>
                                <h4 class="text-purple mb-0">{{ $usedTokens }}</h4>
                            </div>

                            <div class="w-50 bg-purple p-3 d-flex align-items-center justify-content-center">
                                <i class="bi bi-check-circle-fill text-white fs-1"></i>
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
