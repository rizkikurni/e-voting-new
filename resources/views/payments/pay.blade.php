@extends('admin.layouts.app')

@section('content')
    <main class="page-content">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h5>Lanjutkan Pembayaran</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Order ID:</strong> {{ $payment->order_id }}
                            </div>
                            <div class="mb-3">
                                <strong>Paket:</strong> {{ $payment->plan->name }}
                            </div>
                            <div class="mb-3">
                                <strong>Total:</strong> Rp {{ number_format($payment->amount, 0, ',', '.') }}
                            </div>
                            <div class="mb-3">
                                <strong>Status:</strong>
                                <span class="badge bg-warning">Menunggu Pembayaran</span>
                            </div>

                            <button id="pay-button" class="btn btn-primary btn-lg w-100">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script>
        document.getElementById('pay-button').onclick = function() {
            snap.pay('{{ $payment->snap_token }}', {
                onSuccess: function(result) {
                    window.location.href =
                        "{{ route('payment.success', ['order_id' => $payment->order_id]) }}";
                },
                onPending: function(result) {
                    window.location.href = "{{ route('payment.pending', $payment->order_id) }}";
                },
                onError: function(result) {
                    alert('Pembayaran gagal!');
                    console.log(result);
                },
                onClose: function() {
                    alert('Anda menutup popup pembayaran');
                }
            });
        };
    </script>
@endsection
