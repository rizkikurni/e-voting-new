<footer class="footer-bg footer-p"
    style="background-image:url({{ asset('landing/img/footer_bg_img.jpg') }}); background-size: cover;">

    <div class="footer-top">
        <div class="container">
            <div class="row justify-content-between">

                <div class="col-xl-12 col-lg-12 col-sm-12 text-center">
                    <div class="footer-widget pt-120 mb-30">

                        <div class="logo mb-35">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('img/logo.png') }}" alt="logo" style="height: 90px">
                            </a>
                        </div>

                        <div class="footer-text mb-20">
                            <p>
                                Platform e-voting online yang membantu organisasi, kampus,
                                dan komunitas menyelenggarakan pemilihan secara digital
                                dengan aman, transparan, dan mudah digunakan.
                            </p>
                        </div>

                        <div class="footer-social">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="copyright-wrap pb-120">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="copyright-text text-center">

                        <div class="footer-link">
                            <ul>
                                <li><a href="#about">Tentang Sistem</a></li>
                                <li><a href="#how-it-works">Cara Kerja</a></li>
                                <li><a href="#pricing">Paket & Harga</a></li>
                                <li><a href="{{ route('login') }}">Login</a></li>
                                <li><a href="{{ route('register') }}">Daftar</a></li>
                            </ul>
                        </div>

                        <p class="mt-15">
                            © {{ date('Y') }} E-Voting System. All rights reserved.
                        </p>

                    </div>
                </div>
            </div>
        </div>
    </div>

</footer>
