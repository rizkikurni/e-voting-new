@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="row">
        <div class="col-xl-9 mx-auto">
            <h6 class="mb-0 text-uppercase">Edit Event</h6>
            <hr />

            <div class="card">
                <div class="card-body">
                    <div class="border p-4 rounded">

                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Form Edit Event</h5>
                        </div>
                        <hr />

                        {{-- INFO STATUS --}}
                        <div class="alert alert-secondary">
                            <strong>Paket:</strong> {{ $event->userPlan->plan->name }} <br>
                            <strong>Status:</strong>
                            @if ($event->is_locked)
                                <span class="badge bg-danger">Locked</span>
                            @elseif ($event->is_published)
                                <span class="badge bg-success">Published</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                        </div>

                        @if (! $event->isEditable())
                            <div class="alert alert-warning">
                                Event sudah dipublish atau dikunci dan tidak bisa diedit.
                            </div>
                        @endif

                        <form action="{{ route('events.update', $event->id) }}"
                              method="POST">
                            @csrf
                            @method('PUT')

                            {{-- Hidden --}}
                            <input type="hidden" name="user_plan_id" value="{{ $event->user_plan_id }}">
                            <input type="hidden" name="plan_id" value="{{ $event->plan_id }}">

                            {{-- Judul --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Judul Event</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                           name="title"
                                           value="{{ old('title', $event->title) }}"
                                           class="form-control @error('title') is-invalid @enderror"
                                           {{ ! $event->isEditable() ? 'disabled' : '' }}>
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
                                              {{ ! $event->isEditable() ? 'disabled' : '' }}>{{ old('description', $event->description) }}</textarea>
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
                                           value="{{ old('start_time', $event->start_time->format('Y-m-d\TH:i')) }}"
                                           class="form-control @error('start_time') is-invalid @enderror"
                                           {{ ! $event->isEditable() ? 'disabled' : '' }}>
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
                                           value="{{ old('end_time', $event->end_time->format('Y-m-d\TH:i')) }}"
                                           class="form-control @error('end_time') is-invalid @enderror"
                                           {{ ! $event->isEditable() ? 'disabled' : '' }}>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            {{-- SUBMIT --}}
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    @if ($event->isEditable())
                                        <button type="submit" class="btn btn-primary px-5">
                                            Update
                                        </button>
                                    @endif

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
