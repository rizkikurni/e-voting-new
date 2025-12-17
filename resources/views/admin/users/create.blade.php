@extends('admin.layouts.app')

@section('content')
    <main class="page-content">

        <div class="row">
            <div class="col-xl-9 mx-auto">
                <h6 class="mb-0 text-uppercase">Tambah User</h6>
                <hr />
                <div class="card">
                    <div class="card-body">
                        <div class="border p-4 rounded">

                            <div class="card-title d-flex align-items-center">
                                <h5 class="mb-0">Form Tambah User</h5>
                            </div>
                            <hr />

                            <form action="{{ route('users.store') }}" method="POST">
                                @csrf

                                {{-- Name --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                                    <div class="col-sm-9">
                                        <input type="text"
                                               name="name"
                                               value="{{ old('name') }}"
                                               class="form-control @error('name') is-invalid @enderror"
                                               placeholder="Masukkan nama lengkap">
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
                                               value="{{ old('email') }}"
                                               class="form-control @error('email') is-invalid @enderror"
                                               placeholder="Masukkan email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Password --}}
                                <div class="row mb-3">
                                    <label class="col-sm-3 col-form-label">Password</label>
                                    <div class="col-sm-9">
                                        <input type="password"
                                               name="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               placeholder="Masukkan password">
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
                                            <option value="">-- Pilih Role --</option>
                                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="customer" {{ old('role') == 'customer' ? 'selected' : '' }}>Customer</option>
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
                                        <button type="submit" class="btn btn-primary px-5">Simpan</button>
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
