@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <h6 class="mb-0 text-uppercase">Tambah Kandidat</h6>
    <small class="text-muted">{{ $event->title }}</small>
    <hr />

    <x-alert/>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('events.candidates.store', $event->id) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="fw-bold">Nama Kandidat</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name') }}">
                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Deskripsi</label>
                    <textarea name="description" class="form-control"
                              rows="4">{{ old('description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Foto</label>
                    <input type="file" name="photo" class="form-control">
                </div>

                <button class="btn btn-primary px-4">Simpan</button>
                <a href="{{ route('events.candidates.index', $event->id) }}"
                   class="btn btn-secondary px-4">Kembali</a>
            </form>
        </div>
    </div>

</main>
@endsection
