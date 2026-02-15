@extends('layouts.admin.template')
@section('title', 'Admin | Pembayaran Semua')
@section('css')
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6 d-flex flex-row">
                        <h1>Pembayaran</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Pembayaran
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                {{-- INFO --}}
                @include('admin.pembayaran.info')

                {{-- FILTER --}}
                @include('admin.pembayaran.filter')


                {{-- TABEL DATA --}}
                @include('admin.pembayaran.tabel')
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        @include('admin.pembayaran.pembayaran')
        @include('admin.pembayaran.sarjana')
        @include('admin.pembayaran.pasca')
    </div>
@endsection

@push('script')
    <script>
        var table1 = null;
    </script>
@endpush