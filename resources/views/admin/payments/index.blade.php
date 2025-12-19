@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Riwayat Pembayaran</h6>
                <small class="text-muted">Daftar transaksi pembayaran Anda</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example2" class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Order ID</th>
                                <th>Paket</th>
                                <th>Total</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th width="160">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($payments as $payment)
                                <tr>
                                    <td class="fw-semibold">
                                        {{ $payment->order_id }}
                                    </td>

                                    <td>
                                        {{ $payment->plan->name ?? '-' }}
                                    </td>

                                    <td class="text-end">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </td>

                                    <td class="text-center">
                                        {{ strtoupper($payment->payment_method ?? '-') }}
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="text-center">
                                        @if (in_array($payment->transaction_status, ['settlement', 'capture']))
                                            <span class="badge rounded-pill bg-success">
                                                Lunas
                                            </span>
                                        @elseif ($payment->transaction_status === 'pending')
                                            <span class="badge rounded-pill bg-warning text-dark">
                                                Belum Dibayar
                                            </span>
                                        @elseif ($payment->transaction_status === 'expire')
                                            <span class="badge rounded-pill bg-secondary">
                                                Kadaluarsa
                                            </span>
                                        @else
                                            <span class="badge rounded-pill bg-danger">
                                                Gagal
                                            </span>
                                        @endif
                                    </td>

                                    {{-- TANGGAL --}}
                                    <td class="text-center">
                                        {{ $payment->created_at->format('d M Y') }}
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">

                                            @if ($payment->transaction_status === 'pending')
                                                <a href="{{ route('payment.pay', $payment->order_id) }}"
                                                    class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                                    title="Lanjutkan Pembayaran">
                                                    <i class="bi bi-credit-card"></i>
                                                    Bayar
                                                </a>
                                            @elseif (in_array($payment->transaction_status, ['settlement', 'capture']))
                                                <a href="{{ route('payment.success', ['order_id' => $payment->order_id]) }}"
                                                    class="btn btn-outline-success btn-sm" data-bs-toggle="tooltip"
                                                    title="Detail Pembayaran">
                                                    <i class="bi bi-eye-fill"></i>
                                                    Detail
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        Belum ada riwayat pembayaran
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
