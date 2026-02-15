@extends('layouts.home.template')
@section('content')
    <!-- ======= Hero Section ======= -->
    <section id="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 pt-5 pt-lg-0 order-2 order-lg-1 d-flex flex-column justify-content-center"
                    data-aos="fade-up">
                    <div>
                        <h2 class="bg-success p-2 rounded text-white">Dibuka pada
                            {{ date('d F Y', strtotime($jadwal->mulai)) }} -
                            {{ date('d F Y', strtotime($jadwal->berakhir)) }}</h2>
                        <h1>Website Pendaftaran Wisuda UII Dalwa</h1>
                        <h2>
                            Silahkan melihat alur pendaftaran wisuda UII Dalwa
                        </h2>
                        <a href="#alur" class="btn-get-started scrollto">Lihat Alur</a>
                        @if (\Auth::check())
                            <a href="{{ route('home') }}" class="btn-get-started scrollto bg-dark">Dasboard</a>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn-get-started scrollto bg-danger">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="btn-get-started scrollto bg-success">Login</a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="fade-left">
                    <img src="{{ asset('assets/img/wisuda.png') }}" class="img-fluid" alt="hero" />
                </div>
            </div>
        </div>
    </section>
    <!-- End Hero -->

    <main id="main">
        <!-- ======= Alur Section ======= -->
        <section id="alur" class="services section-bg">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>Alur Pendaftaran Wisuda</h2>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0 mt-3" data-aos="zoom-in">
                        <div class="icon-box icon-box-pink">
                            <div class="icon"><i class='bx bxs-graduation'></i></div>
                            <h4 class="title"><a href="">Lulus Sidang</a></h4>
                            <p class="description">
                            <div>
                                Mahasiswa yang ingin daftar wisuda, harus lulus sidang skripsi / tesis / disertasi
                            </div>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0 mt-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <div class="icon-box icon-box-cyan">
                            <div class="icon"><i class='bx bx-money-withdraw'></i></div>
                            <h4 class="title"><a href="">Pembayaran</a></h4>
                            <p class="description">
                                Melunasi <b>biaya pendidikan</b> dan <b>biaya wisuda</b>. Biaya wisuda dapat dilakukan
                                dengan transfer ke rekening <b>Sarjana Putra (7751999997 An. UII DALWA), Sarjana Putri (8987898788 An. UII DALWA)</b> atau <b>Pascasarjana
                                    (3437444117
                                    An. PASCASARJANA UII DALWA)</b>.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0 mt-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <div class="icon-box icon-box-green">
                            <div class="icon"><i class='bx bxs-check-shield'></i></div>
                            <h4 class="title"><a href="">Konfirmasi Pembayaran</a></h4>
                            <p class="description">
                                Konfirmasi pembayaran dan menerima password untuk login website di nomor <b>0877 5445 2667
                                    (S1 Banin)</b>, <b>0819 1250 0656 (S1 Banat)</b>, atau <b>0822 4558 5616 (Untuk
                                    Pascasarjana)</b>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0 mt-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <div class="icon-box icon-box-pink">
                            <div class="icon"><i class="bx bx-user"></i></div>
                            <h4 class="title"><a href="">Login</a></h4>
                            <p class="description">
                                Untuk mahasiswa yang sudah mendapatkan username dan password, klik login di website untuk
                                masuk
                            <div>
                                @if (\Auth::check())
                                    <a href="{{ route('home') }}" class="btn btn-dark mt-3">Dasboard</a>
                                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-danger mt-3">Logout</button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-success mt-3">Login</a>
                                @endif
                            </div>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0 mt-3" data-aos="zoom-in"
                        data-aos-delay="100">
                        <div class="icon-box icon-box-cyan">
                            <div class="icon"><i class="bx bx-file"></i></div>
                            <h4 class="title"><a href="">Mengisi Formulir</a></h4>
                            <p class="description">
                                Mahasiswa wisuda melengkapi formulir
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0 mt-3" data-aos="zoom-in"
                        data-aos-delay="200">
                        <div class="icon-box icon-box-green">
                            <div class="icon"><i class="bx bxs-edit"></i></div>
                            <h4 class="title"><a href="">Verikasi Data (oleh Panitia)</a></h4>
                            <p class="description">
                                Data mahasiswa wisuda akan diverifikasi oleh panitia.
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0 mt-3" data-aos="zoom-in"
                        data-aos-delay="300">
                        <div class="icon-box icon-box-blue">
                            <div class="icon"><i class="bx bxs-check-circle"></i></div>
                            <h4 class="title"><a href="">Selesai</a></h4>
                            <p class="description">
                                Mahasiswa terdaftar sebagai Peserta Wisuda
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Alur Section -->

        <!-- ======= F.A.Q Section ======= -->
        <section id="faq" class="faq">
            <div class="container">
                <div class="section-title" data-aos="fade-up">
                    <h2>FAQs</h2>
                </div>

                <ul class="faq-list" data-aos="fade-up">
                    <li>
                        <div data-bs-toggle="collapse" class="collapsed question" href="#faq1">
                            Bagaimana cara mendaftar wisuda UII Dalwa
                            <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i>
                        </div>
                        <div id="faq1" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Jika belum mengecek alur pendaftaran di website, silahkan cek alur pendaftaran wisuda di
                                website dengan klik disini <a href="#alur">Alur Pendaftaran</a>
                            </p>
                        </div>
                    </li>

                    <li>
                        <div data-bs-toggle="collapse" href="#faq2" class="collapsed question">
                            Bagaimana jika saya lupa password atau username saya? <i
                                class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i>
                        </div>
                        <div id="faq2" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Jika lupa password atau username silahkan hubungi staff Wisuda UII Dalwa
                            </p>
                        </div>
                    </li>

                    <li>
                        <div data-bs-toggle="collapse" href="#faq3" class="collapsed question">
                            Apakah saya harus melengkapi semua dokumen yang diperlukan? <i
                                class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i>
                        </div>
                        <div id="faq3" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Iya, pendaftar <b>diwajibkan</b> untuk melengkapi semua dokumen yang diperlukan
                            </p>
                        </div>
                    </li>

                    <li>
                        <div data-bs-toggle="collapse" href="#faq4" class="collapsed question">
                            Bagaimana kriteria dari foto yang diperlukan?
                            <i class="bi bi-chevron-down icon-show"></i><i class="bi bi-chevron-up icon-close"></i>
                        </div>
                        <div id="faq4" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                Foto yang diperlukan adalah <b>Berjas dan Background Merah</b>
                            </p>
                            <p>
                                <img class="foto" src="{{ asset('assets/img/Foto Banin.png') }}" alt="Foto Banin">
                                <img class="foto" src="{{ asset('assets/img/Foto Banat.jpg') }}" style="width: 350px !important" alt="Foto Banat">
                            </p>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <!-- End Frequently Asked Questions Section -->
    </main>
    <!-- End #main -->
@endsection
