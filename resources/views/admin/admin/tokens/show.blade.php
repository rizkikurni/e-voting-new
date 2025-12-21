@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Detail Token Voting</h6>
                <small class="text-muted">Informasi lengkap token dan penggunaannya</small>
            </div>

            <a href="{{ route('admin.tokens.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="row g-3">

            {{-- LEFT : TOKEN INFO --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header fw-semibold">
                        Informasi Token
                    </div>
                    <div class="card-body">

                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="35%" class="text-muted">Token</td>
                                <td class="fw-semibold">{{ $token->token }}</td>
                            </tr>

                            <tr>
                                <td class="text-muted">Status</td>
                                <td>
                                    @if ($token->is_used)
                                        <span class="badge bg-success">
                                            <i class="bi bi-check-circle-fill"></i> Used
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">
                                            <i class="bi bi-circle"></i> Not Used
                                        </span>
                                    @endif
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted">Dibuat</td>
                                <td>
                                    {{ $token->created_at->format('d M Y') }}
                                    <small class="text-muted">
                                        {{ $token->created_at->format('H:i') }}
                                    </small>
                                </td>
                            </tr>

                            @if ($token->is_used)
                                <tr>
                                    <td class="text-muted">Digunakan</td>
                                    <td>
                                        {{ optional($token->vote)->created_at?->format('d M Y H:i') ?? '-' }}
                                    </td>
                                </tr>
                            @endif
                        </table>

                    </div>
                </div>
            </div>

            {{-- RIGHT : EVENT INFO --}}
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="card-header fw-semibold">
                        Informasi Event
                    </div>
                    <div class="card-body">

                        <table class="table table-borderless mb-0">
                            <tr>
                                <td width="35%" class="text-muted">Nama Event</td>
                                <td class="fw-semibold">
                                    {{ $token->event?->title ?? '-' }}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted">Penyelenggara</td>
                                <td>
                                    {{ $token->event?->owner?->name ?? '-' }} <br>
                                    <small class="text-muted">
                                        {{ $token->event?->owner?->email ?? '' }}
                                    </small>
                                </td>
                            </tr>

                            <tr>
                                <td class="text-muted">Event ID</td>
                                <td>{{ $token->event?->id ?? '-' }}</td>
                            </tr>
                        </table>

                    </div>
                </div>
            </div>

            {{-- FULL WIDTH : VOTING INFO --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header fw-semibold">
                        Informasi Voting
                    </div>
                    <div class="card-body">

                        @if ($token->is_used && $token->vote)
                            <table class="table table-bordered align-middle">
                                <tr>
                                    <th width="30%">Kandidat Dipilih</th>
                                    <td class="fw-semibold">
                                        {{ $token->vote->candidate?->name ?? '-' }}
                                    </td>
                                </tr>

                                <tr>
                                    <th>Waktu Voting</th>
                                    <td>
                                        {{ $token->vote->created_at->format('d M Y') }}
                                        <small class="text-muted">
                                            {{ $token->vote->created_at->format('H:i') }}
                                        </small>
                                    </td>
                                </tr>

                                <tr>
                                    <th>Vote ID</th>
                                    <td>{{ $token->vote->id }}</td>
                                </tr>
                            </table>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="bi bi-info-circle fs-3 d-block mb-2"></i>
                                Token ini belum digunakan untuk voting
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>

    </main>
@endsection
