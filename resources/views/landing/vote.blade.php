@extends('landing.layouts.app')

@section('content')
<main>

    <!-- HERO / EVENT INFO -->
    <section id="parallax"
        class="slider-area slider-bg second-slider-bg slider-bg3 d-flex align-items-center justify-content-center fix"
        style="background-image:url({{ asset('landing/img/slider_3_bg_img.jpg') }})">

        <div class="slider-active">
            <div class="single-slider">
                <div class="container">
                    <div class="row align-items-center">

                        <!-- EVENT INFO -->
                        <div class="col-lg-8">
                            <div class="slider-content second-slider-content">
                                <h2>{{ $event->title }}</h2>

                                <p class="mt-15 mb-30">
                                    {{ $event->description }}
                                </p>

                                <div class="conterdown"
                                    data-date="{{ $event->end_time->format('M d Y H:i:s') }}">
                                    <div class="timer">
                                        <div class="timer-outer">
                                            <span class="days" data-days>0</span>
                                            <div class="smalltext">Hari</div>
                                        </div>
                                        <div class="timer-outer">
                                            <span class="hours" data-hours>0</span>
                                            <div class="smalltext">Jam</div>
                                        </div>
                                        <div class="timer-outer">
                                            <span class="minutes" data-minutes>0</span>
                                            <div class="smalltext">Menit</div>
                                        </div>
                                        <div class="timer-outer">
                                            <span class="seconds" data-seconds>0</span>
                                            <div class="smalltext">Detik</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- WINNER -->
                        <div class="col-lg-4">
                            <div class="booking-form mt-50">
                                <h2 class="text-center mb-20">Pemenang</h2>

                                @if ($winner)
                                    <div class="text-center">
                                        <div class="candidate-image">
                                            @if ($winner->photo)
                                                <img src="{{ asset('storage/'.$winner->photo) }}">
                                            @endif
                                        </div>

                                        <h4 class="candidate-name">{{ $winner->name }}</h4>
                                        <p class="candidate-tagline">
                                            Perolehan suara: {{ $winner->votes_count }}
                                        </p>
                                    </div>
                                @else
                                    <p class="text-center text-muted">
                                        Voting belum selesai
                                    </p>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- VOTING -->
    <section id="team" class="team-area pt-120 pb-120">
        <div class="container">

            <div class="section-title text-center mb-80">
                <span>Pemilihan</span>
                <h2>Pilih Kandidat Anda</h2>
                <p>Masukkan token dan kirim suara</p>
            </div>

            @if ($isRunning)
            <form action="{{ route('vote.store', $event->id) }}" method="POST">
                @csrf

                <div class="row justify-content-center">

                    @foreach ($candidates as $candidate)
                        <div class="col-lg-3 col-md-6">
                            <label class="single-team vote-card text-center pt-50 pb-50 mb-30">

                                <input type="radio" name="candidate_id"
                                    value="{{ $candidate->id }}" required hidden>

                                <div class="team-thumb">
                                    @if ($candidate->photo)
                                        <img src="{{ asset('storage/'.$candidate->photo) }}">
                                    @endif
                                </div>

                                <div class="team-info">
                                    <h5>{{ $candidate->name }}</h5>
                                    <p>{{ $candidate->description }}</p>
                                </div>

                            </label>
                        </div>
                    @endforeach

                </div>

                <!-- TOKEN -->
                <div class="row justify-content-center mt-40">
                    <div class="col-lg-6">
                        <div class="form-group mb-20">
                            <label>Token Voting</label>
                            <input type="text" name="token"
                                class="form-control"
                                placeholder="Masukkan token"
                                required>
                        </div>

                        <button type="submit" class="btn w-100">
                            Kirim Suara
                        </button>
                    </div>
                </div>

            </form>
            @else
                <p class="text-center text-danger">
                    Voting belum dimulai atau sudah berakhir
                </p>
            @endif

        </div>
    </section>

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
    </style>
@endsection
