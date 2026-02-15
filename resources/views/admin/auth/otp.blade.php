<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verifikasi OTP - Admin</title>
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
            opacity: .9;
            width: 400px;
        }

        .otp-input {
            font-size: 24px;
            letter-spacing: 10px;
            text-align: center;
            font-weight: bold;
        }

        .btn-resend {
            cursor: pointer;
        }

        .btn-resend.disabled {
            pointer-events: none;
            opacity: 0.5;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="{{ route('root') }}" class="h1">
                    <img src="{{ asset('/homepage/images/logo-ponpes.png') }}" alt="" width="100">
                </a>
            </div>
            <div class="card-body">
                <h5 class="text-center mb-1"><i class="fas fa-shield-alt text-primary"></i> Verifikasi OTP</h5>
                <p class="text-center text-muted mb-3" style="font-size: 13px;">
                    Kode OTP telah dikirim ke WhatsApp<br>
                    <strong>{{ $hpMasked }}</strong>
                </p>

                {{-- Alert --}}
                @if (session('message'))
                    <div class="alert alert-{{ session('title') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show py-2"
                        role="alert">
                        <small>{{ session('message') }}</small>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger py-2">
                        <small>{{ $errors->first() }}</small>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.otp.verify') }}">
                    @csrf
                    <div class="form-group">
                        <input type="text" name="otp" class="form-control otp-input"
                            placeholder="______" maxlength="6" autofocus autocomplete="off"
                            inputmode="numeric" pattern="[0-9]*">
                    </div>
                    <button type="submit" class="btn btn-primary btn-block mb-3">
                        <i class="fas fa-check-circle"></i> Verifikasi
                    </button>
                </form>

                <div class="d-flex justify-content-between align-items-center">
                    {{-- Resend OTP --}}
                    <a href="{{ route('admin.otp.resend') }}" id="btnResend" class="btn-resend text-sm disabled">
                        <i class="fas fa-redo"></i> <span id="resendText">Kirim Ulang (<span id="countdown">60</span>s)</span>
                    </a>

                    {{-- Logout --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('/lte4/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('/lte4/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('/lte4/dist/js/adminlte.min.js?v=3.2.0') }}"></script>

    <script>
        $(function () {
            var seconds = 60;
            var $btn = $('#btnResend');
            var $countdown = $('#countdown');
            var $resendText = $('#resendText');

            var timer = setInterval(function () {
                seconds--;
                $countdown.text(seconds);

                if (seconds <= 0) {
                    clearInterval(timer);
                    $btn.removeClass('disabled');
                    $resendText.html('Kirim Ulang OTP');
                }
            }, 1000);

            // Auto-submit when 6 digits entered
            $('input[name="otp"]').on('input', function () {
                // Only allow numbers
                this.value = this.value.replace(/[^0-9]/g, '');
                if (this.value.length === 6) {
                    $(this).closest('form').submit();
                }
            });
        });
    </script>
</body>

</html>
