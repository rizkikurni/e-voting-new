<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pembayaran - {{ $plan->name }}</title>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

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
            padding: 40px 20px;
        }

        .checkout-container {
            max-width: 900px;
            margin: 0 auto;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .checkout-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin-bottom: 8px;
        }

        .checkout-header p {
            color: #666;
            font-size: 15px;
        }

        .checkout-grid {
            display: grid;
            grid-template-columns: 1fr 400px;
            gap: 24px;
        }

        .card {
            background: white;
            border-radius: 16px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .card-header {
            padding: 24px;
            border-bottom: 1px solid #e5e7eb;
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a1a;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .card-header h2 i {
            color: #3b82f6;
        }

        .card-body {
            padding: 24px;
        }

        .info-grid {
            display: grid;
            gap: 20px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .info-icon {
            width: 40px;
            height: 40px;
            background: #f1f5f9;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .info-icon i {
            color: #3b82f6;
            font-size: 18px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 15px;
            color: #1a1a1a;
            font-weight: 500;
        }

        .order-id-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 24px;
        }

        .order-id-box strong {
            color: #92400e;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-id-box .order-id {
            font-family: 'Courier New', monospace;
            color: #78350f;
            font-size: 13px;
            margin-top: 4px;
        }

        /* Summary Card */
        .summary-card {
            position: sticky;
            top: 20px;
        }

        .plan-header {
            text-align: center;
            padding: 32px 24px;
            background: #3b82f6;
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .plan-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 6px 16px;
            border-radius: 20px;
            display: inline-block;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .plan-name {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 16px;
        }

        .plan-price {
            font-size: 48px;
            font-weight: 700;
            line-height: 1;
        }

        .plan-price small {
            font-size: 20px;
            font-weight: 500;
            opacity: 0.9;
        }

        .features-list {
            padding: 24px;
        }

        .features-list h3 {
            font-size: 15px;
            font-weight: 600;
            color: #1a1a1a;
            margin-bottom: 16px;
        }

        .feature-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            color: #374151;
            font-size: 14px;
        }

        .feature-item i {
            color: #10b981;
            font-size: 16px;
        }

        .payment-section {
            padding: 24px;
            border-top: 1px solid #e5e7eb;
        }

        .btn-pay {
            width: 100%;
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
        }

        .btn-pay:hover {
            background: #2563eb;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
        }

        .btn-pay:disabled {
            background: #94a3b8;
            cursor: not-allowed;
            transform: none;
        }

        .security-note {
            text-align: center;
            margin-top: 16px;
            padding-top: 16px;
            border-top: 1px solid #e5e7eb;
        }

        .security-note p {
            font-size: 13px;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .security-note i {
            color: #10b981;
        }

        .back-link {
            text-align: center;
            margin-top: 16px;
        }

        .back-link a {
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }

        .back-link a:hover {
            color: #3b82f6;
        }

        @media (max-width: 992px) {
            .checkout-grid {
                grid-template-columns: 1fr;
            }

            .summary-card {
                position: static;
            }

            body {
                padding: 20px 15px;
            }

            .checkout-header h1 {
                font-size: 24px;
            }

            .plan-price {
                font-size: 36px;
            }
        }
    </style>
</head>

<body>

    <div class="checkout-container">
        <!-- Header -->
        <div class="checkout-header">
            <h1>Checkout Pembayaran</h1>
            <p>Lengkapi pembayaran Anda untuk mengaktifkan paket berlangganan</p>
        </div>

        <!-- Main Grid -->
        <div class="checkout-grid">
            <!-- Left Column - Payment Details -->
            <div>
                <div class="card">
                    <div class="card-header">
                        <h2>
                            <i class="fas fa-file-invoice"></i>
                            Detail Pembelian
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="order-id-box">
                            <strong>
                                <i class="fas fa-hashtag"></i>
                                Order ID
                            </strong>
                            <div class="order-id">{{ $payment->order_id }}</div>
                        </div>

                        <div class="info-grid">
                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Nama Pembeli</div>
                                    <div class="info-value">{{ Auth::user()->name }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-envelope"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Email</div>
                                    <div class="info-value">{{ Auth::user()->email }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-box"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Paket Dipilih</div>
                                    <div class="info-value">{{ $plan->name }}</div>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-icon">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                                <div class="info-content">
                                    <div class="info-label">Tanggal Pembelian</div>
                                    <div class="info-value">{{ now()->format('d F Y, H:i') }} WIB</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column - Summary -->
            <div>
                <div class="card summary-card">
                    <div class="plan-header">
                        <div class="plan-badge">
                            <i class="fas fa-crown"></i> Premium Plan
                        </div>
                        <div class="plan-name">{{ $plan->name }}</div>
                        <div class="plan-price">
                            <small>Rp</small>{{ number_format($plan->price, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="features-list">
                        <h3>Yang Anda Dapatkan:</h3>

                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>Maksimal {{ $plan->max_event }} Event</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $plan->max_candidates }} Kandidat per Event</span>
                        </div>
                        <div class="feature-item">
                            <i class="fas fa-check-circle"></i>
                            <span>{{ $plan->max_voters }} Pemilih per Event</span>
                        </div>

                        @if (isset($plan->features['report']) && $plan->features['report'])
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Laporan Analitik</span>
                            </div>
                        @endif

                        @if (isset($plan->features['export']) && $plan->features['export'])
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Export Data</span>
                            </div>
                        @endif

                        @if (isset($plan->features['custom']) && $plan->features['custom'])
                            <div class="feature-item">
                                <i class="fas fa-check-circle"></i>
                                <span>Kustomisasi Tampilan</span>
                            </div>
                        @endif
                    </div>

                    <div class="payment-section">
                        <button id="pay-button" class="btn-pay">
                            <i class="fas fa-credit-card"></i>
                            <span>Bayar Sekarang</span>
                        </button>

                        <div class="security-note">
                            <p>
                                <i class="fas fa-shield-alt"></i>
                                <span>Pembayaran aman melalui Midtrans</span>
                            </p>
                        </div>

                        <div class="back-link">
                            <a href="{{ route('dashboard') }}">
                                <i class="fas fa-arrow-left"></i>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('pay-button').addEventListener('click', function() {
            const button = this;
            button.disabled = true;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>Memproses...</span>';

            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    console.log('Payment success:', result);
                    window.location.href =
                        "{{ route('payment.success') }}?order_id={{ $payment->order_id }}";
                },
                onPending: function(result) {
                    console.log('Payment pending:', result);
                    window.location.href =
                        "{{ route('payment.success') }}?order_id={{ $payment->order_id }}";
                },
                onError: function(result) {
                    console.error('Payment error:', result);
                    alert('Pembayaran gagal! Silakan coba lagi.');
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-credit-card"></i><span>Bayar Sekarang</span>';
                },
                onClose: function() {
                    console.log('Payment popup closed');
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-credit-card"></i><span>Bayar Sekarang</span>';
                }
            });
        });
    </script>

</body>

</html>
