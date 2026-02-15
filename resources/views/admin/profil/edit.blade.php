@extends('layouts.admin.template')
@section('title', 'Admin | Edit Profil')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('/admin/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Profil</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.profil') }}">Profil</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Profil</h3>
                        <div class="card-tools">
                            <!-- Maximize Button -->
                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                    class="fas fa-expand"></i></button>
                        </div>
                    </div>
                    <!-- form start -->
                    <form id="quickForm" action="{{ route('admin.profil.edit.proses') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="input" name="nama" class="form-control" id="nama"
                                    placeholder="Masukkan nama" value="{{ auth()->user()->nama }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                    placeholder="Enter email" value="{{ auth()->user()->email }}">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <input type="input" name="role" class="form-control" id="role"
                                    placeholder="Masukkan Role" value="{{ auth()->user()->role->nama }}" disabled>
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
                                        <input type="password" name="konfirmasi_password" class="form-control"
                                            id="konfirmasi_password" placeholder="Masukkan ulang password" disabled>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="showHidePassword(event, '#konfirmasi_password')">
                                            <i class="fa fa-eye-slash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <a class="btn btn-warning text-light w-100 mb-2" data-toggle="collapse" href="#f_password"
                                role="button" aria-expanded="false" aria-controls="collapseExample"
                                onclick="showPassword()">
                                Ubah Password
                            </a>
                            <button type="submit" class="btn btn-primary w-100">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->

                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

@section('script')
    <!-- jquery-validation -->
    <script src="{{ asset('/admin/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('/admin/plugins/jquery-validation/additional-methods.min.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- daterange picker -->
    <script src="{{ asset('/admin/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('/admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <!-- InputMask -->
    <script src="{{ asset('/admin/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
    <script>
        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'DD-MM-yyyy'
        });
        //phone mask
        $('[data-mask]').inputmask()

        //add name to fileinput
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    </script>

    <script>
        $(function() {
            $.validator.setDefaults({
                submitHandler: function() {
                    submit();
                }
            });
            $('#quickForm').validate({
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
        });
    </script>

    <script>
        var checkCollapse = true;

        function showPassword() {
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
    </script>
@endsection
