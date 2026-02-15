@extends('layouts.admin.template')
@section('title', 'Admin | QR Code')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>QR Code</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ QR Code
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card" id="card">
                            <div class="card-header">
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" id="card_refresh">
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
                            <!-- /.card-header -->
                            <div class="card-body" id="card_body">
                                <div id="reader"></div>
                                {{-- <ul id="result">
                                </ul> --}}
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-12">
                        <form id="form_scan">
                            <div class="form-group">
                                <label for="scan">Scan Disini</label>
                                <div class="input-group">
                                    <input type="input" name="scan" class="form-control" id="search_scan"
                                        placeholder="PASTIKAN KURSOR KEYBOARD DI SINI UNTUK SCAN" onfocus="this.select();"
                                        autocomplete="off">
                                    <button type="submit" class="btn btn-primary" id="search_scan_btn"
                                        style="cursor: pointer">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="search">Cari</label>
                            <div class="input-group">
                                <input type="input" name="search" class="form-control" id="search_peserta"
                                    placeholder="Masukkan NIM / Nama" value="{{ old('search') }}" onfocus="this.select();">
                                <button type="button" class="btn btn-primary" id="search_peserta_btn"
                                    style="cursor: pointer" onclick="searchPeserta()">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="peserta_id" name="peserta_id">
                    </div>
                </div>

            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>

    <div class="modal fade" id="modal_kehadiran" tabindex="-1" role="dialog" aria-labelledby="modal_kehadiran">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="nim" class="text-bold">Konfirmasi Kehadiran</span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="input" name="nama" class="form-control" id="nama" placeholder="Masukkan Nama"
                            readonly>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prodi">Prodi</label>
                                <input type="input" name="prodi" class="form-control" id="prodi"
                                    placeholder="Masukkan Prodi" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <input type="input" name="jenis_kelamin" class="form-control" id="jenis_kelamin"
                                    placeholder="Masukkan Jenis Kelamin" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="row_mahasiswa">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="kehadiran_ayah">Kehadiran Ayah</label>
                                <input type="input" name="kehadiran_ayah" class="form-control kehadiran"
                                    id="kehadiran_ayah" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="kehadiran_ibu">Kehadiran Ibu</label>
                                <input type="input" name="kehadiran_ibu" class="form-control kehadiran"
                                    id="kehadiran_ibu" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="row_tamu">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="kehadiran_tamu">Kehadiran Tamu</label>
                                <input type="input" name="kehadiran_tamu" class="form-control kehadiran"
                                    id="kehadiran_tamu" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-success btn-konfirmasi" id="btn_konfirmasi_ayah"
                        onclick="konfirmasi('ayah', 'hadir')">KONFIRMASI AYAH</button>
                    <button type="button" class="btn btn-primary btn-konfirmasi" id="btn_konfirmasi_ibu"
                        onclick="konfirmasi('ibu', 'hadir')">KONFIRMASI IBU</button>
                    <button type="button" class="btn btn-primary btn-konfirmasi" id="btn_konfirmasi_tamu"
                        onclick="konfirmasi('tamu', 'hadir')">KONFIRMASI TAMU</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/html5-qrcode.min.js') }}"></script>
    <script>
        let scanQr = true;
        let reader = false;

        $(document).ready(function() {
            let html5QRCodeScanner = new Html5QrcodeScanner(
                "reader", {
                    fps: 10,
                    qrbox: {
                        width: 250,
                        height: 250,
                    },
                }
            );

            html5QRCodeScanner.render(onScanSuccess);

            $("#search_peserta").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "get",
                        data: {
                            term: request.term
                        },
                        url: "{{ route('operasi.kehadiran.autocomplete') }}",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    let value = ui.item.value;
                    let label = ui.item.label;
                    $('#peserta_id').val(value);
                    $('#search_peserta').val(label);
                    document.getElementById('search_peserta_btn').click();
                    return false; // make #search can edit
                }
            });

            $('#form_scan').submit(function(e) {
                e.preventDefault();
                reader = true;

                let id = $('#search_scan').val();
                $('#peserta_id').val(id);
                document.getElementById('search_peserta_btn').click();
            });
        });

        function onScanSuccess(decodedText, decodedResult) {
            // Handle on success condition with the decoded text or result.
            // var content = `
        // Scan result: ${decodedText} <br>
        // decodedResult.decodedText: ${decodedResult.decodedText}
        // Decoded result: ${decodedResult}
        // `;

            // var content = `<li>Hasil: ${decodedText}</li>`;
            // $('#result').append(content);

            // membersihkan scan area ketika sudah menjalankan
            // action diatas
            // html5QRCodeScanner.clear();

            if (scanQr) {
                scanQr = false;
                reader = false;

                $('#peserta_id').val(decodedText);
                document.getElementById('search_peserta_btn').click();
            }
        }

        function searchPeserta() {
            let pesertaId = $('#peserta_id').val();

            if (pesertaId) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('operasi.kehadiran.getData') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: pesertaId
                    },
                    beforeSend: function() {
                        $('.kehadiran').removeClass('bg-success text-white');
                        $('.kehadiran').val('');
                        $('.btn-konfirmasi').attr('disabled', false);

                        scanQr = false;
                    },
                    success: function(response) {
                        console.log(response);
                        if (response.status) {
                            let data = response.data;
                            if (data.nim) {
                                $('#search_peserta').val(`${data.nim} - ${data.nama}`);
                            } else {
                                $('#search_peserta').val(`${data.nama}`);
                            }

                            $('#nim').html(`Konfirmasi Kehadiran - ${data.tipe.toUpperCase()}`);
                            $('#nama').val(data.nama);
                            $('#prodi').val(data.prodi != null ? data.prodi.nama : 'KOSONG');
                            $('#jenis_kelamin').val(data.user != null ? data.user.jenis_kelamin : 'KOSONG');
                            data.kehadiran.forEach(element => {
                                if (element.status == 'hadir') {
                                    const d = new Date(element.updated_at);
                                    const pad = (n) => (n < 10 ? '0' + n : n);

                                    const waktu =
                                        `${pad(d.getDate())}-${pad(d.getMonth() + 1)}-${String(d.getFullYear()).slice(-2)} ${pad(d.getHours())}:${pad(d.getMinutes())}`;

                                    $('#kehadiran_' + element.jenis).val(`HADIR // ${waktu} WIB`);
                                    $('#kehadiran_' + element.jenis).addClass('bg-success text-white');
                                    $('#btn_konfirmasi_' + element.jenis).attr('disabled', true);
                                }
                            });

                            if (data.tipe == 'mahasiswa') {
                                $('#row_tamu').addClass('d-none');
                                $('#btn_konfirmasi_tamu').addClass('d-none');

                                $('#btn_konfirmasi_ayah').removeClass('d-none');
                                $('#btn_konfirmasi_ibu').removeClass('d-none');
                                $('#row_mahasiswa').removeClass('d-none');
                            } else {
                                $('#row_tamu').removeClass('d-none');
                                $('#btn_konfirmasi_tamu').removeClass('d-none');

                                $('#btn_konfirmasi_ayah').addClass('d-none');
                                $('#btn_konfirmasi_ibu').addClass('d-none');
                                $('#row_mahasiswa').addClass('d-none');
                            }
                            $('#modal_kehadiran').modal('show');
                        }
                    }
                });
            }
        }

        function konfirmasi(jenis, status) {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.qr_code.konfirmasi') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    jenis: jenis,
                    peserta_id: $('#peserta_id').val(),
                    status: status,
                    nama: $('#nama').val()
                },
                success: function(response) {
                    if (response.status) {
                        swalAlert('BERHASIL', response.message, 'success');
                        $('#modal_kehadiran').modal('hide');
                    } else {
                        swalAlert('GAGAL', response.message, 'error');
                    }
                }
            });
        }
    </script>
    <script>
        $('#modal_kehadiran').on('hidden.bs.modal', function(event) {
            scanQr = true;

            if (reader) {
                $('#search_scan').focus();
            }
        })
    </script>
    <script>
        function cardRefresh() {
            var cardRefresh = document.querySelector('#card_refresh');
            cardRefresh.click();
        }

        function swalAlert(title, text, icon) {
            Swal.fire({
                title: title,
                html: text,
                icon: icon
            }).then((result) => {
                if (reader) {
                    $('#search_scan').focus();
                }
            });
        }

        function swalToast(message, data) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            if (message == 200) {
                Toast.fire({
                    icon: 'success',
                    title: data
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data
                });
            }
        }
    </script>
@endpush
