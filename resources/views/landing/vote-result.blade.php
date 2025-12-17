@extends('landing.layouts.app')
@section('content')
    <main>

        <!-- breadcrumb-area -->
        <section id="parallax" class="slider-area breadcrumb-area d-flex align-items-center justify-content-center fix"
            style="background-image:url({{ asset('landing/img/innerpage_bg_img.jpg') }})">
            <div class="slider-shape ss-one layer" data-depth="0.10"><img src="{{ asset('landing/img/doddle_6.png') }}" alt="shape"></div>
            <div class="slider-shape ss-three layer" data-depth="0.40"><img src="{{ asset('landing/img/doddle_9.png') }}" alt="shape"></div>
            <div class="slider-shape ss-four layer" data-depth="0.60"><img src="{{ asset('landing/img/doddle_7.png') }}" alt="shape"></div>
            <div class="container">
                <div class="row">
                    <div class="col-xl-6 offset-xl-3 col-lg-8 offset-lg-2">
                        <div class="breadcrumb-wrap text-center">

                            <div class="breadcrumb-title mb-30">
                                <h2>Hasil Voting</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- result-area -->
        <section id="result" class="team-area p-relative pt-120 pb-120 fix">

            <!-- background text -->
            <div class="section-t team-t paroller" data-paroller-factor="0.15" data-paroller-factor-lg="0.15"
                data-paroller-factor-md="0.15" data-paroller-factor-sm="0.15" data-paroller-type="foreground"
                data-paroller-direction="horizontal">
                <h2>Result</h2>
            </div>

            <!-- decorative -->
            <div class="circal1 item-zoom-inout"></div>
            <div class="circal2 item-zoom-inout"></div>
            <div class="circal3 item-zoom-inout"></div>
            <div class="circal4 item-zoom-inout"></div>

            <div class="container">

                <!-- TITLE -->
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-9">
                        <div class="section-title text-center mb-80">
                            <h2 class="wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".4s">
                                Pemilihan Ketua Organisasi 2025
                            </h2>
                            <p class="wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".6s">
                                Total suara masuk: <strong>1.250 suara</strong>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- RESULT CARDS -->
                <div class="row justify-content-center">

                    <!-- Kandidat 1 -->
                    <div class="col-lg-4 col-md-6 wow fadeInDown animated" data-animation="fadeInUp animated"
                        data-delay=".2s">

                        <div class="single-team text-center pt-50 pb-50 mb-30">

                            <div class="tag">Leading</div>

                            <div class="team-thumb">
                                <img src="{{ asset('landing/img/speaker_1.png') }}" alt="Kandidat 1">
                            </div>

                            <div class="team-info">
                                <h5>Ahmad Fauzi</h5>
                                <p>Nomor Urut 1</p>

                                <div class="mt-20">
                                    <h3>520 Suara</h3>
                                    <span>41.6%</span>
                                </div>

                                <div class="progress mt-15" style="height:8px;">
                                    <div class="progress-bar" role="progressbar" style="width:41.6%">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Kandidat 2 -->
                    <div class="col-lg-4 col-md-6 wow fadeInDown animated" data-animation="fadeInUp animated"
                        data-delay=".3s">

                        <div class="single-team text-center pt-50 pb-50 mb-30">

                            <div class="team-thumb">
                                <img src="{{ asset('landing/img/speaker_1.png') }}" alt="Kandidat 2">
                            </div>

                            <div class="team-info">
                                <h5>Siti Rahma</h5>
                                <p>Nomor Urut 2</p>

                                <div class="mt-20">
                                    <h3>430 Suara</h3>
                                    <span>34.4%</span>
                                </div>

                                <div class="progress mt-15" style="height:8px;">
                                    <div class="progress-bar" role="progressbar" style="width:34.4%">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Kandidat 3 -->
                    <div class="col-lg-4 col-md-6 wow fadeInDown animated" data-animation="fadeInUp animated"
                        data-delay=".4s">

                        <div class="single-team text-center pt-50 pb-50 mb-30">

                            <div class="team-thumb">
                                <img src="{{ asset('landing/img/speaker_1.png') }}" alt="Kandidat 3">
                            </div>

                            <div class="team-info">
                                <h5>Budi Santoso</h5>
                                <p>Nomor Urut 3</p>

                                <div class="mt-20">
                                    <h3>300 Suara</h3>
                                    <span>24%</span>
                                </div>

                                <div class="progress mt-15" style="height:8px;">
                                    <div class="progress-bar" role="progressbar" style="width:24%">
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <!-- FOOTNOTE -->
                <div class="row justify-content-center mt-40">
                    <div class="col-lg-8 text-center wow fadeInUp animated" data-animation="fadeInUp animated"
                        data-delay=".5s">
                        <p>
                            Hasil bersifat real-time dan akan dikunci otomatis saat periode voting berakhir.
                        </p>
                    </div>
                </div>

            </div>
        </section>
        <!-- result-area-end -->
    </main>
@endsection
