@extends('layouts.peserta.template')
@section('title', 'Edit Formulir')
@section('css')
    <style>
        form input {
            text-transform: uppercase;
        }

        form textarea {
            text-transform: uppercase;
        }

        form select {
            text-transform: uppercase;
        }

        form label {
            text-transform: uppercase;
        }

        .foto {
            width: 200px;
            height: 300px;
        }
    </style>
@endsection
@section('content')
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Formulir</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('peserta.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Formulir</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('peserta.dashboard') }}" class="btn btn-sm btn-secondary mb-2"><i
                            class="fas fa-arrow-left"></i>
                        Kembali</a>
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            UPLOAD BERKAS
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
                            <p>
                                <img class="foto" src="{{ asset('assets/img/Foto Banin.png') }}" alt="Foto Banin">
                                <img class="foto" src="{{ asset('assets/img/Foto Banat.jpg') }}" style="width: 450px !important" alt="Foto Banat">
                            </p>
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
                                        <div class="col-md-6 d-flex align-items-end justify-content-end py-2">
                                            <button class="btn btn-sm btn-success" data-toggle="modal"
                                                data-target="#add-modal" data-id="{{ $row->id }}"
                                                data-tipe="{{ $row->tipe }}" data-status="{{ strtoupper($row->status) }}"
                                                data-dokumen_peserta="{{ @$dokumenPeserta->file }}"
                                                data-upload="{{ $row->upload }}"><i class="fas fa-upload"></i>
                                                Upload
                                                File</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Bukti & Revisi Upload (Khusus Perempuan) --}}
                            @if (@$peserta->user->jenis_kelamin == 'Perempuan')
                                @php
                                    $dokumenBuktiRevisi = App\Models\DokumenBuktiRevisi::where('peserta_id', $peserta->id)->first();
                                @endphp
                                
                                {{-- Bukti Upload --}}
                                <div class="py-2 p-3 rounded border border-dashed shadow-sm mb-2 bg-light">
                                    <div class="row">
                                        <div class="col-md-6 d-flex align-items-center">
                                            @if (@$dokumenBuktiRevisi->file_bukti)
                                                <span class="bg-success p-2 rounded">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </span>
                                            @else
                                                <span class="bg-danger p-2 rounded">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </span>
                                            @endif
                                            <div class="ml-3">
                                                <h5 class="mb-0 pb-0">BUKTI</h5>
                                                @if (@$dokumenBuktiRevisi->file_bukti)
                                                    @php
                                                        $linkBukti = App\Http\Services\GoogleDrive::link(@$dokumenBuktiRevisi->path_bukti);
                                                        $statusBukti = @$dokumenBuktiRevisi->status_bukti;
                                                        $badgeMap = ['belum_validasi' => 'warning', 'diterima' => 'success', 'ditolak' => 'danger'];
                                                        $labelMap = ['belum_validasi' => 'Belum Validasi', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'];
                                                        $badgeBukti = $badgeMap[$statusBukti] ?? 'secondary';
                                                        $labelBukti = $labelMap[$statusBukti] ?? '-';
                                                    @endphp
                                                    <small class="fw-bold text-success">Sudah Upload</small>
                                                    - <a href="{{ $linkBukti }}" class="text-secondary text-decoration-none" target="_blank">
                                                        <u>Lihat Berkas <i class="fas fa-external-link-alt"></i></u>
                                                    </a>
                                                    <br>
                                                    <span class="badge badge-{{ $badgeBukti }}">{{ $labelBukti }}</span>
                                                    <br>
                                                    <small><span class="text-danger">*</span>Silahkan upload ulang jika ingin mengubah</small>
                                                @else
                                                    <small class="fw-bold text-warning">*Khusus Perempuan</small>
                                                    <small class="fw-bold text-danger">| Belum Upload</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end justify-content-end py-2">
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-bukti">
                                                <i class="fas fa-upload"></i> Upload Bukti
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                {{-- Revisi Upload --}}
                                <div class="py-2 p-3 rounded border border-dashed shadow-sm mb-2 bg-light">
                                    <div class="row">
                                        <div class="col-md-6 d-flex align-items-center">
                                            @if (@$dokumenBuktiRevisi->file_revisi)
                                                <span class="bg-success p-2 rounded">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </span>
                                            @else
                                                <span class="bg-danger p-2 rounded">
                                                    <i class="fas fa-file-alt text-white"></i>
                                                </span>
                                            @endif
                                            <div class="ml-3">
                                                <h5 class="mb-0 pb-0">REVISI</h5>
                                                @if (@$dokumenBuktiRevisi->file_revisi)
                                                    @php
                                                        $linkRevisi = App\Http\Services\GoogleDrive::link(@$dokumenBuktiRevisi->path_revisi);
                                                        $statusRevisi = @$dokumenBuktiRevisi->status_revisi;
                                                        $badgeMap = ['belum_validasi' => 'warning', 'diterima' => 'success', 'ditolak' => 'danger'];
                                                        $labelMap = ['belum_validasi' => 'Belum Validasi', 'diterima' => 'Diterima', 'ditolak' => 'Ditolak'];
                                                        $badgeRevisi = $badgeMap[$statusRevisi] ?? 'secondary';
                                                        $labelRevisi = $labelMap[$statusRevisi] ?? '-';
                                                    @endphp
                                                    <small class="fw-bold text-success">Sudah Upload</small>
                                                    - <a href="{{ $linkRevisi }}" class="text-secondary text-decoration-none" target="_blank">
                                                        <u>Lihat Berkas <i class="fas fa-external-link-alt"></i></u>
                                                    </a>
                                                    <br>
                                                    <span class="badge badge-{{ $badgeRevisi }}">{{ $labelRevisi }}</span>
                                                    <br>
                                                    <small><span class="text-danger">*</span>Silahkan upload ulang jika ingin mengubah</small>
                                                @else
                                                    <small class="fw-bold text-warning">*Khusus Perempuan</small>
                                                    <small class="fw-bold text-danger">| Belum Upload</small>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end justify-content-end py-2">
                                            <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#modal-revisi">
                                                <i class="fas fa-upload"></i> Upload Revisi
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('peserta.formulir.update') }}" method="POST" id="form-update">
                        @method('PUT')
                        @csrf
                        <div class="card card-primary card-outline">
                            <div class="card-body">
                                <h5 class="fw-bold">BIODATA DIRI</h5>
                                <hr>
                                <div class="form-group">
                                    <label for="nama_lengkap"><span class="text-danger">*</span>Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                                        placeholder="Masukkan Nama Lengkap" value="{{ $peserta->nama }}" required>
                                </div>
                                <div class="form-group">
                                    <label for="nim"><span class="text-danger">*</span>NIM</label>
                                    <input type="text" class="form-control" name="nim" id="nim"
                                        placeholder="Masukkan NIM" value="{{ $peserta->nim }}" disabled>
                                    <small id="nimHelp" class="form-text text-muted">*Hubungi operator jika ingin merubah
                                        NIM</small>
                                </div>
                                <div class="form-group">
                                    <label for="prodi_id"><span class="text-danger">*</span>Prodi</label>
                                    <select class="form-control select2bs4" name="prodi_id" id="prodi_id" required>
                                        <option>Pilih</option>
                                        @foreach ($prodi as $item)
                                            <option value="{{ $item->id }}"
                                                {{ $item->id == $peserta->prodi_id ? 'selected' : '' }}>
                                                {{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nama_ayah"><span class="text-danger">*</span>Nama Ayah</label>
                                    <input type="text" name="nama_ayah" class="form-control" id="nama_ayah" required
                                        placeholder="Masukkan Nama Ayah" value="{{ $peserta->nama_ayah }}">
                                </div>
                                <div class="form-group">
                                    <label for="judul"><span class="text-danger">*</span>Judul</label>
                                    <input type="text" name="judul" class="form-control" id="judul" required
                                        placeholder="Masukkan Judul" value="{{ $peserta->judul }}">
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_sidang"><span class="text-danger">*</span>Tanggal Sidang</label>
                                    <input type="date" name="tanggal_sidang" class="form-control" id="tanggal_sidang"
                                        required placeholder="Masukkan Tanggal Sidang"
                                        value="{{ $peserta->tanggal_sidang }}">
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tempat_lahir"><span class="text-danger">*</span>Tempat
                                                Lahir</label>
                                            <input type="text" class="form-control" name="tempat_lahir"
                                                id="tempat_lahir" placeholder="Masukkan Tempat Lahir"
                                                value="{{ $peserta->tempat_lahir }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tanggal_lahir"><span class="text-danger">*</span>Tanggal
                                                lahir</label>
                                            <input type="date" class="form-control" name="tanggal_lahir"
                                                id="tanggal_lahir" placeholder="Masukkan Tanggal lahir"
                                                value="{{ $peserta->tanggal_lahir }}" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="jenis_kelamin"><span class="text-danger">*</span>Jenis
                                        Kelamin</label>
                                    <select class="form-control select2bs4" name="jenis_kelamin" id="jenis_kelamin"
                                        required>
                                        <option value="">Pilih</option>
                                        @foreach (BulkData::jenisKelamin as $jk)
                                            <option value="{{ $jk }}"
                                                {{ $jk == $peserta->user->jenis_kelamin ? 'selected' : '' }}>
                                                {{ $jk }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="nomor_hp"><span class="text-danger">*</span>Nomor Telepon/WhatsApp</label>
                                    <input type="number" class="form-control" name="nomor_hp" id="nomor_hp"
                                        placeholder="Masukkan Nomor Telepon/WhatsApp" value="{{ $peserta->nomor_hp }}"
                                        required>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tipe_identitas"><span class="text-danger">*</span>Tipe
                                                Identitas</label>
                                            <select class="form-control select2bs4" name="tipe_identitas"
                                                id="tipe_identitas" required>
                                                <option>Pilih</option>
                                                @foreach ($tipeIdentitas as $key => $value)
                                                    <option value="{{ $value }}"
                                                        {{ $value == $peserta->tipe_identitas ? 'selected' : '' }}>
                                                        {{ $value }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nomor_identitas"><span class="text-danger">*</span>Nomor
                                                Identitas</label>
                                            <input type="text" class="form-control" name="nomor_identitas"
                                                id="nomor_identitas" placeholder="Masukkan Nomor Identitas"
                                                value="{{ $peserta->nomor_identitas }}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="propinsi"><span class="text-danger">*</span>Provinsi</label>
                                            <input type="text" class="form-control" name="propinsi" id="propinsi" required
                                                placeholder="Masukkan Provinsi" value="{{ $peserta->propinsi }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="kota"><span class="text-danger">*</span>Kota</label>
                                            <input type="text" class="form-control" name="kota" id="kota" required
                                                placeholder="Masukkan Kota" value="{{ $peserta->kota }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ukuran_baju"><span class="text-danger">*</span>Ukuran Baju</label>
                                    <select class="form-control select2bs4" name="ukuran_baju" id="ukuran_baju" required>
                                        <option value="">PILIH UKURAN BAJU</option>
                                        @foreach (\Helper::getEnumValues('peserta', 'ukuran_baju') as $item)
                                            <option value="{{ $item }}"
                                                {{ $item == $peserta->ukuran_baju ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="alamat"><span class="text-danger">*</span>Alamat Domisili</label>
                                    <textarea class="form-control" name="alamat" id="alamat" required>{{ $peserta->alamat }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary w-100" id="form-submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>

    {{-- Modal Add Dokumen --}}
    <form action="" method="post" id="form_update_dokumen" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="add-modal" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="text-primary">UPLOAD SYARAT
                                :</span>
                            <span id="nama-dokumen"></span>
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="hidden" name="id_dokumen" id="id_dokumen">
                                <input type="hidden" name="tipe" id="tipe">
                                <input type="status" name="status" id="status">
                                <input type="file" name="file" class="custom-file-input" id="file"
                                    accept=".png, .jpeg, .jpg, .pdf">
                                <label class="custom-file-label" for="file" id="pilih_file">Pilih
                                    File</label>
                            </div>
                        </div>
                        <small><span class="text-danger">*</span>Ukuran file maksimal 20MB.
                            Tipe file
                            :
                            <span id="upload"></span></small>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="form-submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Modal Upload Bukti --}}
    @if (@$peserta->user->jenis_kelamin == 'Perempuan')
    <form action="" method="post" id="form_upload_bukti" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modal-bukti" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="modal-bukti-label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="text-primary">UPLOAD BUKTI</span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file_bukti" class="custom-file-input" id="file_bukti"
                                    accept=".png, .jpeg, .jpg, .pdf">
                                <label class="custom-file-label" for="file_bukti" id="pilih_file_bukti">Pilih File Bukti</label>
                            </div>
                        </div>
                        <small><span class="text-danger">*</span>Ukuran file maksimal 20MB. Tipe file: .jpg, .jpeg, .png, .pdf</small>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="form-submit-bukti" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{-- Modal Upload Revisi --}}
    <form action="" method="post" id="form_upload_revisi" enctype="multipart/form-data">
        @csrf
        <div class="modal fade" id="modal-revisi" data-backdrop="static" data-keyboard="false" tabindex="-1"
            aria-labelledby="modal-revisi-label" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><span class="text-primary">UPLOAD REVISI</span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file_revisi" class="custom-file-input" id="file_revisi"
                                    accept=".png, .jpeg, .jpg, .pdf">
                                <label class="custom-file-label" for="file_revisi" id="pilih_file_revisi">Pilih File Revisi</label>
                            </div>
                        </div>
                        <small><span class="text-danger">*</span>Ukuran file maksimal 20MB. Tipe file: .jpg, .jpeg, .png, .pdf</small>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="form-submit-revisi" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
@endsection
@push('script')
    <script>
        $(document).ready(function() {

            $(function() {
                bsCustomFileInput.init();
            });

            $("#form-update").validate({
                rules: {
                    "file[]": {
                        required: true,
                        extension: "jpg|jpeg|png",
                        filesize: 2 * 1024 * 1024 // 2MB
                    }
                },
                messages: {
                    nama_lengkap: {
                        required: "Nama Wajib Diisi"
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
                    kewarganegaraan: {
                        required: "Kewarganegaraan Wajib Diisi"
                    },
                    warga_negara: {
                        required: "Warga Negara Wajib Diisi"
                    },
                    alamat: {
                        required: "Alamat Wajib Diisi"
                    },
                    nama_ayah: {
                        required: "Nama Ayah/Wali/Pengurus Wajib Diisi"
                    },
                    nomor_hp_ayah: {
                        required: "Nomor Handphone Ayah/Wali/Pengurus Wajib Diisi"
                    },
                    prodi_id: {
                        required: "Program Yang Dipilih Wajib Diisi"
                    },
                    ukuran_baju: {
                        required: "Ukuran Baju Yang Dipilih Wajib Diisi"
                    },
                    tipe_identitas: {
                        required: "Provinsi Yang Dipilih Wajib Diisi"
                    },
                    propinsi: {
                        required: "Provinsi Yang Dipilih Wajib Diisi"
                    },
                    kota: {
                        required: "Kota Yang Dipilih Wajib Diisi"
                    },
                    "file[]": {
                        required: "File Wajib Diisi",
                        extension: "Format file harus JPG, JPEG, or PNG.",
                        filesize: "Ukuran file maksimal 2MB"
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
    </script>
    <script>
        $(document).ready(function() {
            $('#add-modal').on('show.bs.modal', function(event) {
                let button = $(event.relatedTarget);
                let id = button.data('id');
                let tipe = button.data('tipe');
                let status = button.data('status');
                let dokumenPeserta = button.data('dokumen_peserta');
                let upload = button.data('upload');

                upload = upload.split(',');
                upload = upload.map(str => {
                    return `.${str}`;
                }).toString();

                let modal = $(this);
                modal.find('#id_dokumen').val(id);
                modal.find('#status').html(status);
                modal.find('#tipe').val(tipe);
                modal.find('#upload').html(upload);
                modal.find('#file').attr('accept', upload);

                if (dokumenPeserta) {
                    $('#pilih_file').html('Pilih File');
                }
            })

            initUpload("form_update_dokumen");

        });

        function initUpload(formId) {
            $(function() {
                bsCustomFileInput.init();
            });

            $("#" + formId).submit(function(e) {
                e.preventDefault();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                let url = "{{ route('peserta.formulir.dokumen') }}";
                var fd = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    beforeSend: function() {
                        $('.overlay').remove();
                        var div =
                            '<div class="overlay" style="background-color: rgb(255, 255, 255, 0.7)">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('.modal-content').append(div);
                        $('#form_submit').attr('disabled', true);
                    },
                    success: function(response) {
                        console.log(response);
                        $('#form_submit').attr('disabled', false);
                        $('#add-modal').modal('toggle');
                        if (response.message == 500) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.data,
                            });
                        }
                    },
                    complete: function() {
                        $('.overlay').remove();
                        document.getElementById('card_refresh').click();
                        $('#pilih_file').html('Pilih File');
                    },
                });
            });
        }
    </script>

    {{-- Script untuk Upload Bukti dan Revisi --}}
    @if (@$peserta->user->jenis_kelamin == 'Perempuan')
    <script>
        $(document).ready(function() {
            // Init file input for bukti and revisi
            bsCustomFileInput.init();

            // Form Bukti Submit
            $("#form_upload_bukti").submit(function(e) {
                e.preventDefault();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                let url = "{{ route('peserta.formulir.uploadBukti') }}";
                var fd = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    beforeSend: function() {
                        $('.overlay').remove();
                        var div =
                            '<div class="overlay" style="background-color: rgb(255, 255, 255, 0.7)">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('.modal-content').append(div);
                        $('#form-submit-bukti').attr('disabled', true);
                    },
                    success: function(response) {
                        console.log(response);
                        $('#form-submit-bukti').attr('disabled', false);
                        $('#modal-bukti').modal('toggle');
                        if (response.message == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.data,
                            });
                        }
                    },
                    complete: function() {
                        $('.overlay').remove();
                        $('#pilih_file_bukti').html('Pilih File Bukti');
                    },
                });
            });

            // Form Revisi Submit
            $("#form_upload_revisi").submit(function(e) {
                e.preventDefault();
                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                let url = "{{ route('peserta.formulir.uploadRevisi') }}";
                var fd = new FormData(this);

                $.ajax({
                    type: "POST",
                    url: url,
                    data: fd,
                    contentType: false,
                    processData: false,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    beforeSend: function() {
                        $('.overlay').remove();
                        var div =
                            '<div class="overlay" style="background-color: rgb(255, 255, 255, 0.7)">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('.modal-content').append(div);
                        $('#form-submit-revisi').attr('disabled', true);
                    },
                    success: function(response) {
                        console.log(response);
                        $('#form-submit-revisi').attr('disabled', false);
                        $('#modal-revisi').modal('toggle');
                        if (response.message == 200) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data,
                            }).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: response.data,
                            });
                        }
                    },
                    complete: function() {
                        $('.overlay').remove();
                        $('#pilih_file_revisi').html('Pilih File Revisi');
                    },
                });
            });
        });
    </script>
    @endif
@endpush
