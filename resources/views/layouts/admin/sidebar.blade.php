@php
    $role = Auth::user()->role->nama;
@endphp

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-success elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('/homepage/images/logo-ponpes.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="width: 35px;height:40px;object-fit:cover">
        <span class="brand-text font-weight-light">{{ config('app.name') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if (auth()->user()->foto != null)
                    <img src="{{ asset('/foto/' . auth()->user()->foto) }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                @else
                    <img src="{{ asset('/img/logo uii dalwa.png') }}" class="img-circle elevation-2"
                        style="width: 40px;height:40px;object-fit:cover" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="" class="d-block">{{ Str::limit(auth()->user()->nama, 11) }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">

            <ul class="nav nav-pills nav-sidebar nav-collapse-hide-child nav-child-indent flex-column"
                data-widget="treeview" role="menu" data-accordion="false" id="list-sidebar">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                {{-- Dashboard --}}
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"> <i
                            class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                @if ($role == 'admin')
                    <li class="nav-header">
                        Data
                    </li>
                    {{-- Pengguna --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.pengguna') }}"
                            class="nav-link {{ request()->routeIs('admin.pengguna') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-user"></i>
                            <p>
                                Pengguna
                            </p>
                        </a>
                    </li>
                @endif

                {{-- Tahun --}}
                @if ($role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.tahun') }}"
                            class="nav-link {{ request()->routeIs('admin.tahun') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-calendar"></i>
                            <p>
                                Tahun
                            </p>
                        </a>
                    </li>
                @endif


                {{-- Daurah --}}
                @if ($role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.prodi') }}"
                            class="nav-link {{ request()->routeIs('admin.prodi') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-bookmark"></i>
                            <p>
                                Prodi
                            </p>
                        </a>
                    </li>
                @endif

                {{-- Kuota --}}
                @if ($role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.kuota') }}"
                            class="nav-link {{ request()->routeIs('admin.kuota') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-calculator"></i>
                            <p>
                                Kuota
                            </p>
                        </a>
                    </li>
                @endif

                {{-- Jadwal --}}
                @if ($role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.jadwal') }}"
                            class="nav-link {{ request()->routeIs('admin.jadwal') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-clock"></i>
                            <p>
                                Jadwal
                            </p>
                        </a>
                    </li>
                @endif

                @if ($role == 'admin')
                    {{-- List Dokumen --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.list-dokumen') }}"
                            class="nav-link {{ request()->routeIs('admin.list-dokumen') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-file"></i>
                            <p>
                                List Dokumen
                            </p>
                        </a>
                    </li>
                @endif

                @if ($role == 'admin')
                    {{-- Berkas Bukti & Revisi --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.berkas-bukti-revisi') }}"
                            class="nav-link {{ request()->routeIs('admin.berkas-bukti-revisi*') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-file-alt"></i>
                            <p>
                                Berkas Bukti & Revisi
                            </p>
                        </a>
                    </li>
                @endif

                @if ($role == 'admin')
                    {{-- Peserta --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.peserta') }}"
                            class="nav-link {{ request()->routeIs('admin.peserta*') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-graduation-cap"></i>
                            <p>
                                Peserta
                            </p>
                        </a>
                    </li>
                @endif

                <li class="nav-header">
                    Keuangan
                </li>

                @if ($role == 'admin' || $role == 'keuangan')
                    {{-- Pembayaran --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.pembayaran') }}"
                            class="nav-link {{ request()->routeIs('admin.pembayaran*') ? 'active' : '' }}"> <i
                                class="nav-icon fas fa-money-bill"></i>
                            <p>
                                Pembayaran
                            </p>
                        </a>
                    </li>
                @endif

                 <li class="nav-header">
                    Wisuda
                </li>

                @if ($role == 'admin')
                    {{-- Acara --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.acara') }}"
                            class="nav-link {{ request()->routeIs('admin.acara*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Acara
                            </p>
                        </a>
                    </li>
                @endif

                @if ($role == 'admin')
                    {{-- Nomor Antrian Atribut --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.antrian_atribut') }}"
                            class="nav-link {{ request()->routeIs('admin.antrian_atribut*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-ticket-alt"></i>
                            <p>
                                Nomor Antrian Atribut
                            </p>
                        </a>
                    </li>
                @endif


                <li class="nav-header">
                    Tools
                </li>

                @if ($role == 'admin')
                    {{-- Setting --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.setting') }}"
                            class="nav-link {{ request()->routeIs('admin.setting*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Setting
                            </p>
                        </a>
                    </li>
                @endif
                @if ($role == 'admin')
                    {{-- QR Code --}}
                    <li class="nav-item">
                        <a href="{{ route('admin.qr_code') }}"
                            class="nav-link {{ request()->routeIs('admin.qr_code*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-qrcode"></i>
                            <p>
                                QR Code
                            </p>
                        </a>
                    </li>
                @endif
                {{-- Profil --}}
                <li class="nav-item">
                    <a href="{{ route('admin.profil') }}"
                        class="nav-link {{ request()->routeIs('admin.profil*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Profil
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link " onclick="logout(event)">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            Logout
                        </p>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
    </div>
    <!-- /.sidebar -->
</aside>
