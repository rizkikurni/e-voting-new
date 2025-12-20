@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1">Detail Kandidat</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('candidates.admin.index') }}">Kandidat</a></li>
                        <li class="breadcrumb-item active">{{ $candidate->name }}</li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex gap-2">
                <a href="{{ route('admin.candidates.export', $candidate->id) }}" class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf"></i> Export PDF
                </a>
                <a href="{{ route('candidates.admin.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- STATUS BADGE --}}
        @if ($isEnded)
            @if ($isWinner && !$isDraw)
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-trophy-fill fs-4 me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Kandidat Pemenang!</h5>
                            <p class="mb-0">
                                Event telah berakhir pada
                                {{ $candidate->event->end_time->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @elseif ($isDraw)
                <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">
                                Kandidat DRAW (Peringkat {{ $rank }})
                            </h5>
                            <p class="mb-0">
                                Memiliki jumlah suara yang sama dengan kandidat lain
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @else
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-x-circle-fill fs-4 me-3"></i>
                        <div>
                            <h5 class="alert-heading mb-1">Kandidat Tidak Menang</h5>
                            <p class="mb-0">
                                Event telah berakhir pada
                                {{ $candidate->event->end_time->format('d M Y H:i') }}
                            </p>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @else
            <div class="alert alert-warning alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-clock-history fs-4 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Event Sedang Berlangsung</h5>
                        <p class="mb-0">
                            Berakhir pada
                            {{ $candidate->event->end_time->format('d M Y H:i') }}
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif


        <div class="row">
            {{-- INFO KANDIDAT --}}
            <div class="col-lg-4 mb-4">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="position-relative d-inline-block mb-3">
                            <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : asset('assets/images/default-avatar.png') }}"
                                class="img-fluid rounded-3 shadow" style="max-height:280px; object-fit: cover;"
                                alt="Foto Kandidat">
                            @if ($isEnded && $isWinner)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success fs-5">
                                    <i class="bi bi-trophy-fill"></i>
                                </span>
                            @endif
                        </div>

                        <h4 class="mb-2">{{ $candidate->name }}</h4>

                        @if ($candidate->description)
                            <p class="text-muted small">
                                {{ $candidate->description }}
                            </p>
                        @endif

                        <hr>

                        <div class="row text-center mt-4">
                            <div class="col-6 border-end">
                                <h3 class="text-primary mb-0">{{ $candidateVotes }}</h3>
                                <small class="text-muted">Total Suara</small>
                            </div>
                            <div class="col-6">
                                <h3 class="text-success mb-0">{{ $percentage }}%</h3>
                                <small class="text-muted">Persentase</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                {{-- VOTING STATISTICS --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-bar-chart-fill text-primary me-2"></i>
                            Statistik Voting
                        </h5>

                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="fw-semibold">{{ $candidate->name }}</span>
                                <span class="badge bg-primary">{{ $percentage }}%</span>
                            </div>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar bg-gradient" role="progressbar"
                                    style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}"
                                    aria-valuemin="0" aria-valuemax="100">
                                    {{ $candidateVotes }} suara
                                </div>
                            </div>
                        </div>

                        <div class="row g-3 mt-3">
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="bi bi-people-fill text-info fs-2"></i>
                                        <h4 class="mt-2 mb-0">{{ $totalVotes }}</h4>
                                        <small class="text-muted">Total Pemilih</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="bi bi-check-circle-fill text-success fs-2"></i>
                                        <h4 class="mt-2 mb-0">{{ $candidateVotes }}</h4>
                                        <small class="text-muted">Suara Diterima</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light border-0">
                                    <div class="card-body text-center">
                                        <i class="bi bi-trophy-fill text-warning fs-2"></i>
                                        <h4 class="mt-2 mb-0">
                                            {{ $rank }}
                                        </h4>

                                        @if ($isDraw)
                                            <small class="text-warning d-block mt-1">
                                                <i class="bi bi-exclamation-triangle-fill"></i>
                                                Draw dengan:
                                                {{ $drawCandidates->pluck('name')->implode(', ') }}
                                            </small>
                                        @endif
                                        <small class="text-muted">Peringkat</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- INFO EVENT --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-calendar-event text-primary me-2"></i>
                            Informasi Event
                        </h5>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Judul Event</label>
                                <p class="fw-semibold mb-0">{{ $candidate->event->title }}</p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Status Event</label>
                                <p class="mb-0">
                                    @if ($isEnded)
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-check-circle me-1"></i>Selesai
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="bi bi-broadcast me-1"></i>Aktif
                                        </span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Waktu Mulai</label>
                                <p class="mb-0">
                                    <i class="bi bi-calendar3 text-success me-1"></i>
                                    {{ $candidate->event->start_time->format('d M Y, H:i') }} WIB
                                </p>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small mb-1">Waktu Selesai</label>
                                <p class="mb-0">
                                    <i class="bi bi-calendar3 text-danger me-1"></i>
                                    {{ $candidate->event->end_time->format('d M Y, H:i') }} WIB
                                </p>
                            </div>
                            <div class="col-md-12">
                                <label class="text-muted small mb-1">Pemilik Event</label>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle bg-primary text-white me-2">
                                        {{ strtoupper(substr($candidate->event->owner->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="mb-0 fw-semibold">{{ $candidate->event->owner->name }}</p>
                                        <small class="text-muted">{{ $candidate->event->owner->email }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CHART SECTION --}}
        <div class="row">
            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-pie-chart-fill text-primary me-2"></i>
                            Distribusi Suara
                        </h5>
                        <div style="height: 300px; position: relative;">
                            <canvas id="voteChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="bi bi-bar-chart-line-fill text-primary me-2"></i>
                            Perbandingan Kandidat
                        </h5>
                        <div style="height: 300px; position: relative;">
                            <canvas id="comparisonChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('styles')
    <style>
        .avatar-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        .progress-bar {
            transition: width 1s ease-in-out;
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Doughnut Chart
        const ctx = document.getElementById('voteChart');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: [
                    '{{ $candidate->name }}',
                    'Kandidat Lain'
                ],
                datasets: [{
                    data: [
                        {{ $candidateVotes }},
                        {{ max($totalVotes - $candidateVotes, 0) }}
                    ],
                    backgroundColor: [
                        '#0d6efd',
                        '#e9ecef'
                    ],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.raw / total) * 100).toFixed(1);
                                return context.label + ': ' + context.raw + ' suara (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // Bar Chart - Comparison
        const compCtx = document.getElementById('comparisonChart');
        new Chart(compCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach ($allCandidates as $cand)
                        '{{ $cand->name }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Jumlah Suara',
                    data: [
                        @foreach ($allCandidates as $cand)
                            {{ $cand->votes_count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        @foreach ($allCandidates as $cand)
                            '{{ $cand->id === $candidate->id ? '#0d6efd' : '#6c757d' }}',
                        @endforeach
                    ],
                    borderRadius: 5,
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return 'Suara: ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
