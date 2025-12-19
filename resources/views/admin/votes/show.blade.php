@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="mb-0 text-uppercase fw-bold">Detail Hasil Voting</h6>
            <small class="text-muted">{{ $event->title }}</small>
        </div>

        <a href="{{ route('votes.index') }}"
           class="btn btn-secondary btn-sm">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- PEMENANG --}}
    <div class="card mb-3">
        <div class="card-body text-center">
            <h6 class="mb-2">Pemenang</h6>

            @if ($winner)
                <h4 class="fw-bold text-success">{{ $winner->name }}</h4>
                <span class="badge bg-success">
                    {{ $winner->votes_count }} suara
                </span>
            @else
                <span class="badge bg-secondary">Belum ada suara</span>
            @endif
        </div>
    </div>

    {{-- PEROLEHAN --}}
    <div class="card mb-3">
        <div class="card-body">

            <h6 class="mb-3">Perolehan Suara</h6>

            <table class="table table-bordered align-middle">
                <thead class="table-light text-center">
                    <tr>
                        <th>Kandidat</th>
                        <th>Jumlah Suara</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($event->candidates as $candidate)
                        <tr>
                            <td>{{ $candidate->name }}</td>
                            <td class="text-center">
                                <span class="badge bg-primary">
                                    {{ $candidate->votes_count }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

    {{-- TOKEN --}}
    <div class="card">
        <div class="card-body">
            <h6 class="mb-3">Statistik Token</h6>

            <div class="row text-center">
                <div class="col-md-4">
                    <div class="p-3 border rounded">
                        <strong>Total Token</strong><br>
                        {{ $event->tokens->count() }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded bg-light">
                        <strong>Digunakan</strong><br>
                        {{ $event->tokens->where('is_used', true)->count() }}
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 border rounded">
                        <strong>Sisa</strong><br>
                        {{ $event->tokens->where('is_used', false)->count() }}
                    </div>
                </div>
            </div>

        </div>
    </div>

</main>
@endsection
