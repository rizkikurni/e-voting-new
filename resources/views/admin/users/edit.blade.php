@extends('admin.layouts.app')

@section('content')
<main class="page-content">

    <div class="row">
        <div class="col-xl-9 mx-auto">
            <h6 class="mb-0 text-uppercase">Edit User</h6>
            <hr />

            <div class="card">
                <div class="card-body">
                    <div class="border p-4 rounded">

                        <div class="card-title d-flex align-items-center">
                            <h5 class="mb-0">Form Edit User</h5>
                        </div>
                        <hr />

                        <form action="{{ route('users.update', $user->id) }}"
                              method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            {{-- Foto Profil --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Foto Profil</label>
                                <div class="col-sm-9 d-flex align-items-center gap-3">

                                    @if ($user->photo_path && file_exists(public_path('photo/' . $user->photo_path)))
                                        <img src="{{ asset('photo/' . $user->photo_path) }}"
                                             class="rounded-circle"
                                             width="54" height="54">
                                    @else
                                        <span style="
                                            width:54px;
                                            height:54px;
                                            border:2px solid #999;
                                            border-radius:50%;
                                            display:inline-flex;
                                            align-items:center;
                                            justify-content:center;">
                                            <i class="lni lni-user"></i>
                                        </span>
                                    @endif

                                    <input type="file"
                                           name="photo"
                                           class="form-control @error('photo') is-invalid @enderror">

                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Name --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                <div class="col-sm-9">
                                    <input type="text"
                                           name="name"
                                           value="{{ old('name', $user->name) }}"
                                           class="form-control @error('name') is-invalid @enderror">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Email --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Email</label>
                                <div class="col-sm-9">
                                    <input type="email"
                                           name="email"
                                           value="{{ old('email', $user->email) }}"
                                           class="form-control @error('email') is-invalid @enderror">
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Password (opsional) --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Password</label>
                                <div class="col-sm-9">
                                    <input type="password"
                                           name="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           placeholder="Kosongkan jika tidak diubah">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Role --}}
                            <div class="row mb-3">
                                <label class="col-sm-3 col-form-label">Role</label>
                                <div class="col-sm-9">
                                    <select name="role"
                                            class="form-select @error('role') is-invalid @enderror">
                                        <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                            Admin
                                        </option>
                                        <option value="customer" {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>
                                            Customer
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Submit --}}
                            <div class="row">
                                <label class="col-sm-3 col-form-label"></label>
                                <div class="col-sm-9">
                                    <button type="submit" class="btn btn-primary px-5">Update</button>
                                    <a href="{{ route('users.index') }}" class="btn btn-secondary px-4">Kembali</a>
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
