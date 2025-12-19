@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">
                    Token Voting
                </h6>
                <small class="text-muted">
                    Event: {{ $event->title }}
                </small>
            </div>

            <a href="{{ route('voter-tokens.index') }}" class="btn btn-secondary btn-sm radius-30">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <hr />

        {{-- INFO EVENT --}}
        <div class="row mb-3">
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="mb-1">Total Token</h6>
                        <span class="badge bg-primary fs-6">
                            {{ $tokens->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="mb-1">Digunakan</h6>
                        <span class="badge bg-success fs-6">
                            {{ $tokens->where('is_used', true)->count() }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body text-center">
                        <h6 class="mb-1">Belum Digunakan</h6>
                        <span class="badge bg-secondary fs-6">
                            {{ $tokens->where('is_used', false)->count() }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE TOKEN --}}
        <div class="card">
            <div class="card-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="example2">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th>#</th>
                                <th>Kode Token</th>
                                <th>Link Event</th>
                                <th>Status</th>
                                <th>Dibuat</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($tokens as $index => $token)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">
                                        <code class="fs-6">{{ $token->token }}</code>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('voting.show', $event->id) }}" target="_blank">
                                            {{ route('voting.show', $event->id) }}
                                        </a>
                                    </td>



                                    <td class="text-center">
                                        @if ($token->is_used)
                                            <span class="badge bg-danger">Terpakai</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        {{ $token->created_at->format('d M Y H:i') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">
                                        Belum ada token
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
