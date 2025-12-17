<!DOCTYPE html>
<html>

<head>
    <title>Checkout</title>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
</head>

<body>

    <h2>Checkout Paket {{ $plan->name }}</h2>
    <p>Harga: Rp {{ number_format($plan->price, 0, ',', '.') }}</p>

    <button id="pay-button">Bayar Sekarang</button>

    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    alert('Pembayaran berhasil');
                    console.log(result);
                },
                onPending: function(result) {
                    alert('Menunggu pembayaran');
                    console.log(result);
                },
                onError: function(result) {
                    alert('Pembayaran gagal');
                    console.log(result);
                }
            });
        });
    </script>

</body>

</html>
