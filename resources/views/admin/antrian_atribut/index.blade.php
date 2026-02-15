@extends('layouts.admin.template')
@section('title', 'Admin | Nomor Antrian Atribut')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Nomor Antrian Atribut</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Nomor Antrian Atribut
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
                                <span class="badge badge-info">Scan QR Code Nomor Antrian Atribut (Khusus Perempuan)</span>
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
                            <label for="search">Cari (NIM / Nama / Nomor Antrian)</label>
                            <div class="input-group">
                                <input type="input" name="search" class="form-control" id="search_peserta"
                                    placeholder="Masukkan NIM / Nama / Nomor Antrian" value="{{ old('search') }}" onfocus="this.select();">
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

        <!-- Data Antrian Section -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Data Antrian Atribut</h3>
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" id="reload_table">
                                        <i class="fas fa-sync-alt"></i>
                                    </button>
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <!-- Filters -->
                                <div class="row mb-3">
                                    <div class="col-md-3">
                                        <label>Tahun</label>
                                        <select class="form-control" id="filter_tahun">
                                            <option value="*">-- Semua Tahun --</option>
                                            @foreach ($tahun as $t)
                                                <option value="{{ $t->id }}">{{ $t->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Prodi</label>
                                        <select class="form-control" id="filter_prodi">
                                            <option value="*">-- Semua Prodi --</option>
                                            @foreach ($prodi as $p)
                                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label>Status</label>
                                        <select class="form-control" id="filter_status">
                                            <option value="*">-- Semua Status --</option>
                                            <option value="belum_cetak">Belum Cetak Tiket</option>
                                            <option value="menunggu">Menunggu</option>
                                            <option value="selesai">Selesai</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex align-items-end">
                                        <button type="button" class="btn btn-primary btn-block" id="btn_filter">
                                            <i class="fas fa-filter"></i> Filter
                                        </button>
                                    </div>
                                </div>
                                <!-- DataTable -->
                                <div class="table-responsive">
                                    <table id="table_antrian" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>NIM</th>
                                                <th>Nama</th>
                                                <th>Prodi</th>
                                                <th>Nomor Antrian</th>
                                                <th>Status</th>
                                                <th>Waktu Scan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>

    <div class="modal fade" id="modal_antrian" tabindex="-1" role="dialog" aria-labelledby="modal_antrian">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><span id="title_antrian" class="text-bold">Konfirmasi Antrian Atribut</span></h4>
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
                                <label for="nim">NIM</label>
                                <input type="input" name="nim" class="form-control" id="nim"
                                    placeholder="Masukkan NIM" readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="prodi">Prodi</label>
                                <input type="input" name="prodi" class="form-control" id="prodi"
                                    placeholder="Masukkan Prodi" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="nomor_antrian">Nomor Antrian</label>
                                <input type="input" name="nomor_antrian" class="form-control" id="nomor_antrian"
                                    readonly>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="status_antrian">Status Antrian</label>
                                <input type="input" name="status_antrian" class="form-control status_antrian" id="status_antrian"
                                    readonly>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-success btn-konfirmasi" id="btn_konfirmasi"
                        onclick="konfirmasi()">KONFIRMASI PENGAMBILAN ATRIBUT</button>
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
                        url: "{{ route('admin.antrian_atribut.autocomplete') }}",
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
                    return false;
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
                    url: "{{ route('admin.antrian_atribut.getData') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        search: pesertaId
                    },
                    beforeSend: function() {
                        $('.status_antrian').removeClass('bg-success bg-warning text-white');
                        $('.status_antrian').val('');
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

                            $('#title_antrian').html(`Konfirmasi Antrian Atribut - ${data.nomor_antrian}`);
                            $('#nama').val(data.nama);
                            $('#nim').val(data.nim || '-');
                            $('#prodi').val(data.prodi != null ? data.prodi.nama : 'KOSONG');
                            $('#nomor_antrian').val(data.nomor_antrian);
                            
                            if (data.status_antrian == 'selesai') {
                                $('#status_antrian').val(`SELESAI // ${data.waktu_scan} WIB`);
                                $('#status_antrian').addClass('bg-success text-white');
                                $('#btn_konfirmasi').attr('disabled', true);
                            } else {
                                $('#status_antrian').val('MENUNGGU');
                                $('#status_antrian').addClass('bg-warning text-white');
                                $('#btn_konfirmasi').attr('disabled', false);
                            }

                            $('#modal_antrian').modal('show');
                        } else {
                            swalAlert('GAGAL', response.message, 'error');
                            scanQr = true;
                        }
                    }
                });
            }
        }

        function konfirmasi() {
            $.ajax({
                type: "POST",
                url: "{{ route('admin.antrian_atribut.konfirmasi') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    peserta_id: $('#peserta_id').val(),
                    nama: $('#nama').val()
                },
                success: function(response) {
                    if (response.status) {
                        swalAlert('BERHASIL', response.message, 'success');
                        $('#modal_antrian').modal('hide');
                    } else {
                        swalAlert('GAGAL', response.message, 'error');
                    }
                }
            });
        }
    </script>
    <script>
        $('#modal_antrian').on('hidden.bs.modal', function(event) {
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
    <script>
        // DataTable
        var tableAntrian;
        
        $(document).ready(function() {
            tableAntrian = $('#table_antrian').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.antrian_atribut.dataTable') }}",
                    data: function(d) {
                        d.tahun_id = $('#filter_tahun').val();
                        d.prodi_id = $('#filter_prodi').val();
                        d.status = $('#filter_status').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'nim', name: 'peserta.nim' },
                    { data: 'nama', name: 'peserta.nama' },
                    { data: 'prodi_nama', name: 'prodi.nama' },
                    { data: 'nomor_antrian', name: 'antrian_atribut.nomor_antrian' },
                    { data: 'status_badge', name: 'status_badge', orderable: false, searchable: false },
                    { data: 'waktu_scan', name: 'antrian_atribut.waktu_scan' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[0, 'asc']],
                language: {
                    url: "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });

            $('#btn_filter').click(function() {
                tableAntrian.ajax.reload();
            });

            $('#reload_table').click(function() {
                tableAntrian.ajax.reload();
            });
        });

        function konfirmasiFromTable(pesertaId) {
            $('#peserta_id').val(pesertaId);
            searchPeserta();
        }
    </script>
@endpush
