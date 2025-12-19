@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <h6 class="mb-0 text-uppercase">Edit Kandidat</h6>
    <small class="text-muted">{{ $event->title }}</small>
    <hr />

    <div class="card">
        <div class="card-body">
            <form action="{{ route('events.candidates.update', [$event->id, $candidate->id]) }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="fw-bold">Nama Kandidat</label>
                    <input type="text" name="name"
                           class="form-control"
                           value="{{ old('name', $candidate->name) }}">
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Deskripsi</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $candidate->description) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="fw-bold">Ganti Foto</label>
                    <input type="file" name="photo" class="form-control">
                </div>

                <button class="btn btn-primary px-4">Update</button>
                <a href="{{ route('events.candidates.index', $event->id) }}"
                   class="btn btn-secondary px-4">Kembali</a>
            </form>
        </div>
    </div>

</main>
@endsection
