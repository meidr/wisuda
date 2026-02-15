@extends('layouts.admin.template')
@section('title', 'Admin | Profil')
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Profil</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Profil</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (Session::has('message'))
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Success</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! Session::get('message') !!}
                        </div>
                    </div>
                @endif
                @if (Session::has('failed'))
                    <div class="card card-danger">
                        <div class="card-header">
                            <h3 class="card-title">Failed</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                                        class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            {!! Session::get('failed') !!}
                        </div>
                    </div>
                @endif
                <div class="card card-primary card-outline">
                    <div class="card-header">
                        <a href="{{ route('admin.profil.edit') }}" class="btn btn-primary">Update Profil</a>
                        <a href="{{ route('admin.profil.upload') }}" class="btn btn-primary">Upload Foto Profil</a>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fas fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.card-tools -->
                    </div>
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle" src="{{ asset("/foto/$foto") }}"
                                style="width: 100px;height:100px;object-fit:cover" alt="User profile picture">
                        </div>

                        <h3 class="profile-username text-center">{{ auth()->user()->name }}</h3>

                        <p class="text-muted text-center mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-primary text-center">
                        {{ auth()->user()->role->nama }}
                    </div>
                    <!-- About Me Box -->
                    <div class="card card-primary mt-3">
                        <div class="card-header">
                            <h3 class="card-title">Detail</h3>
                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                    <i class="fas fa-expand"></i>
                                </button>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong>Nama</strong>
                            <p class="text-muted">{{ auth()->user()->nama }}</p>
                            <hr>
                            <strong>Email</strong>
                            <p class="text-muted">{{ auth()->user()->email }}</p>
                            <hr>
                            <strong>Role</strong>
                            <p class="text-muted">{{ auth()->user()->role->nama }}</p>
                            <hr>

                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
