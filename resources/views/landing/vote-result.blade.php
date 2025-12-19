@extends('landing.layouts.app')

@section('content')
    <main>

        <!-- breadcrumb-area -->
        <section id="parallax" class="slider-area breadcrumb-area d-flex align-items-center justify-content-center fix"
            style="background-image:url({{ asset('landing/img/innerpage_bg_img.jpg') }})">

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

            <div class="section-t team-t">
                <h2>Result</h2>
            </div>

            <div class="container">

                <!-- TITLE -->
                <div class="row justify-content-center">
                    <div class="col-xl-7 col-lg-9">
                        <div class="section-title text-center mb-80">
                            <h2>
                                {{ $event->title }}
                            </h2>
                            <h5>

                                <span> Total suara masuk: {{ number_format($totalVotes) }} suara</span>
                            </h5>
                        </div>
                    </div>
                </div>

                <!-- RESULT CARDS -->
                <div class="row justify-content-center">

                    @forelse ($results as $candidate)
                        <div class="col-lg-4 col-md-6 mb-30">

                            <div class="single-team text-center pt-50 pb-50">

                                {{-- Tag pemenang --}}
                                @if ($winner && $winner->id === $candidate->id)
                                    <div class="tag">Pemenang</div>
                                @endif

                                <div class="team-thumb">
                                    <img src="{{ $candidate->photo ? asset('storage/' . $candidate->photo) : asset('landing/img/speaker_1.png') }}"
                                        alt="{{ $candidate->name }}">
                                </div>

                                <div class="team-info">
                                    <h3>{{ $candidate->name }}</h5>
                                    <strong>{{ $candidate->description }}</strong>

                                    <div class="mt-20">
                                        <h5>{{ $candidate->votes_count }} Suara</h5>
                                        <span>{{ $candidate->percentage }}%</span>
                                    </div>

                                    <div class="progress mt-15" style="height:8px;">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $candidate->percentage }}%">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p>Belum ada hasil voting.</p>
                        </div>
                    @endforelse

                </div>

            </div>
        </section>
    </main>
@endsection

@section('style')
    <style>
        /* Card konsisten */
        .single-team {
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Area foto */
        .team-thumb {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            border-radius: 50%;
            overflow: hidden;
            background: #f2f2f2;
        }

        /* Foto bulat & rapi */
        .team-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* Info tidak loncat-loncat */
        .team-info {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        /* Biar progress bar selalu di bawah */
        .team-info .progress {
            margin-top: auto;
        }
    </style>
@endsection
