<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('/img/logo.png') }}" alt="AdminLTE Logo" class="brand-image bg-success img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Aplikasi</span>
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
                <a href="" class="d-block">{{ auth()->user()->email }}</a>
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
                    <a href="{{ route('admin.dashboard') }}" class="nav-link"> <i
                            class="nav-icon fas fa-chart-line bkg-blue"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                {{-- Master Data --}}
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-list bkg-purple"></i>
                        <p>
                            Master Data
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>
                                    Mahasiswa
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Data Mahasiswa</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
                {{-- Profil --}}
                <li class="nav-item">
                    <a href="{{ route('admin.profil') }}" class="nav-link">
                        <i class="nav-icon fas fa-user bkg-blue-2"></i>
                        <p>
                            Profil
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link " onclick="logout(event)">
                        <i class="nav-icon fas fa-sign-out-alt bkg-red"></i>
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
