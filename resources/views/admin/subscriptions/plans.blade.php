@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        <div class="mb-3">
            <h6 class="mb-0 text-uppercase fw-bold">Paket Berlangganan</h6>
            <small class="text-muted">
                Paket dapat dibeli lebih dari satu kali (stack kuota)
            </small>
        </div>

        <div class="row g-3">

            @foreach ($plans as $plan)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100 border-0">

                        <div class="card-body">

                            {{-- HEADER --}}
                            <h6 class="fw-bold mb-1">
                                {{ strtoupper($plan['name']) }}
                            </h6>

                            <h4 class="fw-bold mb-3">
                                Rp {{ number_format($plan['price'], 0, ',', '.') }}
                            </h4>

                            {{-- FEATURE --}}
                            <ul class="list-unstyled mb-3">
                                <li>✔ {{ $plan['max_event'] }} Event / Paket</li>
                                <li>✔ {{ $plan['max_candidates'] }} Kandidat</li>
                                <li>✔ {{ $plan['max_voters'] }} Pemilih</li>
                            </ul>

                            {{-- STACK INFO --}}
                            @if ($plan['owned_count'] > 0)
                                <hr>

                                <div class="mb-2">
                                    <span class="badge bg-info">
                                        Dimiliki: {{ $plan['owned_count'] }} Paket
                                    </span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span>Total Kuota</span>
                                    <strong>{{ $plan['total_quota'] }}</strong>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <span>Terpakai</span>
                                    <strong class="text-danger">
                                        {{ $plan['used_event'] }}
                                    </strong>
                                </div>

                                <div class="d-flex justify-content-between mb-2">
                                    <span>Sisa</span>
                                    <strong class="text-success">
                                        {{ $plan['remaining'] }}
                                    </strong>
                                </div>

                                <div class="progress" style="height:6px;">
                                    <div class="progress-bar bg-success" style="width: {{ $plan['percentage'] }}%">
                                    </div>
                                </div>

                                <small class="text-muted">
                                    {{ $plan['percentage'] }}% digunakan
                                </small>
                            @endif

                        </div>

                        {{-- FOOTER --}}
                        <div class="card-footer bg-transparent border-0 text-center">
                            <a href="{{ route('checkout', $plan['id']) }}" class="btn btn-primary w-100">
                                <i class="ti ti-plus"></i> Beli Paket Lagi
                            </a>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>

    </main>
@endsection
