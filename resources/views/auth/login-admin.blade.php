<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login Admin</title>
    <!-- FAVICON -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/homepage/images/logo-ponpes-icon.ico') }}" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lte4/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/lte4/dist/css/adminlte.min.css?v=3.2.0') }}">
    <style>
        .login-page {
            background-image: url("{{ asset('/homepage/img/bg.png') }}");
            background-size: cover;
        }

        .login-box {
            opacity: .8;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('root') }}" class="h1"><img src="{{ asset('/homepage/images/logo-ponpes.png') }}"
                        alt="" width="100"></a>
            </div>
            <div class="card-body">
                <h5 class="text-center">Assalamu'alaikum</h5>
                <p class="login-box-msg">
                    Silahkan masukkan username dan password.</p>
                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                            name="username" value="{{ old('username') }}" required autocomplete="username" autofocus
                            placeholder="Username">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="input-group mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="current-password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('/lte4/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('/lte4/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('/lte4/dist/js/adminlte.min.js?v=3.2.0') }}"></script>
</body>

</html>
