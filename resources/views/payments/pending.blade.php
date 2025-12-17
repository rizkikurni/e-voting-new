<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Menunggu Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 520px;
            margin: 80px auto;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .08);
            padding: 32px;
            text-align: center;
        }

        .icon {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            background: #fef3c7;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .icon i {
            font-size: 42px;
            color: #f59e0b;
        }

        h1 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #111827;
        }

        p {
            color: #6b7280;
            font-size: 15px;
        }

        .order-box {
            background: #f9fafb;
            border-radius: 10px;
            padding: 16px;
            margin: 24px 0;
            text-align: left;
        }

        .order-box div {
            display: flex;
            justify-content: space-between;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .order-box div:last-child {
            margin-bottom: 0;
        }

        .badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            padding: 6px 14px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 600;
        }

        .spinner {
            margin: 24px auto;
            width: 48px;
            height: 48px;
            border: 5px solid #e5e7eb;
            border-top-color: #f59e0b;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .actions {
            margin-top: 24px;
        }

        .actions a {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .btn-primary {
            background: #2563eb;
            color: white;
        }

        .btn-secondary {
            background: #e5e7eb;
            color: #111827;
            margin-left: 8px;
        }

        .hint {
            font-size: 13px;
            color: #9ca3af;
            margin-top: 18px;
        }
    </style>
</head>

<body>

    <div class="container">
        <div class="icon">
            <i class="fas fa-qrcode"></i>
        </div>

        <h1>Menunggu Pembayaran</h1>
        <p>Silakan selesaikan pembayaran Anda.
            Sistem akan otomatis memperbarui status.</p>

        <span class="badge">STATUS: {{ strtoupper($payment->transaction_status) }}</span>

        <div class="spinner"></div>

        <div class="order-box">
            <div>
                <span>Order ID</span>
                <strong>{{ $payment->order_id }}</strong>
            </div>
            <div>
                <span>Total Bayar</span>
                <strong>Rp {{ number_format($payment->amount, 0, ',', '.') }}</strong>
            </div>
            <div>
                <span>Metode</span>
                <strong>{{ $payment->payment_method ?? 'Menunggu' }}</strong>
            </div>
        </div>
        @if (isset($status->actions))
            @foreach ($status->actions as $action)
                @if ($action->name === 'generate-qr-code')
                    <img src="{{ $action->url }}" alt="QRIS" width="220">
                @endif
            @endforeach
        @endif
        @if (isset($status->va_numbers))
            <div class="order-box">
                <div>
                    <span>Bank</span>
                    <strong>{{ strtoupper($status->va_numbers[0]->bank) }}</strong>
                </div>
                <div>
                    <span>Nomor VA</span>
                    <strong>{{ $status->va_numbers[0]->va_number }}</strong>
                </div>
            </div>
        @endif
        @if (isset($status->permata_va_number))
            <div class="order-box">
                <div>
                    <span>Bank</span>
                    <strong>PERMATA</strong>
                </div>
                <div>
                    <span>Nomor VA</span>
                    <strong>{{ $status->permata_va_number }}</strong>
                </div>
            </div>
        @endif



        <div class="actions">
            <a href="{{ route('dashboard') }}" class="btn-secondary">
                <i class="fas fa-arrow-left"></i> Dashboard
            </a>
        </div>

        <div class="hint">
            Jangan menutup halaman ini sebelum pembayaran selesai.
        </div>
    </div>

    <script>
        // Auto cek status setiap 7 detik
        setInterval(() => {
            fetch("{{ route('payment.check', $payment->order_id) }}")
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'paid') {
                        window.location.href =
                            "{{ route('payment.success') }}?order_id={{ $payment->order_id }}";
                    }
                });
        }, 7000);
    </script>

</body>

</html>
