@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Detail Pembayaran</h6>
                <small class="text-muted">Informasi lengkap transaksi pembayaran</small>
            </div>

            <a href="{{ route('payments.admin.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row">

            {{-- LEFT : INFO TRANSAKSI --}}
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">

                        <h6 class="fw-bold mb-3">Informasi Transaksi</h6>

                        <table class="table table-bordered align-middle mb-0">
                            <tr>
                                <th width="30%">Order ID</th>
                                <td class="fw-semibold">{{ $payment->order_id }}</td>
                            </tr>

                            <tr>
                                <th>Metode Pembayaran</th>
                                <td>
                                    <span class="badge bg-secondary text-uppercase">
                                        {{ $payment->payment_method }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Bank / Channel</th>
                                <td>
                                    <span class="badge bg-light text-dark">
                                        {{ $bank }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Jumlah</th>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td>
                                    @php $status = $payment->transaction_status; @endphp

                                    @if ($status === 'settlement' || $status === 'capture')
                                        <span class="badge bg-success">Success</span>
                                    @elseif ($status === 'pending')
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @elseif ($status === 'expire')
                                        <span class="badge bg-secondary">Expired</span>
                                    @elseif ($status === 'cancel' || $status === 'deny')
                                        <span class="badge bg-danger">Failed</span>
                                    @else
                                        <span class="badge bg-dark">{{ $status }}</span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <th>Waktu Transaksi</th>
                                <td>
                                    {{ $payment->transaction_time ? \Carbon\Carbon::parse($payment->transaction_time)->format('d M Y H:i') : '-' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Waktu Pembayaran</th>
                                <td>
                                    {{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('d M Y H:i') : '-' }}
                                </td>
                            </tr>
                        </table>

                    </div>
                </div>

                {{-- PAYLOAD MIDTRANS --}}
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Payload Midtrans</h6>

                        <pre class="bg-light p-3 rounded small mb-0" style="max-height: 350px; overflow:auto;">
{{ json_encode($payment->payload_response, JSON_PRETTY_PRINT) }}
                    </pre>
                    </div>
                </div>
            </div>

            {{-- RIGHT : USER & PLAN --}}
            <div class="col-lg-4">

                {{-- USER --}}
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Data User</h6>

                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="35%">Nama</th>
                                <td>{{ $payment->user?->name ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $payment->user?->email ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- PLAN --}}
                <div class="card">
                    <div class="card-body">
                        <h6 class="fw-bold mb-3">Subscription Plan</h6>

                        <table class="table table-borderless mb-0">
                            <tr>
                                <th width="35%">Nama</th>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $payment->plan?->name ?? '-' }}
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <th>Harga</th>
                                <td>
                                    Rp {{ number_format($payment->plan?->price ?? 0, 0, ',', '.') }}
                                </td>
                            </tr>

                            @if (!empty($payment->plan?->features))
                                <tr>
                                    <th>Fitur</th>
                                    <td>
                                        <ul class="list-unstyled mb-0">
                                            @foreach ($payment->plan->features as $key => $enabled)
                                                <li class="mb-1">
                                                    @if ($enabled)
                                                        <i class="bi bi-check-circle-fill text-success"></i>
                                                    @else
                                                        <i class="bi bi-x-circle-fill text-danger"></i>
                                                    @endif

                                                    <span class="ms-1">
                                                        @switch($key)
                                                            @case('report')
                                                                Laporan Voting
                                                            @break

                                                            @case('export')
                                                                Export Data
                                                            @break

                                                            @case('custom')
                                                                Kustomisasi Event
                                                            @break

                                                            @default
                                                                {{ ucfirst($key) }}
                                                        @endswitch
                                                    </span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endif

                        </table>
                    </div>
                </div>

            </div>

        </div>

    </main>
@endsection
