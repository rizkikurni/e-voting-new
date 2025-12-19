@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h6 class="mb-0 text-uppercase fw-bold">Tambah Token</h6>
            <small class="text-muted">
                Event: {{ $event->title }}
            </small>
        </div>

        <a href="{{ route('voter-tokens.show', $event->id) }}"
           class="btn btn-secondary btn-sm radius-30">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>

    <hr />

    {{-- INFO --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <small>Total Token Saat Ini</small>
                    <h5>{{ $currentTotal }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <small>Batas Paket</small>
                    <h5>{{ $maxVoters }}</h5>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <small>Sisa Bisa Ditambah</small>
                    <h5 class="text-success">{{ $remaining }}</h5>
                </div>
            </div>
        </div>
    </div>

    {{-- FORM --}}
    <div class="card">
        <div class="card-body">

            <form action="{{ route('voter-tokens.add', $event->id) }}"
                  method="POST">
                @csrf

                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label">
                        Jumlah Tambahan Token
                    </label>

                    <div class="col-sm-9">
                        <input type="number"
                               name="amount"
                               min="1"
                               max="{{ $remaining }}"
                               value="{{ old('amount') }}"
                               class="form-control @error('amount') is-invalid @enderror"
                               placeholder="Masukkan jumlah token tambahan">

                        <small class="text-muted">
                            Maksimal {{ $remaining }} token
                        </small>

                        @error('amount')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                        <button type="submit"
                                class="btn btn-primary px-5">
                            Tambahkan
                        </button>

                        <a href="{{ route('voter-tokens.show', $event->id) }}"
                           class="btn btn-secondary px-4">
                            Batal
                        </a>
                    </div>
                </div>

            </form>

        </div>
    </div>

</main>
@endsection
