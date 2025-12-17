@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h6 class="mb-0 text-uppercase">Detail User</h6>

        <div>
            <a href="{{ route('users.edit', $user->id) }}"
               class="btn btn-warning btn-sm radius-30">
                <i class="bi bi-pencil-fill"></i> Edit
            </a>

            <a href="{{ route('users.index') }}"
               class="btn btn-secondary btn-sm radius-30">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <hr />

    <div class="card">
        <div class="card-body">

            <div class="row g-4">

                {{-- Foto Profil --}}
                <div class="col-md-12 text-center">
                    @if ($user->photo_path && file_exists(public_path('photo/' . $user->photo_path)))
                        <img src="{{ asset('photo/' . $user->photo_path) }}"
                             class="rounded-circle mb-3"
                             width="96" height="96">
                    @else
                        <span style="
                            width:96px;
                            height:96px;
                            border:3px solid #ccc;
                            border-radius:50%;
                            display:inline-flex;
                            align-items:center;
                            justify-content:center;
                            margin-bottom:1rem;">
                            <i class="lni lni-user" style="font-size:36px;"></i>
                        </span>
                    @endif
                </div>

                {{-- Name --}}
                <div class="col-md-6">
                    <label class="fw-bold">Nama Lengkap</label>
                    <div class="form-control bg-light">{{ $user->name }}</div>
                </div>

                {{-- Email --}}
                <div class="col-md-6">
                    <label class="fw-bold">Email</label>
                    <div class="form-control bg-light">{{ $user->email }}</div>
                </div>

                {{-- Role --}}
                <div class="col-md-6">
                    <label class="fw-bold">Role</label>
                    <div class="form-control bg-light">
                        <span class="badge
                            {{ $user->role === 'admin' ? 'bg-primary' : 'bg-success' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                </div>

                {{-- Trial --}}
                <div class="col-md-6">
                    <label class="fw-bold">Trial Dipakai?</label>
                    <div class="form-control bg-light">
                        @if ($user->is_trial_used)
                            <span class="badge bg-danger">Sudah</span>
                        @else
                            <span class="badge bg-info">Belum</span>
                        @endif
                    </div>
                </div>

                {{-- Created --}}
                <div class="col-md-6">
                    <label class="fw-bold">Dibuat Pada</label>
                    <div class="form-control bg-light">
                        {{ $user->created_at->format('d M Y H:i') }}
                    </div>
                </div>

                {{-- Updated --}}
                <div class="col-md-6">
                    <label class="fw-bold">Terakhir Diperbarui</label>
                    <div class="form-control bg-light">
                        {{ $user->updated_at->format('d M Y H:i') }}
                    </div>
                </div>

            </div>

        </div>
    </div>

</main>
@endsection
