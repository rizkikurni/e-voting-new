<header id="home" class="header-area">
    <div id="header-sticky" class="menu-area">
        <div class="container">
            <div class="second-menu">
                <div class="row align-items-center">

                    <!-- Logo -->
                    <div class="col-xl-3 col-lg-3">
                        <div class="logo">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('img/logo.png') }}" alt="logo"
                                    style="height: 70px; width: auto;">
                            </a>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <div class="col-xl-6 col-lg-9">
                        <div class="responsive">
                            <i class="icon dripicons-align-right"></i>
                        </div>

                        <div class="main-menu text-right text-xl-center">
                            <nav id="mobile-menu">
                                <ul>
                                    <li class="active">
                                        <a href="#home">Home</a>
                                    </li>
                                    <li>
                                        <a href="#about">Tentang Sistem</a>
                                    </li>
                                    <li>
                                        <a href="#how-it-works">Cara Kerja</a>
                                    </li>
                                    <li>
                                        <a href="#pricing">Paket & Harga</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <!-- Button -->
                    <div class="col-xl-3 text-right d-none d-xl-block">
                        <div class="header-btn second-header-btn">
                            <a href="{{ route('login') }}" class="btn">
                                Login
                            </a>
                            {{-- <a href="{{ route('register') }}" class="btn btn-border ml-2">
                                Daftar
                            </a> --}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>
