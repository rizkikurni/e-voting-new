<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Berhasil</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #f8f9fa;
            min-height: 100vh;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 20px;
        }

        .success-container {
            max-width: 700px;
            width: 100%;
            animation: fadeInUp 0.5s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-card {
            background: white;
            border-radius: 20px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .success-header {
            background: #10b981;
            color: white;
            padding: 48px 32px;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 24px;
            animation: scaleIn 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes scaleIn {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }

        .success-icon i {
            font-size: 40px;
            color: #10b981;
        }

        .success-title {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .success-subtitle {
            font-size: 15px;
            opacity: 0.95;
        }

        .success-body {
            padding: 32px;
        }

        .status-banner {
            background: #d1fae5;
            border: 1px solid #10b981;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            margin-bottom: 32px;
        }

        .status-banner .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: white;
            color: #059669;
            padding: 10px 20px;
            border-radius: 24px;
            font-weight: 600;
            font-size: 15px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .status-banner .status-badge i {
            font-size: 18px;
        }

        .info-section {
            background: #f8f9fa;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
        }

        .info-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-section h3 i {
            color: #3b82f6;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 16px 0;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-row:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .info-row:first-child {
            padding-top: 0;
        }

        .info-label {
            font-size: 14px;
            color: #64748b;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .info-label i {
            color: #94a3b8;
            width: 20px;
            text-align: center;
        }

        .info-value {
            font-size: 15px;
            color: #1a1a1a;
            font-weight: 600;
            text-align: right;
        }

        .info-value.highlight {
            color: #10b981;
            font-size: 20px;
        }

        .order-id-value {
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }

        .plan-section {
            background: #eff6ff;
            border: 1px solid #3b82f6;
            border-radius: 16px;
            padding: 28px;
            margin-bottom: 24px;
        }

        .plan-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: #1e40af;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .feature-grid {
            display: grid;
            gap: 12px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
            color: #374151;
        }

        .feature-item i {
            color: #10b981;
            font-size: 16px;
        }

        .action-buttons {
            display: grid;
            gap: 12px;
            margin-bottom: 24px;
        }

        .btn-primary {
            background: #3b82f6;
            color: white;
            border: none;
            padding: 16px;
            font-size: 16px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-primary:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
            color: white;
        }

        .btn-secondary {
            background: white;
            color: #3b82f6;
            border: 1px solid #e5e7eb;
            padding: 14px;
            font-size: 15px;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-secondary:hover {
            background: #f8f9fa;
            border-color: #3b82f6;
            color: #2563eb;
        }

        .help-section {
            text-align: center;
            padding-top: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .help-section p {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .help-section a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
        }

        .help-section a:hover {
            color: #2563eb;
            text-decoration: underline;
        }

        .confetti {
            position: fixed;
            width: 8px;
            height: 8px;
            z-index: 9999;
            pointer-events: none;
        }

        @keyframes confettiFall {
            to {
                transform: translateY(100vh) rotate(720deg);
                opacity: 0;
            }
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 15px;
            }

            .success-header {
                padding: 36px 24px;
            }

            .success-title {
                font-size: 24px;
            }

            .success-icon {
                width: 70px;
                height: 70px;
            }

            .success-icon i {
                font-size: 35px;
            }

            .success-body {
                padding: 24px;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .info-value {
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <div class="success-container">
        <div class="success-card">
            <!-- Success Header -->
            <div class="success-header">
                <div class="success-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h1 class="success-title">Pembayaran Berhasil!</h1>
                <p class="success-subtitle">Terima kasih, transaksi Anda telah berhasil diproses</p>
            </div>

            <!-- Success Body -->
            <div class="success-body">
                <!-- Status Banner -->
                <div class="status-banner">
                    <div class="status-badge">
                        <i class="fas fa-check-circle"></i>
                        <span>PAID</span>
                    </div>
                </div>

                <!-- Transaction Info -->
                <div class="info-section">
                    <h3>
                        <i class="fas fa-file-invoice"></i>
                        Informasi Transaksi
                    </h3>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-hashtag"></i>
                            <span>Order ID</span>
                        </div>
                        <div class="info-value order-id-value">{{ $payment->order_id }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-calendar-check"></i>
                            <span>Tanggal Transaksi</span>
                        </div>
                        <div class="info-value">{{ $payment->created_at->format('d F Y, H:i') }} WIB</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-credit-card"></i>
                            <span>Metode Pembayaran</span>
                        </div>
                        <div class="info-value">{{ $payment->payment_method ?? 'Midtrans' }}</div>
                    </div>

                    <div class="info-row">
                        <div class="info-label">
                            <i class="fas fa-money-bill-wave"></i>
                            <span>Total Pembayaran</span>
                        </div>
                        <div class="info-value highlight">Rp {{ number_format($payment->amount, 0, ',', '.') }}</div>
                    </div>
                </div>

                <!-- Plan Details -->
                @if ($payment->plan)
                    <div class="plan-section">
                        <h3>
                            <i class="fas fa-crown"></i>
                            Paket: {{ $payment->plan->name }}
                        </h3>

                        <div class="feature-grid">
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Maksimal {{ $payment->plan->max_event }} Event</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Maksimal {{ $payment->plan->max_candidates }} Kandidat per Event</span>
                            </div>
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Maksimal {{ $payment->plan->max_voters }} Pemilih per Event</span>
                            </div>

                            @if (isset($payment->plan->features['report']) && $payment->plan->features['report'])
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Laporan Analitik</span>
                                </div>
                            @endif

                            @if (isset($payment->plan->features['export']) && $payment->plan->features['export'])
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Export Data</span>
                                </div>
                            @endif

                            @if (isset($payment->plan->features['custom']) && $payment->plan->features['custom'])
                                <div class="feature-item">
                                    <i class="fas fa-check-circle"></i>
                                    <span>Kustomisasi Tampilan</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('dashboard') }}" class="btn-primary">
                        <i class="fas fa-home"></i>
                        <span>Kembali ke Dashboard</span>
                    </a>

                    <a href="#" class="btn-secondary" onclick="window.print(); return false;">
                        <i class="fas fa-download"></i>
                        <span>Unduh Bukti Pembayaran</span>
                    </a>
                </div>

                <!-- Help Section -->
                <div class="help-section">
                    <p><i class="fas fa-envelope"></i> Bukti pembayaran telah dikirim ke email Anda</p>
                    <p>Butuh bantuan? Hubungi <a href="mailto:support@example.com">support@example.com</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Simple confetti animation
        function createConfetti() {
            const colors = ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'];
            const confettiCount = 60;

            for (let i = 0; i < confettiCount; i++) {
                setTimeout(() => {
                    const confetti = document.createElement('div');
                    confetti.className = 'confetti';
                    confetti.style.left = Math.random() * 100 + 'vw';
                    confetti.style.top = '-10px';
                    confetti.style.background = colors[Math.floor(Math.random() * colors.length)];
                    confetti.style.animation = `confettiFall ${2 + Math.random() * 2}s linear`;
                    document.body.appendChild(confetti);

                    setTimeout(() => confetti.remove(), 4000);
                }, i * 20);
            }
        }

        // Trigger confetti
        window.addEventListener('load', () => {
            createConfetti();
            setTimeout(createConfetti, 300);
        });
    </script>

</body>

</html>
