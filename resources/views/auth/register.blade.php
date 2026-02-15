@extends('layouts.auth.template')
@section('title', 'Daftar Wisuda')
@push('css')
    <style>
        .select2-container .select2-selection--single {
            padding: 5px;
            height: auto;
        }

        .select2-container .select2-search--dropdown .select2-search__field {
            padding: 10px;
        }

        .card {
            /* padding: 5px; */
            border-radius: 10px;
        }

        .card-header {
            background-color: white !important;
            border-radius: 10px;
        }

        .card-header:first-child {
            border-radius: 10px !important;
        }

        form input:not(#username):not([name^="file"]) {
            text-transform: uppercase;
        }

        form textarea {
            text-transform: uppercase;
        }

        form select {
            text-transform: uppercase;
        }

        form label:not(#username) {
            text-transform: uppercase;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush
@section('content')
    <section class="register">
        <div class="container d-flex justify-content-center align-items-center min-vh-100">
            <div class="row box-area-register mb-5">
                <div class="col-md-12 d-flex justify-content-center align-items-center ">
                    <div class="row align-items-center">
                        <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data"
                            id="form-register">
                            @csrf
                            {{-- <img class="w-100" src="{{ asset('homepage/images/kop.png') }}" alt=""> --}}
                            <div class="card mb-2 shadow">
                                <div class="card-body">
                                    <h2 style="color: #173462">FORMULIR PENDAFTARAN WISUDA UII DALWA</h2>
                                    <div class="alert alert-info" role="alert">
                                        <i class="fa fa-info m-2"></i>
                                        Pastikan data yang anda masukkan benar-benar valid.
                                    </div>
                                </div>
                            </div>
                            <div class="card my-2 shadow" id="akun">
                                <div class="card-header">
                                    <span class="fw-bold">Buat Akun Peserta</span> (digunakan untuk login ke website)
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="username" class="mb-1"><small class="text-danger">*</small>Username
                                            (Bebas, tapi tanpa spasi)</label>
                                        <input type="text" class="form-control @error('username') is-invalid @enderror"
                                            name="username" placeholder="Masukkan Username" id="username"
                                            value="{{ old('username') }}" required />
                                        <small>Contoh: fulan123</small>
                                    </div>
                                    @error('username')
                                        @php
                                            $saran = old('username') . '_' . substr(uniqid(), 0, 4);
                                            $saran = str_replace(' ', '', $saran);
                                        @endphp
                                        <div>
                                            <small class="text-danger">{{ $message }}</small>
                                        </div>
                                        <div>
                                            <small class="text-success">Saran username :
                                                {{ $saran }}</small> <button type="button"
                                                class="badge bg-success border-0 cursor-pointer"
                                                onclick="pakai('{{ $saran }}')">Pakai</button>
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="card my-2 shadow" id="biodata">
                                <div class="card-header">
                                    <span class="fw-bold">BIODATA PESERTA</span>
                                </div>
                                <div class="card-body">
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-1"><small class="text-danger">*</small>Nama
                                            Lengkap</label>
                                        <input type="text" class="form-control" name="nama"
                                            placeholder="Masukkan Nama Lengkap" id="nama" value="{{ old('nama') }}"
                                            required />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-1"><small class="text-danger">*</small>NIM</label>
                                        <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM"
                                            id="nim" value="{{ old('nim') }}" required />
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="prodi_id" class="mb-1 w-100"><span
                                                class="text-danger">*</span>Prodi</label>
                                        <select class="form-control select2bs4" name="prodi_id" id="prodi_id" required>
                                            <option value="">Pilih</option>
                                            @foreach ($prodi as $item)
                                                <option value="{{ $item->id }}"
                                                    @if (old('prodi_id') == $item->id) selected @endif>
                                                    {{ $item->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-1"><small
                                                        class="text-danger">*</small>Tempat Lahir</label>
                                                <input type="text" class="form-control" name="tempat_lahir"
                                                    placeholder="Masukkan Tempat Lahir" id="tempat_lahir"
                                                    value="{{ old('tempat_lahir') }}" required />
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="" class="mb-1"><small
                                                        class="text-danger">*</small>Tanggal Lahir</label>
                                                <input type="date" class="form-control" name="tanggal_lahir"
                                                    placeholder="Masukkan Tanggal Lahir" id="tanggal_lahir"
                                                    value="{{ old('tanggal_lahir') }}" required />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="jenis_kelamin" class="mb-1"><span class="text-danger">*</span>Jenis
                                            Kelamin</label>
                                        <select class="form-control select2bs4" name="jenis_kelamin" id="jenis_kelamin"
                                            required>
                                            <option value="">Pilih</option>
                                            @foreach (BulkData::jenisKelamin as $jk)
                                                <option value="{{ $jk }}"
                                                    @if (old('jenis_kelamin') == $jk) selected @endif>
                                                    {{ $jk }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-1"><small class="text-danger">*</small>Nomor
                                            Telepon/WhapsApp</label>
                                        <input type="number" class="form-control"
                                            placeholder="Masukkan Nomor Telepon/WhatsApp" name="nomor_hp"
                                            id="nomor_telepon" value="{{ old('nomor_hp') }}" required />
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="tipe_identitas" class="mb-1"><span
                                                        class="text-danger">*</span>Tipe
                                                    Identitas</label>
                                                <select class="form-control select2bs4" name="tipe_identitas"
                                                    id="tipe_identitas" required>
                                                    <option value="">Pilih</option>
                                                    @foreach ($tipeIdentitas as $key => $value)
                                                        <option value="{{ $value }}"
                                                            @if (old('tipe_identitas') == $value) selected @endif>
                                                            {{ $value }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="nomor_identitas" class="mb-1"><span
                                                        class="text-danger">*</span>Nomor
                                                    Identitas</label>
                                                <input type="text" class="form-control" name="nomor_identitas"
                                                    id="nomor_identitas" placeholder="Masukkan Nomor Identitas"
                                                    value="{{ old('nomor_identitas') }}" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="propinsi" class="mb-1">Provinsi</label>
                                                <input type="text" class="form-control" name="propinsi"
                                                    id="propinsi" placeholder="Masukkan Provinsi"
                                                    value="{{ old('propinsi') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="kota" class="mb-1">Kota</label>
                                                <input type="text" class="form-control" name="kota" id="kota"
                                                    placeholder="Masukkan Kota" value="{{ old('kota') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="" class="mb-1"><small class="text-danger">*</small>Alamat
                                            Domisili</label>
                                        <textarea class="form-control" name="alamat"
                                            placeholder="Masukkan Alamat Domisili: RT RW kelurahan kecamatan kabupaten provinsi" id="alamat" required>{{ old('alamat') }}</textarea>
                                        <small>*Masukkan alamat dengan jelas: RT RW kelurahan kecamatan kabupaten
                                            provinsi</small>
                                    </div>
                                </div>
                            </div>
                            <div class="card my-2 shadow" id="dokumen">
                                <div class="card-header">
                                    <span class="fw-bold">Upload Berkas</span>
                                </div>
                                <div class="card-body">
                                    @php
                                        $n = 0;
                                    @endphp
                                    @foreach ($listDokumen as $item)
                                        @php
                                            $accept = explode(',', $item->upload);
                                            $accept = array_map(function ($item) {
                                                return ".$item";
                                            }, $accept);
                                            $accept = implode(',', $accept);
                                        @endphp
                                        <div class="form-group mb-3">
                                            <label for="{{ $item->tipe }}"
                                                class="form-label">{{ $item->tipe }}</label>
                                            <input type="hidden" name="id_dokumen[]" value="{{ $item->id }}">
                                            <input class="form-control" name="file[{{ $n++ }}]" type="file"
                                                id="{{ $item->tipe }}" accept="{{ $accept }}" required>
                                            @if ($item->status == 'wajib')
                                                <small class="fw-bold text-danger">*Wajib Upload</small>
                                            @endif
                                            @if ($item->status == 'opsional')
                                                <small class="fw-bold text-warning">*Opsional Upload</small>
                                            @endif
                                            <small class="text-danger">*Gunakan extensi {{ $accept }} dan ukuran
                                                maksimal 20
                                                MB)</small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="card shadow my-2">
                                <div class="card-body">
                                    <div class="input-group mb-3">
                                        <button class="btn btn-lg btn-primary w-100 fs-6" id="form-submit">
                                            Daftar Sekarang
                                        </button>
                                    </div>
                                    <div class="row">
                                        <small>Sudah punya akun?
                                            <a href="{{ route('login') }}">Login Sekarang</a></small>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('script')
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap-5'
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            let nFile = "{{ count($listDokumen) }}";
            let rules = {};
            let messages = {
                username: {
                    required: "Username Wajib Diisi"
                },
                nama: {
                    required: "Nama Wajib Diisi"
                },
                nim: {
                    required: "NIM Wajib Diisi"
                },
                tanggal_lahir: {
                    required: "Tanggal Lahir Wajib Diisi"
                },
                tempat_lahir: {
                    required: "Tempat Lahir Wajib Diisi"
                },
                jenis_kelamin: {
                    required: "Jenis Kelamin Wajib Diisi"
                },
                nomor_hp: {
                    required: "Nomor Handphone Wajib Diisi"
                },
                tipe_identitas: {
                    required: "Tipe Identitas Wajib Diisi"
                },
                nomor_identitas: {
                    required: "Nomor Identitas Wajib Diisi"
                },
                alamat: {
                    required: "Alamat Wajib Diisi"
                },
                prodi_id: {
                    required: "Program Yang Dipilih Wajib Diisi"
                },
            }
            for (let i = 0; i < nFile; i++) {
                rules["file[" + i + "]"] = {
                    required: true,
                    extension: "jpg|jpeg|png",
                    filesize: 20 * 1024 * 1024 // 20MB
                };
                messages["file[" + i + "]"] = {
                    required: "File Wajib Diisi",
                    extension: "Format file harus JPG, JPEG, or PNG.",
                    filesize: "Ukuran file maksimal 20MB"
                };
            }

            $("#form-register").validate({
                submitHandler: function(form) {
                    form.submit();
                },
                ignore: [],
                rules: rules,
                messages: messages,
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('pl-2 invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    form.submit();
                    // Disable the submit button after successful submission
                    $("#form-submit").prop("disabled", true).html(
                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Sedang Diproses, Tunggu Sebentar Nggih...'
                    );
                }
            });

            // Custom validation method for file size
            $.validator.addMethod("filesize", function(value, element, param) {
                var size = element.files[0].size; // in bytes
                return this.optional(element) || (size <= param);
            }, "File size must be less than {0} bytes.");
        });

        function pakai(username) {
            $('#username').val(username);
            $('#username').removeClass('is-invalid');
            $('#username').addClass('is-valid');
        }
    </script>
@endpush
