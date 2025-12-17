@extends('admin.layouts.app')

@section('content')
    <main class="page-content">
        <div class="container-fluid">

            <h4 class="fw-bold mb-4">Edit Subscription Plan</h4>

            <div class="card shadow-sm">
                <div class="card-body">

                    <form action="{{ route('subscription-plans.update', $subscriptionPlan->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">Nama Plan</label>
                            <input type="text" name="name" class="form-control" value="{{ $subscriptionPlan->name }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" name="price" class="form-control"
                                value="{{ $subscriptionPlan->price }}">
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Event</label>
                                <input type="number" name="max_event" class="form-control"
                                    value="{{ $subscriptionPlan->max_event }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Kandidat</label>
                                <input type="number" name="max_candidates" class="form-control"
                                    value="{{ $subscriptionPlan->max_candidates }}">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Max Pemilih</label>
                                <input type="number" name="max_voters" class="form-control"
                                    value="{{ $subscriptionPlan->max_voters }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Fitur Plan</label>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="feature_report"
                                    {{ $subscriptionPlan->features['report'] ?? false ? 'checked' : '' }}>
                                <label class="form-check-label">Laporan (Report)</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="feature_export"
                                    {{ $subscriptionPlan->features['export'] ?? false ? 'checked' : '' }}>
                                <label class="form-check-label">Export Data</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="feature_custom"
                                    {{ $subscriptionPlan->features['custom'] ?? false ? 'checked' : '' }}>
                                <label class="form-check-label">Custom Feature</label>
                            </div>
                        </div>

                        <div class="d-flex gap-2">
                            <button class="btn btn-warning">Update</button>
                            <a href="{{ route('subscription-plans.index') }}" class="btn btn-secondary">Kembali</a>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </main>
@endsection
