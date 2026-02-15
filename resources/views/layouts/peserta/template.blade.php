<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')
    <title>@yield('title')</title>

    <link rel="icon" href="#">
    <link rel="icon" type="image/x-icon" href="{{ asset('/homepage/images/logo-ponpes-icon.ico') }}" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    {{-- adminlte --}}
    <link rel="stylesheet" href="{{ asset('/lte4/dist/css/adminlte.min.css?v=3.2.0') }}">
    {{-- stepper --}}
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/bs-stepper/css/bs-stepper.min.css') }}">
    {{-- Select2 --}}
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    {{-- Datetime picker --}}
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Mycss -->
    <link rel="stylesheet" href="{{ asset('/lte4/dist/css/mycss.css') }}">
    @yield('css')
    @stack('css')

    <style>
        .active-custom {
            color: #fff !important;
            background-color: none !important;
        }

        .toast-content {
            display: flex !important;
            align-items: center !important;
        }
    </style>
    {{-- css timeline content header --}}
    <style>
        .bs4-order-tracking {
            overflow: hidden;
            color: #878788;
            padding-left: 0px;
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }

        .bs4-order-tracking li {
            list-style-type: none;
            font-size: 13px;
            width: 16%;
            float: left;
            position: relative;
            font-weight: 400;
            color: #878788;
            text-align: center
        }

        .bs4-order-tracking li a {
            color: #878788;
        }

        .bs4-order-tracking li:first-child:before {
            margin-left: 15px !important;
            padding-left: 11px !important;
            text-align: left !important
        }

        .bs4-order-tracking li:last-child:before {
            margin-right: 5px !important;
            padding-right: 11px !important;
            text-align: right !important
        }

        .bs4-order-tracking li>div {
            color: #fff;
            width: 29px;
            text-align: center;
            line-height: 29px;
            display: block;
            font-size: 12px;
            background: #878788;
            border-radius: 50%;
            margin: auto
        }

        .bs4-order-tracking li:after {
            content: '';
            width: 150%;
            height: 2px;
            background: #878788;
            position: absolute;
            left: 0%;
            right: 0%;
            top: 15px;
            z-index: -1
        }

        .bs4-order-tracking li:first-child:after {
            left: 50%
        }

        .bs4-order-tracking li:last-child:after {
            left: 0% !important;
            width: 0% !important
        }

        .bs4-order-tracking li.actives {
            font-weight: bold;
            color: #00b61e
        }

        .bs4-order-tracking li.actives>div {
            background: #00b61e
        }

        .bs4-order-tracking li.actives>a {
            color: #00b61e;
        }

        .bs4-order-tracking li.actives:after {
            background: #00b61e
        }

        .card-timeline {
            background-color: #fff;
            z-index: 0
        }
    </style>
</head>

<body class="hold-transition layout-top-nav layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('/homepage/images/logo-ponpes.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div>

        @include('layouts.peserta.navbar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
            <!-- /.content-wrapper -->
        </div>

        @include('layouts.peserta.footer')

        {{-- @include('layouts.master.control-sidebar') --}}
    </div>
    <!-- ./wrapper -->
    <script src="{{ asset('/lte4/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/lte4/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/lte4/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
    {{-- Stepper --}}
    <script src="{{ asset('/lte4/plugins/bs-stepper/js/bs-stepper.min.js') }}"></script>
    {{-- Daterangepicker --}}
    <script src="{{ asset('/lte4/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/lte4/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('/lte4/plugins/daterangepicker/daterangepicker.js') }}"></script>
    {{-- Select2 --}}
    <script src="{{ asset('/lte4/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('/lte4/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    {{-- Custom file input --}}
    <script src="{{ asset('/lte4/plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
    {{-- Validate --}}
    <script src="{{ asset('/lte4/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/lte4/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- myscript -->
    <script src="{{ asset('/lte4/dist/js/myscript.js') }}"></script>
    <script>
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });

        $(function() {
            bsCustomFileInput.init();
        });


        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '{{ session('warning') }}',
            });
        </script>
    @endif


    @yield('script')
    @stack('script')
</body>

</html>
