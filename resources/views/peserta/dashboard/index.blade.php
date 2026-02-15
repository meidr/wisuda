@extends('layouts.peserta.template')
@section('title', 'Dashboard')
@push('css')
    <style>
        .profile-picture-container {
            width: 150px;
            height: 150px;
            overflow: hidden;
        }

        .profile-user-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush
@section('content')
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        {{-- <li class="breadcrumb-item"><a href="#" class="active">dashboard</a></li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center mb-3 d-flex justify-content-center">
                                @if (@$foto->file != null)
                                    <div class="profile-picture-container">
                                        <img class="profile-user-img img-fluid img-circle" src="{{ $showFoto }}"
                                            alt="User profile picture">
                                    </div>
                                @else
                                    <div class="profile-picture-container">
                                        <img class="profile-user-img img-fluid img-circle"
                                            src="{{ asset('/lte4/dist/img/user.png') }}" alt="User profile picture">
                                    </div>
                                @endif
                            </div>
                            <h3 class="profile-username text-center">{{ @$peserta->nama }}</h3>
                            <button class="btn btn-sm btn-link text-danger w-100" data-toggle="modal"
                                data-target="#modal-password"><i class="fas fa-pen"></i>
                                Ubah Password</button>
                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Username</b> <a class="float-right">{{ @$peserta->user->username }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Tanggal Daftar</b> <a
                                        class="float-right">{{ date('d M Y', strtotime(@$peserta->tanggal_daftar)) }}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Prodi</b> <a class="float-right">{{ @$peserta->getProdi->alias }}</a>
                                </li>
                            </ul>
                            <a href="{{ route('peserta.formulir.edit') }}" class="btn btn-primary btn-block"><b><i
                                        class="fas fa-edit mr-1"></i> Edit
                                    Formulir</b></a>
                            @php
                                $dokumenBuktiRevisi = \App\Models\DokumenBuktiRevisi::where('peserta_id', @$peserta->id)->first();
                                $canPrintAntrian = @$peserta->user->jenis_kelamin == 'Perempuan' 
                                    && @$dokumenBuktiRevisi 
                                    && @$dokumenBuktiRevisi->file_bukti 
                                    && @$dokumenBuktiRevisi->file_revisi 
                                    && @$dokumenBuktiRevisi->status_bukti == 'diterima' 
                                    && @$dokumenBuktiRevisi->status_revisi == 'diterima';
                                $canPrintAntrian = @$peserta->user->jenis_kelamin == 'Perempuan' 
                                    && @$dokumenBuktiRevisi 
                                    && @$dokumenBuktiRevisi->file_bukti 
                                    && @$dokumenBuktiRevisi->file_revisi 
                                    && @$dokumenBuktiRevisi->status_bukti == 'diterima' 
                                    && @$dokumenBuktiRevisi->status_revisi == 'diterima';
                            @endphp
                            @if ($canPrintAntrian)
                            <a href="{{ route('peserta.formulir.cetakAntrian', ['idPeserta' => @$peserta->id, 'noUnik' => @$peserta->user->no_unik]) }}"
                                class="btn btn-info btn-block" target="_blank"><b><i class="fas fa-ticket-alt mr-1"></i>
                                    Cetak Nomor Antrian Atribut</b></a>
                            @elseif (@$peserta->user->jenis_kelamin == 'Perempuan')
                            <button class="btn btn-secondary btn-block" disabled>
                                <b><i class="fas fa-ticket-alt mr-1"></i> Cetak Nomor Antrian Atribut</b>
                                <br><small>(Upload bukti & revisi dan tunggu validasi)</small>
                            </button>
                            @endif
                            {{-- <a href="{{ route('peserta.formulir.cetak', ['idPeserta' => @$peserta->id, 'noUnik' => @$peserta->user->no_unik]) }}"
                                class="btn btn-secondary btn-block" target="_blank"><b><i class="fas fa-print mr-1"></i>
                                    Cetak
                                    Formulir</b></a> --}}
                        </div>

                    </div>
                </div>

                <div class="col-md-9">
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h5><i class="icon fas fa-info"></i> Informasi</h5>
                        <ul>
                            <li>
                                Mohon untuk <b>melengkapi</b> semua dokumen yang dibutuhkan. Untuk
                                edit
                                dokumen
                                klik <a href="{{ route('peserta.formulir.edit') }}"><b>Edit
                                        Formulir</b></a>
                            </li>
                            <li>
                                Silahkan <b>ubah
                                    password</b> dengan klik ubah password pada bagian bawah foto
                            </li>
                        </ul>
                    </div>
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="tab-content">
                                <h4>Data Diri</h4>
                                <div class="post">
                                    <table>
                                        <tr>
                                            <td width="200">NAMA LENGKAP</td>
                                            <td>: {{ strtoupper(@$peserta->nama) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">NIM</td>
                                            <td>: {{ strtoupper(@$peserta->nim) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">NAMA AYAH</td>
                                            <td>: {{ strtoupper(@$peserta->nama_ayah) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">JUDUL</td>
                                            <td>: {{ strtoupper(@$peserta->judul) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">TANGGAL SIDANG</td>
                                            <td>: {{ strtoupper(@$peserta->tanggal_sidang) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">PRODI</td>
                                            <td>: {{ strtoupper(@$peserta->getProdi->nama) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">TEMPAT LAHIR</td>
                                            <td>: {{ strtoupper(@$peserta->tempat_lahir) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">TANGGAL LAHIR</td>
                                            <td>: {{ date('d M Y', strtotime(@$peserta->tanggal_lahir)) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">JENIS KELAMIN</td>
                                            <td>: {{ strtoupper(@$peserta->user->jenis_kelamin) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">NO TELEPON/WHATSAPP</td>
                                            <td>: {{ @$peserta->nomor_hp }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">TIPE IDENTITAS</td>
                                            <td>: {{ @$peserta->tipe_identitas }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">NOMOR IDENTITAS</td>
                                            <td>: {{ @$peserta->nomor_identitas }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">PROVINSI</td>
                                            <td>: {{ @$peserta->propinsi }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">KOTA</td>
                                            <td>: {{ @$peserta->kota }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">ALAMAT DOMISILI</td>
                                            <td>: {{ strtoupper(@$peserta->alamat) }}</td>
                                        </tr>
                                        <tr>
                                            <td width="200">UKURAN BAJU</td>
                                            <td>: {{ strtoupper(@$peserta->ukuran_baju) }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            DOKUMEN
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" id="card_refresh"
                                    data-card-widget="card-refresh" data-source="{{ url()->current() }}"
                                    data-source-selector="#card_refresh_nidn" data-load-on-init="false">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.card-tools -->
                        </div>
                        <div class="card-body" id="card_refresh_nidn">
                            <p>*Upload Berkas maksimal 20MB dan format jpg/jpeg/png</p>
                            @foreach ($listDokumen as $row)
                                @php
                                    $dokumenPeserta = App\Models\PesertaDokumen::where('peserta_id', $peserta->id)
                                        ->where('list_dokumen_id', $row->id)
                                        ->first();
                                @endphp
                                <div class="py-2 p-3 rounded  border border-dashed shadow-sm mb-2">
                                    <div class="row">
                                        <div class="col-md-6 d-flex align-items-center">
                                            @if ($dokumenPeserta)
                                                <span class="bg-success p-2 rounded">
                                                    <i class="fas fa-folder-open text-warning"></i>
                                                </span>
                                            @else
                                                <span class="bg-danger p-2 rounded">
                                                    <i class="fas fa-folder-open text-warning"></i>
                                                </span>
                                            @endif
                                            <div class="ml-3">
                                                <h5 class="mb-0 pb-0">{{ strtoupper($row->tipe) }}</h5>
                                                @if ($dokumenPeserta)
                                                    @php
                                                        $linkDokumen = App\Http\Services\GoogleDrive::link(
                                                            @$dokumenPeserta->path,
                                                        );
                                                    @endphp
                                                    <small class="fw-bold text-success">Sudah Upload</small>
                                                    - <a href="{{ $linkDokumen }}"
                                                        class="text-secondary text-decoration-none" target="_blank"><u>Lihat
                                                            Berkas
                                                            <i
                                                                class="fas
                                                                fa-external-link-alt"></i></u></a>
                                                    <br>
                                                    <small><span class="text-danger">*</span>Silahkan upload ulang jika
                                                        ingin
                                                        mengubah
                                                    </small>
                                                @else
                                                    @if ($row->status == 'wajib')
                                                        <small class="fw-bold text-danger">*Wajib</small>
                                                    @endif
                                                    @if ($row->status == 'opsional')
                                                        <small class="fw-bold text-warning">*Opsional</small>
                                                    @endif
                                                    <small class="fw-bold text-danger">| Belum Upload</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </section>
    {{-- Modal Ganti Password --}}
    <form action="" id="form-setting" method="POST">
        @csrf
        @method('PUT')
        <div class="modal fade" id="modal-password">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Ganti Password</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_edit" id="id_edit" value="{{ Auth::user()->id }}">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" id="username"
                                placeholder="Masukkan Username" value="{{ Auth::user()->username }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password"
                                placeholder="Masukkan Password Baru">
                        </div>
                        <div class="form-group">
                            <label for="password_confirm">Konfirmasi
                                Password</label>
                            <input type="password" name="password_confirm" class="form-control" id="password_confirm"
                                placeholder="Masukkan Konfirmasi Password">
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="button_submit_setting">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $("#form-setting").validate({
                rules: {
                    password: {
                        required: true
                    },
                    password_confirm: {
                        required: true,
                        equalTo: "#password"
                    }
                },
                messages: {
                    password: {
                        required: "Password is required"
                    },
                    password_confirm: {
                        required: "Confirm Password is required",
                        equalTo: "Passwords do not match"
                    }
                },
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
                }
            });

            $('#form-setting').submit(function(e) {
                e.preventDefault();

                if ($(this).valid()) {
                    let fd = new FormData(this);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('peserta.dashboard.changePassword') }}",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            console.log(response);
                            if (response.message == 200) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: response.data,
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'error',
                                    text: response.data,
                                    timer: 1000,
                                    showConfirmButton: false
                                });
                            }
                            $('#modal-password').modal('toggle');
                            $('#form-setting').trigger('reset');
                        }
                    });
                }
            });
        });
    </script>
@endpush
