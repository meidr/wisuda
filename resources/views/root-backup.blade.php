@extends('layouts.home.template')
@section('title', 'Pendaftaran Daurah Ramadhan')
@section('content')

    <!-- Banner section -->
    <section id="home" class="banner_wrapper">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 my-5 my-md-0 text-center text-md-start">
                    <p class="banner-subtitle animate__animated animate__fadeInLeft">
                        Pendaftaran
                    </p>
                    <h1 class="banner-title animate__animated animate__fadeInLeft">
                        Wisuda UII Dalwa
                    </h1>
                    {{-- <h3 class="banner-title-2 animate__animated animate__fadeInLeft">Pondok Pesantren Darullughah Wadda'wah
                    </h3> --}}
                    <h3 class="banner-title-2 animate__animated animate__fadeInLeft">Dibuka
                        {{ date('d F Y', strtotime($jadwal->mulai)) }} - {{ date('d F Y', strtotime($jadwal->berakhir)) }}
                    </h3>
                    <p class="banner-title-text animate__animated animate__fadeInLeft">

                        Melalui program ini, para pelajar memiliki kesempatan lebih untuk mengembangkan funngis dan tujuan
                        dasar pembelajaran Bahasa Arab. Tak hanya sekedar pemenuhan praktis untuk berkomunikasi, mata
                        pelajaran akademik, namun juga fungsi dakwah dan pelestarian sunnah Nabawiyyah.
                    </p>
                    <div class="learn-more-btn-section animate__animated animate__fadeInLeft">
                        @if (Auth::check())
                            <a class="nav-link learn-more-btn me-3" href="{{ route('home') }}">Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="nav-link learn-more-btn me-3">Logout
                                </button>
                            </form>
                        @else
                            @if ($dibuka)
                                <a class="nav-link learn-more-btn me-3" href="{{ route('register') }}">Daftar Sekarang
                                </a>
                            @endif
                            <a class="nav-link learn-more-btn" href="{{ route('login') }}">Login
                            </a>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- Banner section exit -->
@endsection
