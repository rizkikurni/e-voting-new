@extends('admin.layouts.app')

@section('content')
    <main class="page-content">
        <div class="container-fluid">

            <h4 class="fw-bold mb-4">Tambah Subscription Plan</h4>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('subscription-plans.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Plan</label>
                            <input type="text" name="name" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rekomendasi</label>
                            <select name="is_recommended" class="form-control">
                                <option value="no">Tidak</option>
                                <option value="yes">Ya</option>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Event</label>
                                <input type="number" name="max_event" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Kandidat</label>
                                <input type="number" name="max_candidates" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Pemilih</label>
                                <input type="number" name="max_voters" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Fitur Plan</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="feature_report" id="report">
                                <label class="form-check-label" for="report">Laporan (Report)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="feature_export" id="export">
                                <label class="form-check-label" for="export">Export Data</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="feature_custom" id="custom">
                                <label class="form-check-label" for="custom">Custom Feature</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-primary">Simpan</button>
                            <a href="{{ route('subscription-plans.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </main>
@endsection
