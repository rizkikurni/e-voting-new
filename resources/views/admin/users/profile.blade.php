@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="row">

        {{-- LEFT: FORM --}}
        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h5 class="mb-0">My Account</h5>
                    <hr>

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}"
                          method="POST"
                          enctype="multipart/form-data"
                          class="row g-3">
                        @csrf
                        @method('PUT')

                        {{-- Name --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text"
                                   name="name"
                                   value="{{ old('name', $user->name) }}"
                                   class="form-control @error('name') is-invalid @enderror">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email"
                                   name="email"
                                   value="{{ old('email', $user->email) }}"
                                   class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label">Password Baru</label>
                            <input type="password"
                                   name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   placeholder="Kosongkan jika tidak diubah">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="col-12 col-md-6">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password"
                                   name="password_confirmation"
                                   class="form-control"
                                   placeholder="Ulangi password">
                        </div>

                        {{-- Photo --}}
                        <div class="col-12">
                            <label class="form-label">Foto Profil</label>
                            <input type="file"
                                   name="photo"
                                   class="form-control @error('photo') is-invalid @enderror">
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Submit --}}
                        <div class="col-12 text-start">
                            <button type="submit" class="btn btn-primary px-4">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        {{-- RIGHT: PROFILE CARD --}}
        <div class="col-12 col-lg-4">
            <div class="card shadow-sm border-0 overflow-hidden">
                <div class="card-body text-center">

                    {{-- Avatar --}}
                    @if ($user->photo_path && file_exists(public_path('photo/' . $user->photo_path)))
                        <img src="{{ asset('photo/' . $user->photo_path) }}"
                             class="rounded-circle shadow mb-3"
                             width="120" height="120">
                    @else
                        <span style="
                            width:120px;
                            height:120px;
                            border:3px solid #ccc;
                            border-radius:50%;
                            display:inline-flex;
                            align-items:center;
                            justify-content:center;
                            margin-bottom:1rem;">
                            <i class="lni lni-user" style="font-size:42px;"></i>
                        </span>
                    @endif

                    <h5 class="mb-1">{{ $user->name }}</h5>
                    <p class="text-secondary mb-2">{{ $user->email }}</p>

                    <span class="badge {{ $user->role === 'admin' ? 'bg-primary' : 'bg-success' }}">
                        {{ ucfirst($user->role) }}
                    </span>

                    <hr>

                    <div class="text-start">
                        <h6>Informasi Akun</h6>
                        <p class="mb-1">
                            <strong>Dibuat:</strong>
                            {{ $user->created_at->format('d M Y') }}
                        </p>
                        <p class="mb-0">
                            <strong>Update:</strong>
                            {{ $user->updated_at->format('d M Y') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

    </div>

</main>
@endsection
