@extends('layouts.home.template')
@section('title', 'OTP PMB UII Dalwa')
@push('css')
@endpush
@section('content')
    <section class="login animate__animated animate__bounceInDown">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row border rounded-5 p-3 bg-white shadow box-area">
                <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box">
                    <div class="featured-image">
                        <img src="{{ asset('/homepage/img/otp.png') }}" class="img-fluid" style="width: 100%" />
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
                            <h2>Masukkan Kode OTP</h2>
                            <p>Silahkan masukkan kode otp yang dikirim di whatsapp</p>
                        </div>
                        <form method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input id="nomor_hp" type="text"
                                    class="form-control form-control-lg bg-light fs-6 @error('nomor_hp') is-invalid @enderror"
                                    placeholder="Masukkan Nomor HP" name="nomor_hp" value="{{ $siswa->nomor_hp }}" required
                                    autocomplete="nomor_hp" readonly />
                                @error('nomor_hp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{!! $message !!}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="input-group mb-1">
                                <input id="otp" type="text"
                                    class="form-control form-control-lg bg-light fs-6 @error('otp') is-invalid @enderror"
                                    name="otp" required autocomplete="current-otp" autofocus value="{{ old('otp') }}"
                                    placeholder="Masukkan Kode OTP" />
                                @error('otp')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{!! $message !!}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="row mb-3">
                                <small>Belum menerima kode OTP ? <span id="countdown"></span></small>
                            </div>
                            <div class="input-group mb-3">
                                <button type="submit" class="btn btn-lg btn-primary w-100 fs-6">Proses</button>
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
        const targetDate = new Date("{{ $targetDate }}").getTime();
        const resendElement = `<a href="{{ route('otp.resend', ['siswa' => $siswa]) }}"
                                    class="text-decoration-none">Kirim lagi</a>`;
        $(document).ready(function() {
            if (isNaN(targetDate)) {
                document.getElementById('countdown').innerHTML = resendElement;
            } else {
                const countdownInterval = setInterval(function() {
                    const currentDate = new Date().getTime();
                    const remainingTime = targetDate - currentDate;

                    const seconds = Math.floor((targetDate - currentDate) / 1000);

                    document.getElementById('countdown').innerHTML = `${seconds} detik`;

                    // Check if the countdown is over
                    if (remainingTime <= 0) {
                        clearInterval(countdownInterval);
                        document.getElementById('countdown').innerHTML = resendElement;
                    }
                }, 1000); // Update every second
            }
        });
    </script>
@endpush
