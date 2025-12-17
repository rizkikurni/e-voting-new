@extends('landing.layouts.app')

@section('content')
    <main>
        <!-- slider-area -->
        <section id="parallax"
            class="slider-area slider-bg second-slider-bg d-flex align-items-center justify-content-center fix "
            style="background-image:url({{ asset('landing/img/header1_bg_img.jpg') }})">

            <!-- Shapes -->
            <div class="slider-shape ss-one layer" data-depth="0.10">
                <img src="{{ asset('landing/img/shape/slider_shape01.png') }}" alt="shape">
            </div>
            <div class="slider-shape ss-two layer" data-depth="0.30">
                <img src="{{ asset('landing/img/shape/slider_shape02.png') }}" alt="shape">
            </div>
            <div class="slider-shape ss-three layer" data-depth="0.40">
                <img src="{{ asset('landing/img/shape/slider_shape03.png') }}" alt="shape">
            </div>
            <div class="slider-shape ss-four layer" data-depth="0.60">
                <img src="{{ asset('landing/img/shape/slider_shape04.png') }}" alt="shape">
            </div>
            <div class="slider-shape ss-five layer" data-depth="0.20">
                <img src="{{ asset('landing/img/shape/slider_shape05.png') }}" alt="shape">
            </div>
            <div class="slider-shape ss-six layer" data-depth="0.15">
                <img src="{{ asset('landing/img/shape/slider_shape06.png') }}" alt="shape">
            </div>
            <div class="slider-shape ss-eight layer" data-depth="0.15">
                <img src="{{ asset('img/hero.png') }}" alt="shape">
            </div>

            <!-- Content -->
            <div class="slider-active">
                <div class="single-slider">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-9 col-md-10">
                                <div class="slider-content second-slider-content">

                                    <ul data-animation="fadeInUp animated" data-delay=".2s">
                                        <li>
                                            <i class="fas fa-shield-alt"></i>
                                            Aman, Transparan, Terverifikasi
                                        </li>
                                        <li>
                                            <i class="fas fa-users"></i>
                                            Cocok untuk Organisasi, Kampus, & Komunitas
                                        </li>
                                    </ul>

                                    <h2 data-animation="fadeInUp animated" data-delay=".4s">
                                        Sistem <span>E-Voting Online</span><br>
                                        Mudah, Cepat, & Terpercaya
                                    </h2>

                                    <p data-animation="fadeInUp animated" data-delay=".6s">
                                        Kelola pemilihan secara digital dengan token unik,
                                        hasil real-time, dan kontrol penuh atas event Anda.
                                    </p>

                                    <div class="slider-btn mt-4" data-animation="fadeInUp animated" data-delay=".8s">
                                        <a href="{{ route('register') }}" class="btn mr-3">
                                            Coba Gratis
                                        </a>
                                        <a href="#pricing" class="btn btn-outline-light">
                                            Lihat Paket
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- about-area -->
        <section id="about" class="about-area about-p pt-120 pb-120 p-relative">
            <div class="container">
                <div class="row align-items-center">

                    <!-- Left: Feature List -->
                    <div class="col-lg-6">

                        <div class="feature-box wow fadeInDown animated" data-delay=".2s">
                            <div class="crl mb-30">
                                <img src="{{ asset('landing/img/icon_1.png') }}" alt="icon">
                                <span>1</span>
                            </div>
                            <h4>Token Voting Unik</h4>
                            <p>Setiap pemilih mendapatkan token unik yang hanya bisa digunakan satu kali.</p>
                        </div>

                        <div class="feature-box wow fadeInDown animated" data-delay=".3s">
                            <div class="crl mb-30">
                                <img src="{{ asset('landing/img/icon_2.png') }}" alt="icon">
                                <span>2</span>
                            </div>
                            <h4>Kelola Banyak Event</h4>
                            <p>Buat dan atur beberapa event pemilihan dalam satu akun.</p>
                        </div>

                        <div class="feature-box wow fadeInDown animated" data-delay=".4s">
                            <div class="crl mb-30">
                                <img src="{{ asset('landing/img/icon_3.png') }}" alt="icon">
                                <span>3</span>
                            </div>
                            <h4>Hasil Real-Time</h4>
                            <p>Pantau hasil voting secara langsung tanpa perlu rekap manual.</p>
                        </div>

                        <div class="feature-box wow fadeInDown animated" data-delay=".5s">
                            <div class="crl mb-30">
                                <img src="{{ asset('landing/img/icon_4.png') }}" alt="icon">
                                <span>4</span>
                            </div>
                            <h4>Aman & Transparan</h4>
                            <p>Data voting tersimpan aman dan tidak dapat dimanipulasi.</p>
                        </div>

                    </div>

                    <!-- Right: Description -->
                    <div class="col-lg-6">
                        <div class="about-content s-about-content pl-30">

                            <div class="about-title second-atitle">
                                <div class="text-outline wow fadeInUp animated" data-delay=".2s">
                                    <span>E-Voting</span>
                                </div>
                                <span class="wow fadeInUp animated" data-delay=".3s">
                                    Kenapa memilih sistem kami?
                                </span>
                                <h2 class="wow fadeInUp animated" data-delay=".4s">
                                    Solusi Pemilihan Digital yang Praktis
                                </h2>
                                <h5 class="wow fadeInUp animated" data-delay=".5s">
                                    <span></span>Dirancang untuk organisasi modern
                                </h5>
                            </div>

                            <div class="wow fadeInUp animated" data-delay=".6s">
                                <p>
                                    Sistem e-voting ini membantu organisasi, kampus, dan komunitas
                                    melaksanakan pemilihan secara online tanpa ribet.
                                </p>
                                <p>
                                    Mulai dari pembuatan event, pengelolaan kandidat, distribusi token,
                                    hingga hasil voting, semuanya terintegrasi dalam satu sistem.
                                </p>

                                <a href="#pricing" class="btn mt-20">
                                    Lihat Paket
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- about-area-end -->

        <!-- how-it-works-area -->
        <section id="how-it-works" class="counter-area pt-120 pb-120"
            style="background-image:url({{ asset('landing/img/counter_bg.jpg') }}); background-size: cover;">

            <div class="container">
                <div class="row align-items-center">

                    <!-- Left Content -->
                    <div class="col-lg-6 col-sm-12">
                        <div class="about-title second-atitle">
                            <span class="wow fadeInUp animated" data-delay=".2s">
                                Cara Kerja
                            </span>
                            <h2 class="wow fadeInUp animated" data-delay=".3s">
                                Proses E-Voting yang Sederhana
                            </h2>
                            <h5 class="wow fadeInUp animated" data-delay=".4s">
                                Dari setup sampai hasil, semua terkontrol
                            </h5>
                        </div>

                        <ul class="wow fadeInUp animated" data-delay=".5s" style="list-style:none; padding:0;">
                            <li style="display:flex; align-items:center; margin-bottom:20px;">
                                <span
                                    style="
            width:80px;
            height:80px;
            background:#976ddf;
            color:#fff;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:bold;
            font-size:30px;
            margin-right:15px;
            flex-shrink:0;
        ">1</span>
                                <span>Buat event pemilihan, atur waktu pelaksanaan, lalu tambahkan kandidat.</span>
                            </li>T

                            <li style="display:flex; align-items:center; margin-bottom:20px;">
                                <span
                                    style="
            width:80px;
            height:80px;
            background:#07b553;
            color:#fff;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:bold;
            font-size:30px;
            margin-right:15px;
            flex-shrink:0;
        ">2</span>
                                <span>Sebarkan token unik kepada pemilih untuk melakukan voting secara online.</span>

                            </li>

                            <li style="display:flex; align-items:center; margin-bottom:20px;">
                                <span
                                    style="
            width:80px;
            height:80px;
            background:#06b1e4;
            color:#fff;
            border-radius:50%;
            display:flex;
            align-items:center;
            justify-content:center;
            font-weight:bold;
            font-size:30px;
            margin-right:15px;
            flex-shrink:0;
        ">3</span>
                                <span>Hasil voting dapat dilihat secara real-time dan transparan.</span>
                            </li>
                        </ul>

                    </div>

                    <!-- Right Steps -->
                    <div class="col-lg-6 col-sm-12">

                        <div class="single-counter text-center mb-30 cr1">
                            <div class="counter p-relative">
                                <span class="count">1</span>
                            </div>
                            <p>Buat Event</p>
                        </div>

                        <div class="single-counter text-center mb-30 cr2">
                            <div class="counter p-relative">
                                <span class="count">2</span>
                            </div>
                            <p>Sebar Token</p>
                        </div>

                        <div class="single-counter text-center mb-30 cr3">
                            <div class="counter p-relative">
                                <span class="count">3</span>
                            </div>
                            <p>Lihat Hasil</p>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <!-- how-it-works-area-end -->

        <!-- pricing-area -->
        <section id="pricing" class="pricing-area pt-113 pb-90 fix"
            style="background-image:url(img/pricing_bg.jpg);background-size: cover;">
            <div class="section-t team-t paroller" data-paroller-factor="0.15" data-paroller-factor-lg="0.15"
                data-paroller-factor-md="0.15" data-paroller-factor-sm="0.15" data-paroller-type="foreground"
                data-paroller-direction="horizontal">
                <h2>Paket</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-xl-6 col-lg-8">
                    <div class="section-title text-center mb-80">
                        <span class="wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".2s">Paket
                            Berlangganan</span>
                        <h2 class="wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".4s">Pilih Paket
                            Sesuai Kebutuhan</h2>
                    </div>
                </div>
            </div>
            <div class="container">

                <div class="row">
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-box text-center mb-30 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <div class="pricing-head">
                                <h4>BASIC</h4>
                                <div class="price-count mb-30">
                                    <h2><small>Rp</small>20k</h2>
                                </div>
                            </div>
                            <div class="pricing-body mb-40">
                                <p>Time to sit down and think about what kind of content should be created, time to stop.
                                </p>
                                <strong>All prices exclude 25% VAT</strong>
                                <div class="bar">
                                    <span style="width:50%;"></span>
                                </div>
                                <div class="bar-no">350/500</div>
                                <div class="pricing-btn mt-40">
                                    <a href="#" class="btn"><i class="far fa-ticket-alt"></i> Pilih Paket </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-box active text-center mb-30 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <div class="tag">Exclusive author</div>
                            <div class="pricing-head">
                                <h4>Gold</h4>
                                <div class="price-count mb-30">
                                    <h2><small>RP</small>50k</h2>
                                </div>
                            </div>
                            <div class="pricing-body mb-40">
                                <p>Time to sit down and think about what kind of content should be created, time to stop.
                                </p>
                                <strong>All prices exclude 25% VAT</strong>
                                <div class="bar">
                                    <span style="width:50%;"></span>
                                </div>
                                <div class="bar-no">350/500</div>
                                <div class="pricing-btn mt-40">
                                    <a href="#" class="btn"><i class="far fa-ticket-alt"></i> Pilih Paket </a>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="pricing-box text-center mb-30 wow fadeInDown animated"
                            data-animation="fadeInDown animated" data-delay=".2s">
                            <div class="pricing-head">
                                <h4>Platinum</h4>
                                <div class="price-count mb-30">
                                    <h2><small>Rp</small>100k</h2>
                                </div>
                            </div>
                            <div class="pricing-body">
                                <p>Time to sit down and think about what kind of content should be created, time to stop.
                                </p>
                                <strong>All prices exclude 25% VAT</strong>
                                <div class="bar">
                                    <span style="width:50%;"></span>
                                </div>
                                <div class="bar-no">350/500</div>
                                <div class="pricing-btn mt-40">
                                    <a href="#" class="btn"><i class="far fa-ticket-alt"></i> Pilih Paket </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- pricing-area-end -->

    </main>
@endsection
