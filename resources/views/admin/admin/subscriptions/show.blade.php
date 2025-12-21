@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Detail Langganan</h6>
                <small class="text-muted">
                    Paket: {{ $plan->name }}
                </small>
            </div>

            <a href="{{ route('admin.subscriptions.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example2" class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>User</th>
                                <th>Email</th>
                                <th>Order ID</th>
                                <th>Jumlah Event</th>
                                <th>Status</th>
                                <th>Tanggal Beli</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($plan->userPlans as $userPlan)
                                <tr>
                                    {{-- USER --}}
                                    <td class="fw-semibold">
                                        {{ $userPlan->user->name }}
                                    </td>

                                    {{-- EMAIL --}}
                                    <td>
                                        {{ $userPlan->user->email }}
                                    </td>

                                    {{-- ORDER --}}
                                    <td class="text-center">
                                        {{ $userPlan->payment?->order_id ?? '-' }}
                                    </td>

                                    {{-- EVENT --}}
                                    <td class="text-center">
                                        <span class="badge bg-secondary">
                                            {{ $userPlan->events->count() }}
                                        </span>
                                    </td>

                                    {{-- STATUS --}}
                                    <td class="text-center">
                                        <span class="badge bg-success">
                                            PAID
                                        </span>
                                    </td>

                                    {{-- WAKTU --}}
                                    <td class="text-center">
                                        {{ $userPlan->purchased_at?->format('d M Y') ?? '-' }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $userPlan->purchased_at?->format('H:i') ?? '' }}
                                        </small>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted">
                                        Belum ada user yang berlangganan paket ini
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
