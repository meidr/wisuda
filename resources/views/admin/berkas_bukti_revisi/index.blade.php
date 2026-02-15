@extends('layouts.admin.template')
@section('title', 'Admin | Berkas Bukti & Revisi')
@section('css')
    <style>
        .dataTables_paginate>span {
            background-color: #007bff;
            margin: 5px;
            padding: 7px;
            border-radius: 10px;
            cursor: pointer;
            color: white;
            border: none;
        }

        .dataTables_paginate>input {
            width: 50px;
            background-color: white;
            color: black;
            border: 1px solid #007bff;
            border-radius: 10px;
            margin: 5px;
            padding: 5px;
        }

        .dataTables_paginate>input:focus {
            border: none;
        }

        .dataTables_paginate>span:hover {
            background-color: rgb(183, 214, 255);
        }

        .dataTables_paginate>span:empty {
            display: none;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Berkas Bukti & Revisi</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Berkas Bukti & Revisi
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                {{-- FILTER --}}
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Filter</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="tahun_id">Tahun</label>
                                    <select class="form-control select2bs4" name="tahun_id" id="tahun_id">
                                        <option value="*">Semua</option>
                                        @foreach ($tahun as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="prodi_id">Prodi</label>
                                    <select class="form-control select2bs4" name="prodi_id" id="prodi_id">
                                        <option value="*">Semua</option>
                                        @foreach ($prodi as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status_bukti">Status Bukti</label>
                                    <select class="form-control select2bs4" name="status_bukti" id="status_bukti">
                                        <option value="*">Semua</option>
                                        <option value="belum_upload">Belum Upload</option>
                                        <option value="belum_validasi">Belum Validasi</option>
                                        <option value="diterima">Diterima</option>
                                        <option value="ditolak">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="status_revisi">Status Revisi</label>
                                    <select class="form-control select2bs4" name="status_revisi" id="status_revisi">
                                        <option value="*">Semua</option>
                                        <option value="belum_upload">Belum Upload</option>
                                        <option value="belum_validasi">Belum Validasi</option>
                                        <option value="diterima">Diterima</option>
                                        <option value="ditolak">Ditolak</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TABEL DATA --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card" id="card">
                            <div class="card-header">
                                <span class="badge badge-info">Menampilkan data mahasiswa Perempuan</span>
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
                                <div class="table-responsive">
                                    <table id="table1" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tahun</th>
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Prodi</th>
                                                <th>Status Bukti</th>
                                                <th>Status Revisi</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        {{-- Modal Validasi Bukti --}}
        <div class="modal fade" id="modal_validasi_bukti" role="dialog" aria-labelledby="modal_validasi_bukti">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Validasi Bukti - <span id="nama_bukti"></span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="peserta_id_bukti">
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" class="form-control" id="nim_bukti" readonly>
                        </div>
                        <div class="form-group">
                            <label>Lihat Dokumen</label>
                            <div>
                                <a href="#" id="link_bukti" target="_blank" class="btn btn-info">
                                    <i class="fas fa-external-link-alt"></i> Buka Dokumen Bukti
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status Saat Ini</label>
                            <div id="current_status_bukti"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <div>
                            <button type="button" class="btn btn-warning btn-validasi" onclick="validasiBukti('belum_validasi')">Belum Validasi</button>
                            <button type="button" class="btn btn-success btn-validasi" onclick="validasiBukti('diterima')">Diterima</button>
                            <button type="button" class="btn btn-danger btn-validasi" onclick="validasiBukti('ditolak')">Ditolak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Validasi Revisi --}}
        <div class="modal fade" id="modal_validasi_revisi" role="dialog" aria-labelledby="modal_validasi_revisi">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Validasi Revisi - <span id="nama_revisi"></span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="peserta_id_revisi">
                        <div class="form-group">
                            <label>NIM</label>
                            <input type="text" class="form-control" id="nim_revisi" readonly>
                        </div>
                        <div class="form-group">
                            <label>Lihat Dokumen</label>
                            <div>
                                <a href="#" id="link_revisi" target="_blank" class="btn btn-info">
                                    <i class="fas fa-external-link-alt"></i> Buka Dokumen Revisi
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Status Saat Ini</label>
                            <div id="current_status_revisi"></div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <div>
                            <button type="button" class="btn btn-warning btn-validasi" onclick="validasiRevisi('belum_validasi')">Belum Validasi</button>
                            <button type="button" class="btn btn-success btn-validasi" onclick="validasiRevisi('diterima')">Diterima</button>
                            <button type="button" class="btn btn-danger btn-validasi" onclick="validasiRevisi('ditolak')">Ditolak</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // data table and card refresh
            var table1 = dataTable('#table1');
            $('div.dataTables_filter input', table1.table().container()).focus();

            $('#card_refresh').click(function(e) {
                table1.ajax.reload();
            });

            $('#tahun_id').change(function(e) {
                cardRefresh();
            });
            $('#prodi_id').change(function(e) {
                cardRefresh();
            });
            $('#status_bukti').change(function(e) {
                cardRefresh();
            });
            $('#status_revisi').change(function(e) {
                cardRefresh();
            });
        });

        // Modal Bukti
        $('#modal_validasi_bukti').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var nim = button.data('nim');
            var link = button.data('link');
            var status = button.data('status');

            var modal = $(this);
            modal.find('#peserta_id_bukti').val(id);
            modal.find('#nama_bukti').text(nama);
            modal.find('#nim_bukti').val(nim);
            modal.find('#link_bukti').attr('href', link);
            
            var badge = getStatusBadge(status);
            modal.find('#current_status_bukti').html(badge);
        });

        // Modal Revisi
        $('#modal_validasi_revisi').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var nama = button.data('nama');
            var nim = button.data('nim');
            var link = button.data('link');
            var status = button.data('status');

            var modal = $(this);
            modal.find('#peserta_id_revisi').val(id);
            modal.find('#nama_revisi').text(nama);
            modal.find('#nim_revisi').val(nim);
            modal.find('#link_revisi').attr('href', link);
            
            var badge = getStatusBadge(status);
            modal.find('#current_status_revisi').html(badge);
        });

        function getStatusBadge(status) {
            switch(status) {
                case 'belum_validasi':
                    return '<span class="badge badge-warning">Belum Validasi</span>';
                case 'diterima':
                    return '<span class="badge badge-success">Diterima</span>';
                case 'ditolak':
                    return '<span class="badge badge-danger">Ditolak</span>';
                default:
                    return '<span class="badge badge-secondary">-</span>';
            }
        }

        function validasiBukti(status) {
            var pesertaId = $('#peserta_id_bukti').val();
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin.berkas-bukti-revisi.validasiBukti') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    peserta_id: pesertaId,
                    status: status
                },
                beforeSend: function() {
                    $('.btn-validasi').attr('disabled', true);
                },
                success: function(response) {
                    $('.btn-validasi').attr('disabled', false);
                    if (response.message == 200) {
                        swalToast(200, response.data);
                        $('#modal_validasi_bukti').modal('hide');
                        cardRefresh();
                    } else {
                        swalToast(500, response.data);
                    }
                }
            });
        }

        function validasiRevisi(status) {
            var pesertaId = $('#peserta_id_revisi').val();
            
            $.ajax({
                type: "POST",
                url: "{{ route('admin.berkas-bukti-revisi.validasiRevisi') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    peserta_id: pesertaId,
                    status: status
                },
                beforeSend: function() {
                    $('.btn-validasi').attr('disabled', true);
                },
                success: function(response) {
                    $('.btn-validasi').attr('disabled', false);
                    if (response.message == 200) {
                        swalToast(200, response.data);
                        $('#modal_validasi_revisi').modal('hide');
                        cardRefresh();
                    } else {
                        swalToast(500, response.data);
                    }
                }
            });
        }

        function dataTable(id) {
            var url = "{{ route('admin.berkas-bukti-revisi.data') }}"
            var datatable = $(id).DataTable({
                autoWidth: false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                "pagingType": "input",
                ajax: {
                    url: url,
                    data: function(d) {
                        d.tahun_id = $('#tahun_id').val();
                        d.prodi_id = $('#prodi_id').val();
                        d.status_bukti = $('#status_bukti').val();
                        d.status_revisi = $('#status_revisi').val();
                    },
                    beforeSend: function() {
                        $('.overlay').remove();
                        var div = '<div class="overlay">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('#card').append(div);
                    },
                    complete: function() {
                        $('.overlay').remove();
                    }
                },
                deferRender: true,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "align-middle"
                    },
                    {
                        data: 'tahun_nama',
                        name: 'tahun_nama',
                        className: "align-middle",
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        className: "align-middle",
                    },
                    {
                        data: 'nim',
                        name: 'nim',
                        className: "align-middle",
                    },
                    {
                        data: 'prodi_nama',
                        name: 'prodi_nama',
                        className: "align-middle",
                    },
                    {
                        data: 'status_bukti_badge',
                        name: 'status_bukti_badge',
                        className: "align-middle",
                    },
                    {
                        data: 'status_revisi_badge',
                        name: 'status_revisi_badge',
                        className: "align-middle",
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "align-middle",
                        'searchable': false,
                    },
                ],
            });
            return datatable;
        }

        function cardRefresh() {
            var cardRefresh = document.querySelector('#card_refresh');
            cardRefresh.click();
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
