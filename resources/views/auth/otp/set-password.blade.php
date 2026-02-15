@extends('layouts.home.template')
@section('title', 'Password PMB UII Dalwa')
@push('css')
@endpush
@section('content')
    <section class="login animate__animated animate__bounceInDown">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row border rounded-5 p-3 bg-white shadow box-area">
                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                    <div class="featured-image mb-3">
                        <img src="{{ asset('/homepage/img/setpassword.jpg') }}" class="img-fluid" style="width: 100%" />
                    </div>
                </div>
                <div class="col-md-6 right-box">
                    <div class="row align-items-center">
                        @if (Session::has('message'))
                            <div class="alert alert-{{ Session::get('title') }} alert-dismissible fade show" role="alert">
                                {!! Session::get('message') !!}
                                <button type="button" class="btn-sm btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {!! implode('', $errors->all('<div>:message</div>')) !!}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="header-text mb-2">
                            <h2>Set Password </h2>
                            <p>Silahkan masukkan password dan konfirmasi password</p>
                        </div>
                        <form method="POST" id="form">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="username" id="username" value="{{ $siswa->nik }}">
                            <div class="form-group mb-1">
                                <div class="input-group">
                                    <input id="password" type="password"
                                        class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password" autofocus
                                        value="{{ old('password') }}" placeholder="Masukkan password" tabindex="1" />
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{!! $message !!}</strong>
                                        </span>
                                    @enderror
                                    <button type="button" class="btn btn-secondary"
                                        onclick="showHidePassword(event, '#password')">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <div class="input-group">
                                    <input id="konfirmasi_password" type="password"
                                        class="form-control form-control-lg bg-light fs-6 @error('konfirmasi_password') is-invalid @enderror"
                                        name="konfirmasi_password" required autocomplete="current-konfirmasi_password"
                                        value="{{ old('konfirmasi_password') }}" placeholder="Ketik ulang password"
                                        tabindex="2" />
                                    @error('konfirmasi_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{!! $message !!}</strong>
                                        </span>
                                    @enderror
                                    <button type="button" class="btn btn-secondary"
                                        onclick="showHidePassword(event, '#konfirmasi_password')">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <button type="submit" tabindex="3"
                                    class="btn btn-lg btn-primary w-100 fs-6">Proses</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $('#form').validate({
            rules: {
                password: {
                    required: true,
                },
                konfirmasi_password: {
                    required: true,
                    equalTo: '#password'
                }
            },
            messages: {
                password: {
                    required: 'password tidak boleh kosong'
                },
                konfirmasi_password: {
                    required: 'Konfirmasi tidak boleh kosong',
                    equalTo: 'Password tidak sama'
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function(element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
    </script>
@endpush
