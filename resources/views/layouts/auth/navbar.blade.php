<!-- Navbar section -->
<header class="header_wrapper">
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img decoding="async" src="{{ asset('/homepage/img/logo_uiidalwa.png') }}" class="img-fluid"
                    alt="logo" />
            </a>
            <button class="navbar-toggler pe-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                <i class="fas fa-stream navbar-toggler-icon"></i>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                @php
                    $route = request()->routeIs('root') ? '' : route('root') . '/';
                @endphp
                <ul class="navbar-nav menu-navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('root') ? 'active' : '' }}" aria-current="page"
                            href="{{ $route }}#home">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $route }}#informasi">Informasi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $route }}#brosur">Brosur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $route }}#pricing">Biaya</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $route }}#prodi">Prodi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ $route }}#faqs">FAQs</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    @if (Auth::guard('siswa')->check() || Auth::check())
                        <li class="nav-item text-center">
                            <a class="nav-link learn-more-btn btn-extra-header" href="{{ route('home') }}">Dashboard</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link learn-more-btn" href="{{ route('logout') }}" onclick="logout(event)">Logout</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item text-center">
                            <a class="nav-link learn-more-btn btn-extra-header" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item text-center">
                            <a class="nav-link learn-more-btn" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- Navbar section exit -->
