@extends('landing.layouts.app')

@section('style')
<style>
    /* base */
    .vote-card {
        border: 2px solid transparent;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    /* hover biar hidup */
    .vote-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    /* radio checked → card aktif */
    .vote-card input[type="radio"]:checked + .team-thumb,
    .vote-card input[type="radio"]:checked ~ .team-info {
        /* trigger visual */
    }

    .vote-card input[type="radio"]:checked ~ .team-info,
    .vote-card input[type="radio"]:checked ~ .team-thumb {
        filter: none;
    }

    /* card aktif */
    .vote-card input[type="radio"]:checked ~ * {
        /* kosong biar selector jalan */
    }

    .vote-card input[type="radio"]:checked {
        display: none;
    }

    .vote-card input[type="radio"]:checked ~ .team-thumb img {
        transform: scale(1.05);
    }

    /* border & glow */
    .vote-card input[type="radio"]:checked ~ .team-info,
    .vote-card input[type="radio"]:checked ~ .team-thumb {
        border-color: transparent;
    }

    .vote-card input[type="radio"]:checked ~ .team-info,
    .vote-card input[type="radio"]:checked ~ .team-thumb {
        filter: drop-shadow(0 0 10px rgba(255, 85, 0, 0.4));
    }

    /* cara paling stabil */
    .vote-card:has(input[type="radio"]:checked) {
        border: 2px solid #ff5500;
        box-shadow: 0 0 0 4px rgba(255, 85, 0, 0.15);
        transform: scale(1.03);
    }
</style>

@endsection

@section('content')
    <main>
        <!-- slider-area -->
        <section id="parallax"
            class="slider-area slider-bg second-slider-bg slider-bg3 d-flex align-items-center justify-content-center fix"
            style="background-image:url({{ asset('landing/img/slider_3_bg_img.jpg') }}">
            <div class="slider-shape ss-one layer" data-depth="0.10"><img src="{{ asset('landing/img/doddle_6.png') }}"
                    alt="shape"></div>
            <div class="slider-shape ss-three layer" data-depth="0.40"><img src="{{ asset('landing/img/doddle_9.png') }}"
                    alt="shape"></div>
            <div class="slider-shape ss-four layer" data-depth="0.60"><img src="{{ asset('landing/img/doddle_7.png') }}"
                    alt="shape"></div>
            <div class="slider-active">
                <div class="single-slider">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8 col-sm-12">
                                <div class="slider-content second-slider-content">
                                    <h2 data-animation="fadeInUp animated" data-delay=".3s">
                                        Pemilihan Ketua Hima 2024
                                    </h2>

                                    <p class="mt-15 mb-30">
                                        Gunakan hak pilih Anda secara aman dan transparan melalui sistem e-voting.
                                    </p>

                                    <!-- STATUS WAKTU -->
                                    <div class="conterdown wow fadeInDown animated" data-date="Dec 31 2025 23:59:59">

                                        <div class="timer">
                                            <div class="timer-outer bdr1">
                                                <span class="days" data-days>0</span>
                                                <div class="smalltext">Hari Tersisa</div>
                                            </div>
                                            <div class="timer-outer bdr2">
                                                <span class="hours" data-hours>0</span>
                                                <div class="smalltext">Jam</div>
                                            </div>
                                            <div class="timer-outer bdr3">
                                                <span class="minutes" data-minutes>0</span>
                                                <div class="smalltext">Menit</div>
                                            </div>
                                            <div class="timer-outer bdr4">
                                                <span class="seconds" data-seconds>0</span>
                                                <div class="smalltext">Detik</div>
                                            </div>
                                        </div>

                                        {{-- <p class="mt-10 text-white">
            Voting sedang berlangsung
        </p> --}}
                                    </div>
                                </div>

                            </div>
                            <div class="col-lg-4 col-sm-12">
                                <div class="booking-form mt-50 wow fadeInLeft">
                                    <h2 class="text-center mb-20">Hasil Voting</h2>

                                    <div class="card text-center p-30">
                                        <h4 class="mb-10">Coming Soon</h4>
                                        <p class="mb-20">
                                            Hasil akan ditampilkan setelah voting ditutup.
                                        </p>

                                        <a href="#" class="btn btn-border disabled">
                                            Detail Hasil
                                        </a>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

        <!-- team-area -->
        <section id="team" class="team-area p-relative pt-120 pb-120 fix">
            <div class="section-t team-t paroller" data-paroller-factor="0.15" data-paroller-factor-lg="0.15"
                data-paroller-factor-md="0.15" data-paroller-factor-sm="0.15" data-paroller-type="foreground"
                data-paroller-direction="horizontal">
                <h2>Vote</h2>
            </div>
            <div class="circal1 item-zoom-inout"></div>
            <div class="circal2 item-zoom-inout"></div>
            <div class="circal3 item-zoom-inout"></div>
            <div class="circal4 item-zoom-inout"></div>
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-6 col-lg-8">
                        <div class="section-title text-center mb-80">
                            <span class="wow fadeInUp animated" data-animation="fadeInUp animated"
                                data-delay=".2s">Pemilihan</span>
                            <h2 class="wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".4s">
                                Pilih Kandidat Anda
                            </h2>
                            <p class="wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".6s">
                                Klik salah satu kandidat, masukkan token, lalu kirim suara.
                            </p>
                        </div>
                    </div>
                </div>
                <!-- FORM -->
                <!-- FORM -->
                <form action="#" method="POST">
                    @csrf

                    <div class="row justify-content-center">

                        <!-- KANDIDAT 1 -->
                        <div class="col-lg-3 col-md-6 wow fadeInDown animated" data-animation="fadeInUp animated"
                            data-delay=".2s">

                            <label class="single-team vote-card text-center pt-50 pb-50 mb-30">


                                <input type="radio" name="candidate_id" value="1" hidden>

                                <div class="team-thumb">
                                    <img src="{{ asset('landing/img/speaker_1.png') }}" alt="Kandidat 1">
                                </div>

                                <div class="team-info">
                                    <h5>Ahmad Fauzi</h5>
                                    <p>Nomor Urut 1</p>
                                    <strong>Transparansi & Inovasi</strong>
                                </div>

                            </label>
                        </div>

                        <!-- KANDIDAT 2 -->
                        <div class="col-lg-3 col-md-6 wow fadeInDown animated" data-animation="fadeInUp animated"
                            data-delay=".3s">

                            <label class="single-team vote-card text-center pt-50 pb-50 mb-30">


                                <input type="radio" name="candidate_id" value="2" hidden>

                                <div class="team-thumb">
                                    <img src="{{ asset('landing/img/speaker_2.png') }}" alt="Kandidat 2">
                                </div>

                                <div class="team-info">
                                    <h5>Siti Rahma</h5>
                                    <p>Nomor Urut 2</p>
                                    <strong>Kolaborasi & Aksi Nyata</strong>
                                </div>

                            </label>
                        </div>

                        <!-- KANDIDAT 3 -->
                        <div class="col-lg-3 col-md-6 wow fadeInDown animated" data-animation="fadeInUp animated"
                            data-delay=".4s">

                            <label class="single-team vote-card text-center pt-50 pb-50 mb-30">


                                <input type="radio" name="candidate_id" value="3" hidden>

                                <div class="team-thumb">
                                    <img src="{{ asset('landing/img/speaker_3.png') }}" alt="Kandidat 3">
                                </div>

                                <div class="team-info">
                                    <h5>Budi Santoso</h5>
                                    <p>Nomor Urut 3</p>
                                    <strong>Integritas & Konsistensi</strong>
                                </div>

                            </label>
                        </div>

                    </div>

                    <!-- TOKEN -->
                    <div class="row justify-content-center mt-40">
                        <div class="col-lg-6 wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".5s">

                            <div class="form-group mb-20">
                                <label>Token Voting</label>
                                <input type="text" name="token" class="form-control"
                                    placeholder="Masukkan token voting" required>
                            </div>

                            <button type="submit" class="btn w-100">
                                Kirim Suara
                            </button>

                        </div>
                    </div>

                </form>
            </div>
        </section>
        <!-- team-area-end -->

    </main>
@endsection
