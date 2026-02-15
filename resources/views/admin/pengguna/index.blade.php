@extends('layouts.admin.template')
@section('title', 'Admin | Pengguna')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Pengguna</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Pengguna
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="alert alert-danger" role="alert">
                    Pastikan sebelum menghapus data pengguna, data PESERTA juga sudah dihapus !
                  </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card" id="card">
                            <div class="card-header">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add">
                                    <i class="fas fa-plus-circle mx-2"></i>Tambah Data</button>
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
                                                <th>Username</th>
                                                <th>Nama</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>JK</th>
                                                <th>HP</th>
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

        {{-- Modal Tambah --}}
        <form action="" id="form_add" enctype="multipart/form-data" method="POST">
            @csrf
            <div class="modal fade" id="modal_add" tabindex="-1" role="dialog" aria-labelledby="modal_add">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">Tambah Pengguna </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="input" name="username" class="form-control" id="username_add"
                                    placeholder="Masukkan Username" value="{{ old('username') }}">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control " id="password_add"
                                        placeholder="Masukkan password">
                                    <button type="button" class="btn btn-secondary"
                                        onclick="showHidePassword(event, '#password_add')">
                                        <i class="fa fa-eye-slash"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="hp">No. HP</label>
                                <input type="input" name="hp" class="form-control" id="hp_add"
                                    placeholder="Masukkan No. HP" value="{{ old('hp') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" class="form-control"
                                            placeholder="Masukkan Nama" value="{{ old('nama') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control"
                                            placeholder="Masukkan Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <select class="form-control select2bs4 w-100" name="role_id" required>
                                            <option value="">Pilih Role</option>
                                            @foreach ($role as $item)
                                                <option value="{{ $item->id }}">{{ strtoupper($item->nama) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control select2bs4 w-100" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            @foreach (\Helper::getEnumValues('users', 'jenis_kelamin') as $item)
                                                <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="btn_simpan">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Modal Edit --}}
        <form action="#" method="POST" enctype="multipart/form-data" id="form_edit">
            @csrf
            <div class="modal fade" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="modal_edit"
                aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="title_edit">Edit </h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="id" id="id_edit">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="input" name="username" class="form-control" id="username"
                                    placeholder="Masukkan Username" value="{{ old('username') }}">
                            </div>
                            <div class="form-group">
                                <label for="hp">No. HP</label>
                                <input type="input" name="hp" class="form-control" id="hp"
                                    placeholder="Masukkan No. HP" value="{{ old('hp') }}">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="nama">Nama</label>
                                        <input type="text" name="nama" class="form-control" id="nama"
                                            placeholder="Masukkan Nama" value="{{ old('nama') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Masukkan Email" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <select class="form-control select2bs4 w-100" name="role_id" id="role_id"
                                            required>
                                            <option value="">Pilih Role</option>
                                            @foreach ($role as $item)
                                                <option value="{{ $item->id }}">{{ strtoupper($item->nama) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control select2bs4 w-100" name="jenis_kelamin"
                                            id="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            @foreach (\Helper::getEnumValues('users', 'jenis_kelamin') as $item)
                                                <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="collapse" id="f_password">
                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <div class="input-group">
                                        <input type="password" name="password" class="form-control " id="password"
                                            placeholder="Masukkan password" disabled>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="showHidePassword(event, '#password')">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="konfirmasi_password">Konfirmasi Password</label>
                                    <div class="input-group">
                                        <input type="password" name="konfirmasi_password" class="form-control "
                                            id="konfirmasi_password" placeholder="Masukkan Konfirmasi Password" disabled>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="showHidePassword(event, '#konfirmasi_password')">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <a class="btn btn-warning text-light w-100 mb-2" data-toggle="collapse" href="#f_password"
                                role="button" aria-expanded="false" aria-controls="collapsePassword"
                                onclick="showPassword()" id="collapse_password">
                                Ubah Password
                            </a>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary" id="btn_simpan_edit">Simpan</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('select:not(.normal)').each(function() {
                $(this).select2({
                    theme: 'bootstrap4',
                    dropdownParent: $(this).parent()
                });
            });

            // data table and card refresh
            var table1 = dataTable('#table1');
            $('div.dataTables_filter input', table1.table().container()).focus();

            $('#card_refresh').click(function(e) {
                table1.ajax.reload();
            });

        });
    </script>

    <script>
        $('#modal_add').on('shown.bs.modal', function() {
            $('#username_add').focus();
        })

        $('#form_add').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = "{{ route('admin.pengguna.add') }}";
            var fd = new FormData($(this)[0]);

            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn_simpan_edit').attr('disabled', true);
                },
                success: function(response) {
                    $('#modal_add').modal('toggle');
                    $('#btn_simpan_edit').attr('disabled', false);

                    swalToast(response.message, response.data);
                    cardRefresh();
                }
            });
        });

        $('#modal_edit').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var username = button.data('username');
            var email = button.data('email');
            var nama = button.data('nama');
            var role_id = button.data('role_id');
            var jenis_kelamin = button.data('jenis_kelamin');
            var hp = button.data('hp');

            var modal = $(this);
            modal.find('#title_edit').text("Edit " + username);
            modal.find('#id_edit').val(id);
            modal.find('#nama').val(nama);
            modal.find('#username').val(username);
            modal.find('#email').val(email);
            modal.find('#role_id').val(role_id).change();
            modal.find('#jenis_kelamin').val(jenis_kelamin).change();
            modal.find('#hp').val(hp);

            if (checkCollapse == false) {
                $('.collapse').collapse('hide');
                showPassword();
            }
        })

        $('#form_edit').submit(function(e) {
            e.preventDefault();

            var url = "{{ route('admin.pengguna.edit') }}";
            var fd = new FormData($('#form_edit')[0]);

            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#btn_simpan_edit').attr('disabled', true);
                },
                success: function(response) {
                    $('#modal_edit').modal('toggle');
                    $('#btn_simpan_edit').prop("disabled", false);
                    swalToast(response.message, response.data);
                    cardRefresh();
                }
            });
        });
    </script>

    <script>
        var checkCollapse = true;

        function showPassword() {
            $('#password').val('');
            $('#konfirmasi_password').val('');
            if (checkCollapse) {
                $('#password').attr("disabled", false);
                $('#konfirmasi_password').attr("disabled", false);
                checkCollapse = false;
            } else {
                $('#password').attr("disabled", true);
                $('#konfirmasi_password').attr("disabled", true);
                checkCollapse = true;
            }
        }

        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var nama = event.target.querySelector('input[name="nama"]').value;
            Swal.fire({
                title: `Yakin Ingin menghapus ${nama} ?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.pengguna.delete') }}";
                    var fd = new FormData($(event.target)[0]);

                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            swalToast(response.message, response.data);
                            cardRefresh();
                        }
                    });
                }
            })
        }

        function dataTable(id) {
            var url = "{{ route('admin.pengguna.data') }}"
            var datatable = $(id).DataTable({
                // responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    data: function(d) {
                        d.jenis = $('#filter-jenis').val();
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
                        data: 'username',
                        name: 'username',
                        className: "align-middle"
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        className: "align-middle",
                    },
                    {
                        data: 'email',
                        name: 'email',
                        className: "align-middle",
                    },
                    {
                        data: 'role_nama',
                        name: 'role_nama',
                        className: "align-middle",
                    },
                    {
                        data: 'jenis_kelamin',
                        name: 'jenis_kelamin',
                        className: "align-middle",
                    },
                    {
                        data: 'hp',
                        name: 'hp',
                        className: "align-middle",
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "align-middle",
                        'searchable': false,
                    },
                ]
            })
            datatable.buttons().container().appendTo(id + '_wrapper .col-md-6:eq(0)');
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
