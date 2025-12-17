@extends('auth.layouts.app')

@section('content')
    <div class="wrapper">
        <main class="authentication-content">
            <div class="container-fluid">
                <div class="authentication-card">
                    <div class="card shadow rounded-0 overflow-hidden">
                        <div class="row g-0">
                            <div class="col-lg-6 bg-login d-flex align-items-center justify-content-center">
                                <img src="{{ asset('admin/assets/images/error/login-img.jpg') }}" class="img-fluid" alt="">
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body p-4 p-sm-5">

                                    <h5 class="card-title">Register</h5>
                                    <p class="card-text mb-5">Masukan data diri yang sesuai</p>

                                    {{-- ALERT ERROR --}}
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    <form class="form-body" action="{{ route('register') }}" method="POST">
                                        @csrf

                                        {{-- <div class="login-separater text-center mb-4">
                                            <span>REGISTER WITH EMAIL</span>
                                            <hr>
                                        </div> --}}

                                        <div class="row g-3">

                                            <div class="col-12">
                                                <label class="form-label">Full Name</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                        <i class="bi bi-person-fill"></i>
                                                    </div>
                                                    <input type="text" name="name"
                                                        class="form-control radius-30 ps-5" placeholder="Full Name"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Email Address</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                        <i class="bi bi-envelope-fill"></i>
                                                    </div>
                                                    <input type="email" name="email"
                                                        class="form-control radius-30 ps-5" placeholder="Email Address"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label class="form-label">Password</label>
                                                <div class="ms-auto position-relative">
                                                    <div class="position-absolute top-50 translate-middle-y search-icon px-3">
                                                        <i class="bi bi-lock-fill"></i>
                                                    </div>
                                                    <input type="password" name="password"
                                                        class="form-control radius-30 ps-5" placeholder="Password"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="d-grid">
                                                    <button type="submit" class="btn btn-primary radius-30">Register</button>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <p class="mb-0">Sudah punya akun?
                                                    <a href="{{ route('login') }}">Login</a>
                                                </p>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
@endsection
