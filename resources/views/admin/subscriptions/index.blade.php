@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    {{-- HEADER --}}
    <div class="mb-3">
        <h6 class="mb-0 text-uppercase fw-bold">My Subscriptions</h6>
        <small class="text-muted">Daftar paket langganan dan sisa kuota event</small>
    </div>

    <div class="row g-3">

        @forelse ($userPlans as $plan)
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm h-100 border-0">

                    <div class="card-body">
                        {{-- PLAN NAME --}}
                        <h6 class="fw-bold mb-1">
                            {{ $plan['plan_name'] }}
                        </h6>

                        <small class="text-muted">
                            Dibeli: {{ \Carbon\Carbon::parse($plan['purchased_at'])->format('d M Y') }}
                        </small>

                        <hr>

                        {{-- QUOTA INFO --}}
                        <div class="d-flex justify-content-between mb-1">
                            <span>Total Kuota</span>
                            <strong>{{ $plan['max_event'] }} Event</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-1">
                            <span>Terpakai</span>
                            <strong class="text-danger">{{ $plan['used_event'] }}</strong>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Sisa</span>
                            <strong class="text-success">{{ $plan['remaining'] }}</strong>
                        </div>

                        {{-- PROGRESS --}}
                        <div class="progress" style="height:6px;">
                            <div class="progress-bar
                                {{ $plan['percentage'] >= 100 ? 'bg-danger' : 'bg-success' }}"
                                role="progressbar"
                                style="width: {{ $plan['percentage'] }}%">
                            </div>
                        </div>

                        <small class="text-muted">
                            {{ $plan['percentage'] }}% digunakan
                        </small>
                    </div>

                    {{-- FOOTER --}}
                    <div class="card-footer bg-transparent border-0 text-center">
                        @if ($plan['is_available'])
                            <span class="badge bg-success">Aktif</span>
                        @else
                            <span class="badge bg-danger">Kuota Habis</span>
                        @endif
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Anda belum memiliki paket langganan.
                </div>
            </div>
        @endforelse

    </div>

</main>
@endsection
S
