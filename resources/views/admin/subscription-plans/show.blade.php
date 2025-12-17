@extends('admin.layouts.app')

@section('content')
    <main class="page-content">
        <div class="container-fluid">

            <h4 class="fw-bold mb-4">Detail Subscription Plan</h4>

            <div class="card shadow-sm">
                <div class="card-body">

                    <table class="table table-bordered">
                        <tr>
                            <th width="250">Nama Plan</th>
                            <td>{{ $subscriptionPlan->name }}</td>
                        </tr>
                        <tr>
                            <th>Harga</th>
                            <td>Rp {{ number_format($subscriptionPlan->price, 0, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <th>Max Event</th>
                            <td>{{ $subscriptionPlan->max_event }}</td>
                        </tr>
                        <tr>
                            <th>Max Kandidat</th>
                            <td>{{ $subscriptionPlan->max_candidates }}</td>
                        </tr>
                        <tr>
                            <th>Max Pemilih</th>
                            <td>{{ $subscriptionPlan->max_voters }}</td>
                        </tr>
                        <tr>
                            <th>Fitur</th>
                            <td>
                                <ul class="mb-0">
                                    <li>Report: {{ $subscriptionPlan->features['report'] ?? false ? 'Ya' : 'Tidak' }}</li>
                                    <li>Export: {{ $subscriptionPlan->features['export'] ?? false ? 'Ya' : 'Tidak' }}</li>
                                    <li>Custom: {{ $subscriptionPlan->features['custom'] ?? false ? 'Ya' : 'Tidak' }}</li>
                                </ul>
                            </td>
                        </tr>
                    </table>

                    <a href="{{ route('subscription-plans.index') }}" class="btn btn-secondary">
                        Kembali
                    </a>

                </div>
            </div>

        </div>
    </main>
@endsection
