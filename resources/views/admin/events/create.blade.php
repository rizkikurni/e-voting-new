@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="row">
        <div class="col-xl-9 mx-auto">
            <h6 class="mb-0 text-uppercase">Tambah Event</h6>
            <hr />

            <div class="card">
                <div class="card-body">
                    <div class="border p-4 rounded">

                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Form Tambah Event</h5>
                        </div>
                        <hr />

                        <form action="{{ route('events.store') }}" method="POST">
                            @csrf

                            {{-- INFO PAKET --}}
                            <div class="alert alert-info">
                                <strong>Paket Aktif:</strong> {{ $userPlan->plan->name }} <br>
                                <small>
                                    Sisa Event:
                                    {{ $userPlan->plan->max_event - $userPlan->used_event }}
                                </small>
                            </div>

                            {{-- Hidden --}}
                            <input type="hidden" name="user_plan_id" value="{{ $userPlan->id }}">
                            <input type="hidden" name="plan_id" value="{{ $userPlan->plan_id }}">

                            {{-- Judul --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Judul Event</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                           name="title"
                                           value="{{ old('title') }}"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="Contoh: Pemilihan Ketua BEM 2025">
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Deskripsi --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Deskripsi</label>
                                <div class="col-sm-9">
                                    <textarea name="description"
                                              rows="4"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Deskripsi singkat event">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Waktu Mulai --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Waktu Mulai</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local"
                                           name="start_time"
                                           value="{{ old('start_time') }}"
                                           class="form-control @error('start_time') is-invalid @enderror">
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Waktu Selesai --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Waktu Selesai</label>
                                <div class="col-sm-9">
                                    <input type="datetime-local"
                                           name="end_time"
                                           value="{{ old('end_time') }}"
                                           class="form-control @error('end_time') is-invalid @enderror">
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            {{-- SUBMIT --}}
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary px-5">
                                        Simpan
                                    </button>
                                    <a href="{{ route('events.index') }}"
                                       class="btn btn-secondary px-4">
                                        Kembali
                                    </a>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection
