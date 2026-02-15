@extends('layouts.admin.template')
@section('title', 'Admin | Dashboard')
@push('css')
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('/lte4/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Daterange picker bootstrap -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.css"
        rel="stylesheet" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- fullCalendar -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/fullcalendar/main.css') }}">
    <style>
        .todo-list li {
            animation: fadeIn 1s;
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        #content_filter {
            position: relative;
        }

        #content_filter .overly {
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            z-index: 99;
            background-color: rgba(255, 255, 255, .7);
        }
    </style>
@endpush
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ Session::get('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if (Session::has('failed'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ Session::get('failed') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="container-fluid">
                <div class="row">
                    <section class="col-lg-7 connectedSortable">
                        @include('admin.dashboard.info')
                    </section>

                    <section class="col-lg-5 connectedSortable">
                        @include('admin.dashboard.daftar-tugas')
                    </section>
                </div>

                <div class="row">
                    <div class="col-12">
                        @include('admin.dashboard.filter')
                    </div>
                </div>

                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        @include('admin.dashboard.daurah')
                    </section>
                </div>

                <div class="row">
                    <section class="col-lg-12 connectedSortable">
                        @include('admin.dashboard.kalender')
                    </section>
                </div>

            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@push('script')
    <script>
        //swaltoast
        function swalToast(message, data) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            if (message == 200) {
                Toast.fire({
                    icon: 'success',
                    title: data
                });
            } else {
                Toast.fire({
                    icon: 'danger',
                    title: data
                });
            }
        }
    </script>
@endpush
