<nav class="main-header navbar navbar-expand-md navbar-dark navbar-custom">
    <div class="container">
        <a href="{{ route('root') }}" class="navbar-brand">
            {{-- <img src="" alt="Logo prodi" class="brand-image"> --}}
            <span class="brand-text font-weight-light">WISUDA</span>
        </a>
        {{-- <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button> --}}
        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            {{-- <ul class="navbar-nav">
                <li class="nav-item">
                    <a href="{{ route('peserta.dashboard') }}"
                        class="nav-link {{ request()->routeIs('peserta.dashboard') ? ' active-custom' : '' }}">Dashboard</a>
                </li>
            </ul> --}}
        </div>

        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Navbar date-->
            <li class="nav-item">
                <a class="nav-link  fw-bold d-none d-md-inline-block" href="#" role="button">
                    {{ date('d M Y') }}
                </a>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{ asset('/lte4/dist/img/user.png') }}" class="user-image img-circle elevation-1"
                        alt="User Image">
                    <span
                        class="d-none d-md-inline text-bold">{{ \Str::limit(strtoupper(Auth::user()->nama), 15, '...') }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

                    <li class="user-header text-white bg-dalwa" style="height: 150px;">
                        <img src="{{ asset('/lte4/dist/img/user.png') }}" class="img-circle elevation-2"
                            alt="User Image">
                        <p>
                            {{ Auth::user()->peserta->nama }}
                        </p>
                    </li>

                    <li class="user-footer">
                        <a href="{{ route('logout') }}" class="btn btn-default btn-flat float-right w-100"
                            onclick="logout(event)">
                            Logout</p>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
