@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Langganan User</h6>
                <small class="text-muted">Daftar paket subscription yang tersedia</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table id="example2" class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr class="text-center">
                                <th>Nama Plan</th>
                                <th>Harga</th>
                                <th>Max Event</th>
                                <th>Max Kandidat</th>
                                <th>Max Pemilih</th>
                                <th>Total User</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($plans as $plan)
                                <tr>
                                    {{-- NAMA PLAN --}}
                                    <td class="fw-semibold text-center">
                                        {{ $plan->name }}
                                    </td>

                                    {{-- HARGA --}}
                                    <td class="text-end fw-semibold">
                                        Rp {{ number_format($plan->price, 0, ',', '.') }}
                                    </td>

                                    {{-- LIMIT --}}
                                    <td class="text-center">{{ $plan->max_event }}</td>
                                    <td class="text-center">{{ $plan->max_candidates }}</td>
                                    <td class="text-center">{{ $plan->max_voters }}</td>

                                    {{-- TOTAL USER --}}
                                    <td class="text-center">
                                        <span class="badge bg-info">
                                            {{ $plan->total_subscribers }} User
                                        </span>
                                    </td>

                                    {{-- AKSI --}}
                                    <td class="text-center">
                                        <a href="{{ route('admin.subscriptions.show', $plan->id) }}"
                                            class="btn btn-outline-primary btn-sm" data-bs-toggle="tooltip"
                                            title="Lihat User Berlangganan">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted">
                                        Belum ada subscription plan
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
