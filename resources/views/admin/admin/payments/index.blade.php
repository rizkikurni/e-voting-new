@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Riwayat Pembayaran</h6>
                <small class="text-muted">Daftar seluruh transaksi pembayaran user</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example2" class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>User</th>
                                <th>Plan</th>
                                <th>Metode</th>
                                <th>Bank</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Waktu Bayar</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($payments as $payment)
                                <tr>
                                    {{-- ORDER ID --}}
                                    <td class="fw-semibold">
                                        {{ $payment['order_id'] }}
                                    </td>

                                    {{-- USER --}}
                                    <td>
                                        {{ $payment['user_name'] ?? '-' }} <br>
                                        <small class="text-muted">
                                            {{ $payment['user_email'] ?? '-' }}
                                        </small>
                                    </td>

                                    {{-- PLAN --}}
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            {{ $payment['plan_name'] ?? '-' }}
                                        </span>
                                    </td>

                                    {{-- METODE --}}
                                    <td class="text-center">
                                        <span class="badge bg-secondary text-uppercase">
                                            {{ $payment['payment_method'] }}
                                        </span>
                                    </td>

                                    {{-- BANK --}}
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">
                                            {{ $payment['bank'] }}
                                        </span>
                                    </td>

                                    {{-- JUMLAH --}}
                                    <td class="text-end fw-semibold">
                                        Rp {{ number_format($payment['amount'], 0, ',', '.') }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="text-center">
                                        @php
                                            $status = $payment['transaction_status'];
                                        @endphp

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

                                    {{-- WAKTU --}}
                                    <td class="text-center">
                                        {{ $payment['paid_at'] ? \Carbon\Carbon::parse($payment['paid_at'])->format('d M Y') : '-' }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $payment['paid_at'] ? \Carbon\Carbon::parse($payment['paid_at'])->format('H:i') : '' }}
                                        </small>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <a href="{{ route('payments.admin.show', $payment['id']) }}"
                                            class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                            title="Detail Pembayaran">
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
