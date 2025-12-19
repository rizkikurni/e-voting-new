@extends('landing.layouts.app')

@section('content')
    <main>
        <!-- slider-area -->
        <section id="parallax"
            class="slider-area slider-bg second-slider-bg slider-bg3 d-flex align-items-center justify-content-center fix"
            style="background-image:url({{ asset('landing/img/slider_3_bg_img.jpg') }})">
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
                                        {{ $event->title }}
                                    </h2>

                                    <p class="mt-15 mb-30">
                                        Gunakan hak pilih Anda secara aman dan transparan melalui sistem e-voting.
                                    </p>

                                    <h3 id="timer-status" class="mt-3 text-warning"></h3>
                                    <!-- STATUS WAKTU -->
                                    <div class="conterdown wow fadeInDown animated">
                                        <div class="timer" id="vote-timer"
                                            data-start="{{ $event->start_time->toIso8601String() }}"
                                            data-end="{{ $event->end_time->toIso8601String() }}">

                                            <div class="timer-outer bdr1">
                                                <span class="days">0</span>
                                                <div class="smalltext">Hari</div>
                                            </div>
                                            <div class="timer-outer bdr2">
                                                <span class="hours">0</span>
                                                <div class="smalltext">Jam</div>
                                            </div>
                                            <div class="timer-outer bdr3">
                                                <span class="minutes">0</span>
                                                <div class="smalltext">Menit</div>
                                            </div>
                                            <div class="timer-outer bdr4">
                                                <span class="seconds">0</span>
                                                <div class="smalltext">Detik</div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-sm-12">
                                <div class="booking-form mt-50 wow fadeInLeft">
                                    <h2 class="text-center mb-20">Pemenang Voting</h2>

                                    @if ($winner)
                                        <div class="text-center">
                                            <div class="candidate-image">
                                                @if ($winner->photo)
                                                    <img src="{{ asset('storage/' . $winner->photo) }}" alt="Winner"
                                                        style="width:100%; height:100%; object-fit:cover;">
                                                @else
                                                    <div style="width: 100%; height: 100%; background: #dee2e6;"></div>
                                                @endif
                                            </div>

                                            <h4 class="candidate-name">{{ $winner->name }}</h4>
                                            <p class="candidate-tagline">Perolehan suara: {{ $winner->votes()->count() }}
                                            </p>

                                            <a href="{{ route('voting.result', $event->id) }}" class="btn btn-detail">Detail Hasil</a>
                                        </div>
                                    @else
                                        <p class="text-center">Belum ada pemenang, voting masih berlangsung.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


@if (!$isEnded)

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
                            {{-- ALERT SUCCESS --}}
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fadeInUp animated"
                                    data-animation="fadeInUp animated" data-delay=".2s" role="alert">
                                    <strong>Berhasil!</strong> {{ session('success') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            {{-- ALERT ERROR GLOBAL --}}
                            @if ($errors->has('event'))
                                <div class="alert alert-danger alert-dismissible fadeInUp animated"
                                    data-animation="fadeInUp animated" data-delay=".2s" role="alert">
                                    <strong>Gagal!</strong> {{ $errors->first('event') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            {{-- ALERT ERROR TOKEN --}}
                            @if ($errors->has('token'))
                                <div class="alert alert-warning alert-dismissible fadeInUp animated"
                                    data-animation="fadeInUp animated" data-delay=".2s" role="alert">
                                    <strong>Token Bermasalah!</strong> {{ $errors->first('token') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            {{-- ALERT ERROR VALIDASI --}}
                            @if ($errors->has('candidate_id'))
                                <div class="alert alert-danger alert-dismissible fadeInUp animated"
                                    data-animation="fadeInUp animated" data-delay=".2s" role="alert">
                                    <strong>Perhatian!</strong> Silakan pilih kandidat terlebih dahulu.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>


                <form action="{{ route('voting.store', $event->id) }}" method="POST">
                    @csrf
                    <div class="row justify-content-center">

                        @foreach ($candidates as $candidate)
                            <div class="col-lg-3 col-md-6 wow fadeInDown animated" data-animation="fadeInUp animated"
                                data-delay=".2s">
                                <label class="single-team vote-card vote-card-fixed text-center pt-50 pb-50 mb-30">
                                    <input type="radio" name="candidate_id" value="{{ $candidate->id }}" hidden>

                                    <div class="team-thumb candidate-avatar">
                                        @if ($candidate->photo)
                                            <img src="{{ asset('storage/' . $candidate->photo) }}"
                                                alt="{{ $candidate->name }}">
                                        @else
                                            <img src="{{ asset('landing/img/speaker_placeholder.png') }}"
                                                alt="{{ $candidate->name }}">
                                        @endif
                                    </div>

                                    <div class="team-info">
                                        <h5>{{ $candidate->name }}</h5>
                                        <p>Nomor Urut {{ $loop->iteration }}</p>
                                        <strong>{{ $candidate->description }}</strong>
                                    </div>
                                </label>

                            </div>
                        @endforeach
                    </div>

                    <!-- TOKEN -->
                    <div class="row justify-content-center mt-40">
                        <div class="col-lg-6 wow fadeInUp animated" data-animation="fadeInUp animated" data-delay=".5s">

                            @if (!$isRunning)
                                <button class="btn w-100 disabled">
                                    Belum mulai
                                </button>
                            @else
                                <div class="form-group mb-20">
                                    <label>Token Voting</label>
                                    <input type="text" name="token" class="form-control"
                                        placeholder="Masukkan token voting" required>
                                </div>
                                <button type="submit" class="btn w-100">
                                    Kirim Suara
                                </button>
                            @endif
                        </div>
                    </div>
                </form>

            </div>
        </section>
@endif

    </main>
@endsection


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
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        }

        /* radio checked → card aktif */
        .vote-card input[type="radio"]:checked+.team-thumb,
        .vote-card input[type="radio"]:checked~.team-info {
            /* trigger visual */
        }

        .vote-card input[type="radio"]:checked~.team-info,
        .vote-card input[type="radio"]:checked~.team-thumb {
            filter: none;
        }

        /* card aktif */
        .vote-card input[type="radio"]:checked~* {
            /* kosong biar selector jalan */
        }

        .vote-card input[type="radio"]:checked {
            display: none;
        }

        .vote-card input[type="radio"]:checked~.team-thumb img {
            transform: scale(1.05);
        }

        /* border & glow */
        .vote-card input[type="radio"]:checked~.team-info,
        .vote-card input[type="radio"]:checked~.team-thumb {
            border-color: transparent;
        }

        .vote-card input[type="radio"]:checked~.team-info,
        .vote-card input[type="radio"]:checked~.team-thumb {
            filter: drop-shadow(0 0 10px rgba(255, 85, 0, 0.4));
        }

        /* cara paling stabil */
        .vote-card:has(input[type="radio"]:checked) {
            border: 2px solid #ff5500;
            box-shadow: 0 0 0 4px rgba(255, 85, 0, 0.15);
            transform: scale(1.03);
        }

        .voting-card {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .candidate-image {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: #e9ecef;
            margin: 0 auto 20px;
            overflow: hidden;
        }

        .candidate-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .candidate-name {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .candidate-number {
            color: #ec4899;
            font-size: 16px;
            font-weight: 500;
            margin-bottom: 5px;
        }

        .candidate-tagline {
            color: #ec4899;
            font-size: 18px;
            font-weight: 600;
        }

        /* Paksa ukuran card sama semua */
        .vote-card-fixed {
            height: 420px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            cursor: pointer;
        }

        /* Area foto kandidat */
        .candidate-avatar {
            width: 140px;
            height: 140px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            background: #f1f1f1;
        }

        /* Gambar di dalam avatar */
        .candidate-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* Biar teks tidak bikin card loncat */
        .vote-card-fixed .team-info {
            min-height: 120px;
        }

        /* Efek saat dipilih */
        .vote-card input[type="radio"]:checked+.candidate-avatar,
        .vote-card:has(input[type="radio"]:checked) {
            border: 2px solid #ff4c4c;
        }
    </style>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timerEl = document.getElementById('vote-timer');
            const statusEl = document.getElementById('timer-status');

            const startTime = new Date(timerEl.dataset.start).getTime();
            const endTime = new Date(timerEl.dataset.end).getTime();

            const daysEl = timerEl.querySelector('.days');
            const hoursEl = timerEl.querySelector('.hours');
            const minutesEl = timerEl.querySelector('.minutes');
            const secondsEl = timerEl.querySelector('.seconds');

            function updateTimer() {
                const now = new Date().getTime();
                let targetTime;
                let label;

                // BELUM MULAI
                if (now < startTime) {
                    targetTime = startTime;
                    label = 'Voting akan dimulai dalam :';
                }
                // SEDANG BERLANGSUNG
                else if (now >= startTime && now <= endTime) {
                    targetTime = endTime;
                    label = 'Voting akan berakhir dalam :';
                }
                // SUDAH SELESAI
                else {
                    daysEl.textContent = 0;
                    hoursEl.textContent = 0;
                    minutesEl.textContent = 0;
                    secondsEl.textContent = 0;
                    statusEl.textContent = 'Voting telah selesai!';
                    return;
                }

                const diff = targetTime - now;

                const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                const minutes = Math.floor((diff / (1000 * 60)) % 60);
                const seconds = Math.floor((diff / 1000) % 60);

                daysEl.textContent = days;
                hoursEl.textContent = hours;
                minutesEl.textContent = minutes;
                secondsEl.textContent = seconds;

                statusEl.textContent = label;
            }

            updateTimer();
            setInterval(updateTimer, 1000);
        });
    </script>
@endsection
