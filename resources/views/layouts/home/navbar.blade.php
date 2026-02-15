<!-- ======= Header ======= -->
<header id="header" class="fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center">
        <div class="logo me-auto">
            <h1><a href="index.html">Wisuda UII Dalwa</a></h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
        </div>

        <nav id="navbar" class="navbar order-last order-lg-0">
            <ul>
                <li><a class="nav-link scrollto active" href="#hero">Home</a></li>
                <li><a class="nav-link scrollto" href="#alur">Alur</a></li>
                <li><a class="nav-link scrollto" href="#faq">FAQ</a></li>
                @if (\Auth::check())
                    <li><a class="nav-link scrollto dashboard" href="{{ route('home') }}">DASHBOARD</a></li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <li>

                            <button type="submit" class="nav-link scrollto logout">LOGOUT</button>
                        </li>
                    </form>
                @else
                    <li><a class="nav-link scrollto login" href="{{ route('login') }}">LOGIN</a></li>
                @endif
            </ul>
            <i class="bi bi-list mobile-nav-toggle"></i>
        </nav>
        <!-- .navbar -->
    </div>
</header>
<!-- End Header -->
