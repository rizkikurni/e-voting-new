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

                            <form action="{{ route('users.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                {{-- Name --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               name="name"
                                               value="{{ old('name', $user->name) }}"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Masukkan nama">
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
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Masukkan email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password (optional) --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Password (baru)</label>
                                    <div class="col-sm-9">
                                        <input type="password"
                                               name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Isi jika ingin ganti password">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti password.</small>
                                    </div>
                                </div>

                                {{-- Role --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Role</label>
                                    <div class="col-sm-9">
                                        <select name="role"
                                                class="form-select @error('role') is-invalid @enderror">
                                            <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
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
                                        <button type="submit" class="btn btn-warning px-5">Perbarui</button>
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
