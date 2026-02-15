@extends('layouts.auth.template')
@section('title', 'Login Wisudah')
@push('css')
    <style>
        .select2-container .select2-selection--single {
            padding: 5px;
            height: auto;
        }

        .select2-container .select2-search--dropdown .select2-search__field {
            padding: 10px;
        }
    </style>
@endpush
@section('content')
    <section class="login">
        <div class="container d-flex justify-content-center align-items-center">
            <div class="row border rounded-5 p-3 bg-white shadow box-area">
                <div class="col-md-6 right-box ">
                    <div class="row align-items-center">
                        @if (Session::has('message'))
                            <div class="alert alert-{{ Session::get('title') }} alert-dismissible fade show" role="alert">
                                {{ Session::get('message') }}
                                <button type="button" class="btn-sm btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="header-text mb-2">
                            <h2>Assalamualaikum,</h2>
                            <p>Silahkan login menggunakan username dan password</p>
                        </div>
                        @error('username')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-sm btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @enderror
                        @error('password')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @enderror
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="username" type="text"
                                    class="form-control form-control-lg bg-light fs-6 @error('username') is-invalid @enderror"
                                    placeholder="Masukkan Username" name="username"
                                    value="{{ old('username') }}{{ $dataOtp != null ? $dataOtp->username : '' }}"
                                    autocomplete="username" required />
                            </div>
                            <div class="input-group mb-3">
                                <input id="password" type="password"
                                    class="form-control form-control-lg bg-light fs-6 @error('password') is-invalid @enderror"
                                    name="password"autocomplete="current-password" placeholder="Masukkan Password"
                                    required />
                            </div>
                            <div class="input-group mb-1">
                                <input class="form-check-input me-2" type="checkbox" onclick="showPassword()"
                                    id="flexCheckDefault" />
                                <label class="form-check-label" for="flexCheckDefault">
                                    <small> Show Password</small>
                                </label>
                            </div>
                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Login</button>
                            </div>
                        </form>
                        {{-- <div class="row">
                            <small>Belum punya akun?
                                <a href="{{ route('register') }}" class="text-decoration-none">Daftar
                                    Sekarang</a></small>
                        </div> --}}
                        <div class="row">
                            <small>Kembali ke
                                <a href="{{ route('root') }}">halaman utama</a></small>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                    <div class="featured-image mb-3">
                        <img src="{{ asset('/homepage/images/login.jpg') }}" class="img-fluid" style="width: 250px" />
                    </div>
                    <p class=" fs-2">Selamat Datang</p>
                    <small class=" text-wrap text-center">di Website Pendaftaran Wisuda UII Dalwa. <br>
                        Silahkan login
                        sesuai akun anda.</small>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            @if ($dataOtp != null)
                $('#password').focus();
            @endif
        });

        function showPassword() {
            var x = document.getElementById("password");
            if (x.type === "password") {
                x.type = "text";
            } else {
                x.type = "password";
            }
        }
    </script>
@endpush
