@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <main class="page-content">

        {{-- ================= FILTER RANGE ================= --}}
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label">Start Date</label>
                        <input type="date" name="start_date" class="form-control"
                            value="{{ request('start_date', $startDate->toDateString()) }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">End Date</label>
                        <input type="date" name="end_date" class="form-control"
                            value="{{ request('end_date', $endDate->toDateString()) }}">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-filter"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ================= STAT CARDS ================= --}}
        <div class="row g-3 mb-4">

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Total Customer</h6>
                        <h3>{{ $totalCustomers }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Total Event</h6>
                        <h3>{{ $totalEvents }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Event Aktif</h6>
                        <h3>{{ $activeEvents }}</h3>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h6>Total Pendapatan</h6>
                        <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= CHART SECTION ================= --}}
        <div class="row mb-4">

            {{-- Line Chart Revenue --}}
            <div class="col-md-8">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <strong>Pendapatan per Tanggal</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="120"></canvas>
                    </div>
                </div>
            </div>

            {{-- Donut Chart Plan --}}
            <div class="col-md-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header">
                        <strong>Distribusi Subscription Plan</strong>
                    </div>
                    <div class="card-body">
                        <canvas id="planChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        {{-- ================= TABLE SECTION ================= --}}
        <div class="row">

            {{-- Latest Payments --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <strong>Pembayaran Terakhir</strong>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Plan</th>
                                    <th>Status</th>
                                    <th>Amount</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestPayments as $payment)
                                    <tr>
                                        <td>{{ $payment->user->name }}</td>
                                        <td>{{ $payment->plan->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $payment->isPaid() ? 'success' : 'warning' }}">
                                                {{ $payment->transaction_status }}
                                            </span>
                                        </td>
                                        <td>Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Latest Events --}}
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <strong>Event Terbaru</strong>
                    </div>
                    <div class="card-body table-responsive">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Owner</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestEvents as $event)
                                    <tr>
                                        <td>{{ $event->title }}</td>
                                        <td>{{ $event->owner->name }}</td>
                                        <td>
                                            <span class="badge bg-{{ $event->is_published ? 'success' : 'secondary' }}">
                                                {{ $event->is_published ? 'Published' : 'Draft' }}
                                            </span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">Tidak ada data</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </main>
@endsection

{{-- ================= SCRIPT ================= --}}
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // ================= LINE CHART =================
        const revenueCtx = document.getElementById('revenueChart');

        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($revenueChart->pluck('date')) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode($revenueChart->pluck('total')) !!},
                    fill: false,
                    tension: 0.3
                }]
            }
        });

        // ================= DONUT CHART =================
        const planCtx = document.getElementById('planChart');

        new Chart(planCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($planDistribution->pluck('plan')) !!},
                datasets: [{
                    data: {!! json_encode($planDistribution->pluck('total')) !!}
                }]
            }
        });
    </script>
@endsection
