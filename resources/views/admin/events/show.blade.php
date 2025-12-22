@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="mb-1 fw-bold">Detail Rekap Event</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                        <li class="breadcrumb-item active">{{ $event->title }}</li>
                    </ol>
                </nav>
            </div>

            <div class="d-flex gap-2">
                <button class="btn btn-danger"
                    onclick="window.location.href='{{ route('events.export-pdf', $event->id) }}'">
                    <i class="bi bi-file-earmark-pdf-fill"></i> Export PDF
                </button>
                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </div>
        </div>

        {{-- STATUS EVENT ALERT --}}
        @if ($isEnded)
            <div class="alert alert-info alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Event Telah Selesai</h5>
                        <p class="mb-0">
                            Berakhir pada <strong>{{ $event->end_time->format('d M Y, H:i') }} WIB</strong>
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @else
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <div class="d-flex align-items-center">
                    <i class="bi bi-broadcast fs-4 me-3"></i>
                    <div>
                        <h5 class="alert-heading mb-1">Event Sedang Berlangsung</h5>
                        <p class="mb-0">
                            Berakhir pada <strong>{{ $event->end_time->format('d M Y, H:i') }} WIB</strong>
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- INFORMASI EVENT --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-calendar-event-fill text-primary me-2"></i>
                    Informasi Event
                </h5>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small fw-semibold mb-2 d-block">
                                <i class="bi bi-megaphone me-1"></i> Judul Event
                            </label>
                            <h6 class="mb-0">{{ $event->title }}</h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small fw-semibold mb-2 d-block">
                                <i class="bi bi-person-circle me-1"></i> Penyelenggara
                            </label>
                            <div class="d-flex align-items-center">
                                <div class="avatar-circle bg-primary text-white me-2">
                                    {{ strtoupper(substr($event->owner->name, 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $event->owner->name }}</h6>
                                    <small class="text-muted">{{ $event->owner->email }}</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small fw-semibold mb-2 d-block">
                                <i class="bi bi-calendar-check me-1"></i> Waktu Mulai
                            </label>
                            <h6 class="mb-0 text-success">
                                {{ $event->start_time->format('d M Y, H:i') }} WIB
                            </h6>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="info-box">
                            <label class="text-muted small fw-semibold mb-2 d-block">
                                <i class="bi bi-calendar-x me-1"></i> Waktu Selesai
                            </label>
                            <h6 class="mb-0 text-danger">
                                {{ $event->end_time->format('d M Y, H:i') }} WIB
                            </h6>
                        </div>
                    </div>

                    @if ($event->description)
                        <div class="col-12">
                            <div class="info-box">
                                <label class="text-muted small fw-semibold mb-2 d-block">
                                    <i class="bi bi-file-text me-1"></i> Deskripsi Event
                                </label>
                                <p class="mb-0 text-secondary">{{ $event->description }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- STATISTIK RINGKASAN --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="stat-card bg-gradient-primary">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $totalVotes }}</h3>
                        <p class="stat-label">Total Suara Masuk</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-gradient-success">
                    <div class="stat-icon">
                        <i class="bi bi-person-badge-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $candidates->count() }}</h3>
                        <p class="stat-label">Jumlah Kandidat</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-gradient-warning">
                    <div class="stat-icon">
                        <i class="bi bi-trophy-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">{{ $winner?->votes_count ?? 0 }}</h3>
                        <p class="stat-label">Suara Tertinggi</p>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="stat-card bg-gradient-info">
                    <div class="stat-icon">
                        <i class="bi bi-graph-up-arrow"></i>
                    </div>
                    <div class="stat-content">
                        <h3 class="stat-number">
                            {{ $totalVotes > 0 ? number_format((($winner?->votes_count ?? 0) / $totalVotes) * 100, 1) : 0 }}%
                        </h3>
                        <p class="stat-label">Persentase Pemenang</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- DAFTAR KANDIDAT --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-person-lines-fill text-primary me-2"></i>
                    Daftar Kandidat & Perolehan Suara
                </h5>

                <div class="row g-4">
                    @foreach ($candidates as $index => $candidate)
                        @php
                            $percentage = $totalVotes > 0 ? round(($candidate->votes_count / $totalVotes) * 100, 2) : 0;
                            $isWinner = $winner && $winner->id === $candidate->id;
                            $rank = $index + 1;
                        @endphp

                        <div class="col-lg-4 col-md-6">
                            <div class="candidate-card {{ $isWinner ? 'winner-card' : '' }}">
                                @if ($isWinner)
                                    <div class="winner-badge">
                                        <i class="bi bi-trophy-fill"></i>
                                    </div>
                                @endif

                                <div class="candidate-photo-wrapper">
                                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : asset('assets/images/default-avatar.png') }}"
                                        class="candidate-photo" alt="{{ $candidate->name }}">
                                    <div class="rank-badge">
                                        <span>#{{ $rank }}</span>
                                    </div>
                                </div>

                                <div class="candidate-info">
                                    <h5 class="candidate-name">{{ $candidate->name }}</h5>

                                    @if ($candidate->description)
                                        <p class="candidate-desc">{{ Str::limit($candidate->description, 60) }}</p>
                                    @endif

                                    <div class="vote-stats">
                                        <div class="stat-item">
                                            <div class="stat-value text-primary">{{ $candidate->votes_count }}</div>
                                            <div class="stat-desc">Suara</div>
                                        </div>
                                        <div class="stat-divider"></div>
                                        <div class="stat-item">
                                            <div class="stat-value text-success">{{ $percentage }}%</div>
                                            <div class="stat-desc">Persentase</div>
                                        </div>
                                    </div>

                                    <div class="progress-wrapper">
                                        <div class="progress">
                                            <div class="progress-bar {{ $isWinner ? 'bg-warning' : 'bg-primary' }}"
                                                role="progressbar" style="width: {{ $percentage }}%"
                                                aria-valuenow="{{ $percentage }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="progress-label">{{ $percentage }}% dari total suara</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- CHARTS SECTION --}}
        <div class="row g-4 mb-4">
            {{-- PIE CHART --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="bi bi-pie-chart-fill text-primary me-2"></i>
                            Distribusi Suara
                        </h5>
                        <div class="chart-container">
                            <canvas id="pieChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- BAR CHART --}}
            <div class="col-lg-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-4">
                            <i class="bi bi-bar-chart-fill text-primary me-2"></i>
                            Perbandingan Kandidat
                        </h5>
                        <div class="chart-container">
                            <canvas id="barChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- TIMELINE CHART --}}
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <h5 class="card-title mb-4">
                    <i class="bi bi-graph-up-arrow text-primary me-2"></i>
                    Timeline Perolehan Suara
                </h5>
                <div class="chart-container" style="height: 400px;">
                    <canvas id="timelineChart"></canvas>
                </div>
            </div>
        </div>

    </main>
@endsection

@push('styles')
    <style>
        /* Avatar */
        .avatar-circle {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 18px;
        }

        /* Info Box */
        .info-box {
            padding: 15px;
            background: #f8f9fa;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .info-box:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        /* Stat Cards */
        .stat-card {
            padding: 25px;
            border-radius: 12px;
            color: white;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            min-height: 120px;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .bg-gradient-warning {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }

        .stat-icon {
            font-size: 3rem;
            opacity: 0.9;
        }

        .stat-content {
            flex: 1;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 5px;
            line-height: 1;
        }

        .stat-label {
            margin: 0;
            font-size: 0.95rem;
            opacity: 0.95;
            font-weight: 500;
        }

        /* Candidate Card */
        .candidate-card {
            background: white;
            border-radius: 16px;
            padding: 25px;
            transition: all 0.3s ease;
            border: 2px solid #e9ecef;
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .candidate-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.12);
            border-color: #0d6efd;
        }

        .candidate-card.winner-card {
            border: 3px solid #ffc107;
            background: linear-gradient(135deg, #fff9e6 0%, #ffffff 100%);
        }

        .winner-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.1);
            }
        }

        .candidate-photo-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .candidate-photo {
            width: 100%;
            height: 280px;
            object-fit: cover;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .rank-badge {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.75);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 700;
            font-size: 1.1rem;
            backdrop-filter: blur(10px);
        }

        .candidate-info {
            text-align: center;
        }

        .candidate-name {
            font-size: 1.3rem;
            font-weight: 700;
            margin-bottom: 8px;
            color: #212529;
        }

        .candidate-desc {
            font-size: 0.9rem;
            color: #6c757d;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .vote-stats {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-value {
            font-size: 1.8rem;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 5px;
        }

        .stat-desc {
            font-size: 0.85rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-divider {
            width: 2px;
            height: 40px;
            background: #dee2e6;
        }

        .progress-wrapper {
            margin-top: 15px;
        }

        .progress {
            height: 12px;
            border-radius: 10px;
            background: #e9ecef;
            overflow: hidden;
        }

        .progress-bar {
            transition: width 1.5s ease;
        }

        .progress-label {
            display: block;
            text-align: center;
            margin-top: 8px;
            color: #6c757d;
            font-weight: 600;
        }

        /* Chart Container */
        .chart-container {
            position: relative;
            height: 350px;
            padding: 10px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .stat-card {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .stat-icon {
                font-size: 2.5rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .candidate-photo {
                height: 220px;
            }

            .chart-container {
                height: 300px;
            }
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        const candidateLabels = [
            @foreach ($candidates as $c)
                "{{ $c->name }}",
            @endforeach
        ];

        const candidateVotes = [
            @foreach ($candidates as $c)
                {{ $c->votes_count }},
            @endforeach
        ];

        const chartColors = [
            '#667eea', '#764ba2', '#11998e', '#38ef7d',
            '#f093fb', '#f5576c', '#4facfe', '#00f2fe',
            '#fa709a', '#fee140', '#30cfd0', '#330867'
        ];

        // PIE CHART
        new Chart(document.getElementById('pieChart'), {
            type: 'doughnut',
            data: {
                labels: candidateLabels,
                datasets: [{
                    data: candidateVotes,
                    backgroundColor: chartColors,
                    borderWidth: 3,
                    borderColor: '#fff',
                    hoverOffset: 15
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
                                size: 12,
                                weight: '600'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
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

        // BAR CHART
        new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: candidateLabels,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: candidateVotes,
                    backgroundColor: chartColors,
                    borderRadius: 8,
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
                            precision: 0,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                return 'Suara: ' + context.raw;
                            }
                        }
                    }
                }
            }
        });
        // TIMELINE CHART dengan data REAL dari backend
        const timelineData = {
            labels: @json($timelineData['labels']),
            datasets: [
                @foreach ($timelineData['datasets'] as $index => $dataset)
                    {
                        label: "{{ $dataset['name'] }}",
                        data: @json($dataset['data']),
                        borderColor: chartColors[{{ $index }}],
                        backgroundColor: chartColors[{{ $index }}] + '20',
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                        fill: true
                    },
                @endforeach
            ]
        };

        new Chart(document.getElementById('timelineChart'), {
            type: 'line',
            data: timelineData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0,
                            font: {
                                size: 12,
                                weight: '600'
                            }
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 11,
                                weight: '600'
                            },
                            maxRotation: 45,
                            minRotation: 45
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            padding: 15,
                            font: {
                                size: 12,
                                weight: '600'
                            },
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0,0,0,0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14,
                            weight: 'bold'
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            title: function(context) {
                                return 'Waktu: ' + context[0].label;
                            },
                            label: function(context) {
                                return context.dataset.label + ': ' + context.raw + ' suara';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endpush
