@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h6 class="mb-0 text-uppercase fw-bold">Daftar Token Voting</h6>
                <small class="text-muted">Seluruh token yang dibuat untuk event voting</small>
            </div>
        </div>

        <div class="card">
            <div class="card-body">

                {{-- SEARCH --}}
                <form method="GET" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control"
                            placeholder="Cari token / event / organizer..." value="{{ request('search') }}">
                    </div>

                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search"></i> Cari
                        </button>
                    </div>

                    @if (request('search'))
                        <div class="col-md-2">
                            <a href="{{ route('admin.tokens.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-x-circle"></i> Reset
                            </a>
                        </div>
                    @endif
                </form>

                {{-- TABLE CUSTOM - Tidak menggunakan class bawaan template --}}
                <div class="custom-table-wrapper">
                    <div style="overflow-x: auto;">
                        <table class="custom-tokens-table">
                            <thead>
                                <tr>
                                    <th style="width: 50px; text-align: center;">#</th>
                                    <th style="min-width: 180px;">Token</th>
                                    <th style="min-width: 200px;">Event</th>
                                    <th style="min-width: 200px;">Penyelenggara</th>
                                    <th style="width: 120px; text-align: center;">Status</th>
                                    <th style="width: 100px; text-align: center;">Aksi</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse ($tokens as $index => $token)
                                    <tr>
                                        {{-- NO --}}
                                        <td style="text-align: center;">
                                            {{ $tokens->firstItem() + $index }}
                                        </td>

                                        {{-- TOKEN --}}
                                        <td>
                                            <span class="fw-semibold text-primary">{{ $token->token }}</span>
                                        </td>

                                        {{-- EVENT --}}
                                        <td>
                                            {{ $token->event?->title ?? '-' }}
                                        </td>

                                        {{-- ORGANIZER --}}
                                        <td>
                                            <div>{{ $token->event?->owner?->name ?? '-' }}</div>
                                            @if ($token->event?->owner?->email)
                                                <small class="text-muted">{{ $token->event->owner->email }}</small>
                                            @endif
                                        </td>

                                        {{-- STATUS --}}
                                        <td style="text-align: center;">
                                            @if ($token->is_used)
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle-fill"></i> Terpakai
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-circle"></i> Belum
                                                </span>
                                            @endif
                                        </td>

                                        {{-- ACTION --}}
                                        <td style="text-align: center;">
                                            <a href="{{ route('admin.tokens.show', $token->id) }}"
                                                class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip"
                                                title="Detail Token">
                                                <i class="bi bi-eye-fill"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align: center; padding: 3rem 1rem;">
                                            <i class="bi bi-inbox"
                                                style="font-size: 3rem; color: #ccc; display: block; margin-bottom: 1rem;"></i>
                                            <span class="text-muted">Tidak ada data token</span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- CUSTOM PAGINATION --}}
                @if ($tokens->hasPages())
                    <div class="custom-pagination-wrapper">
                        <div class="pagination-info">
                            <small class="text-muted">
                                Menampilkan {{ $tokens->firstItem() ?? 0 }} - {{ $tokens->lastItem() ?? 0 }}
                                dari {{ $tokens->total() }} data
                            </small>
                        </div>

                        <div class="pagination-controls">
                            <nav aria-label="Pagination">
                                <ul class="custom-pagination">
                                    {{-- Previous --}}
                                    @if ($tokens->onFirstPage())
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="bi bi-chevron-left"></i></span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $tokens->appends(request()->except('page'))->previousPageUrl() }}">
                                                <i class="bi bi-chevron-left"></i>
                                            </a>
                                        </li>
                                    @endif

                                    {{-- Pages --}}
                                    @foreach ($tokens->getUrlRange(max(1, $tokens->currentPage() - 2), min($tokens->lastPage(), $tokens->currentPage() + 2)) as $page => $url)
                                        @if ($page == $tokens->currentPage())
                                            <li class="page-item active">
                                                <span class="page-link">{{ $page }}</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $tokens->appends(request()->except('page'))->url($page) }}">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach

                                    {{-- Next --}}
                                    @if ($tokens->hasMorePages())
                                        <li class="page-item">
                                            <a class="page-link"
                                                href="{{ $tokens->appends(request()->except('page'))->nextPageUrl() }}">
                                                <i class="bi bi-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li class="page-item disabled">
                                            <span class="page-link"><i class="bi bi-chevron-right"></i></span>
                                        </li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                    </div>
                @endif

            </div>
        </div>

    </main>
@endsection

{{-- CUSTOM STYLES --}}
@push('styles')
    <style>
        /* Custom Table Styles */
        .custom-tokens-table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        .custom-tokens-table thead {
            background: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .custom-tokens-table th {
            padding: 12px 15px;
            font-weight: 600;
            font-size: 13px;
            color: #495057;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-tokens-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            font-size: 14px;
            color: #212529;
            vertical-align: middle;
        }

        .custom-tokens-table tbody tr:last-child td {
            border-bottom: none;
        }

        .custom-tokens-table tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        /* Custom Pagination Styles */
        .custom-pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 1px solid #e9ecef;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .pagination-info {
            flex: 1;
            min-width: 200px;
        }

        .pagination-controls {
            flex: 1;
            display: flex;
            justify-content: flex-end;
        }

        .custom-pagination {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 5px;
        }

        .custom-pagination .page-item {
            display: inline-block;
        }

        .custom-pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            height: 38px;
            padding: 0.375rem 0.75rem;
            color: #6c757d;
            background-color: #fff;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .custom-pagination .page-link:hover {
            color: #0d6efd;
            background-color: #e7f1ff;
            border-color: #0d6efd;
        }

        .custom-pagination .page-item.active .page-link {
            color: #fff;
            background-color: #0d6efd;
            border-color: #0d6efd;
            font-weight: 600;
        }

        .custom-pagination .page-item.disabled .page-link {
            color: #adb5bd;
            background-color: #f8f9fa;
            border-color: #dee2e6;
            cursor: not-allowed;
            opacity: 0.6;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .custom-pagination-wrapper {
                flex-direction: column;
                align-items: stretch;
            }

            .pagination-info {
                text-align: center;
            }

            .pagination-controls {
                justify-content: center;
            }

            .custom-pagination .page-link {
                min-width: 35px;
                height: 35px;
                padding: 0.25rem 0.5rem;
                font-size: 13px;
            }
        }
    </style>
@endpush

{{-- SCRIPTS --}}
@push('scripts')
    <script>
        $(document).ready(function() {
            // Aktifkan tooltip
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
