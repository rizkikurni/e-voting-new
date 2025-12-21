@extends('admin.layouts.app')
@section('content')
<main class="page-content">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold">Subscription Plans</h4>
            <a href="{{ route('subscription-plans.create') }}" class="btn btn-primary">
                + Tambah Plan
            </a>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Max Event</th>
                            <th>Max Kandidat</th>
                            <th>Max Pemilih</th>
                            <th>Rekomendasi</th>
                            <th width="200">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($plans as $plan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $plan->name }}</td>
                                <td>Rp {{ number_format($plan->price, 0, ',', '.') }}</td>
                                <td>{{ $plan->max_event }}</td>
                                <td>{{ $plan->max_candidates }}</td>
                                <td>{{ $plan->max_voters }}</td>
                                <td>{{ $plan->is_recommended == 'yes' ? 'Ya' : 'Tidak' }}</td>
                                <td>
                                    <a href="{{ route('subscription-plans.show', $plan->id) }}"
                                        class="btn btn-info btn-sm">Detail</a>

                                    <a href="{{ route('subscription-plans.edit', $plan->id) }}"
                                        class="btn btn-warning btn-sm">Edit</a>

                                    <form action="{{ route('subscription-plans.destroy', $plan->id) }}" method="POST"
                                        class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">
                                    Data belum tersedia
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
