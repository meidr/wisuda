<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="Description" content="Enter your description here" />
    <title>@yield('title')</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/homepage/images/logo-ponpes-icon.ico') }}" />

    <!-- Bootstrap 5 CDN Links -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <!-- Wow Animation -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Select 2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Fancybox CSS Links-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
    <!-- Link Swiper's CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper@8/swiper-bundle.min.css" />
    <!-- Custom File's Link -->
    <link rel="stylesheet" href="{{ asset('/homepage/css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('/homepage/css/responsive-style.css') }}" />
    @stack('css')
</head>

<body>


    @yield('content')

    <!-- jQuery CDN Link -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 5 JS CDN Links -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.0/js/bootstrap.min.js"></script>
    <!-- Wow Animation js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
    <!-- Select2 -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    {{-- Validate --}}
    <script src="{{ asset('/lte4/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/lte4/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Fancybox JS Links-->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <!-- Custom Js Link -->
    <script src="{{ asset('/homepage/js/main.js') }}"></script>
    <!-- Swiper -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    <script src="https://unpkg.com/swiper@8/swiper-bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('/lte4/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <!-- myscript -->
    <script src="{{ asset('/lte4/dist/js/myscript.js') }}"></script>
    <script>
        new WOW().init();
        $('.select2').select2();
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
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

    @stack('script')
</body>

</html>
