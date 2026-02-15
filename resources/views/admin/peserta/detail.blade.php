@extends('layouts.admin.template')
@section('title', 'Admin | Dashboard')
@section('css')
    <style>
        input[readonly],
        textarea[readonly] {
            background-color: #f8f9fa !important;
        }

        .select2-container--disabled .select2-selection__rendered {
            background-color: #f8f9fa !important;
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
                        <h1>Detail</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item active">/ Peserta
                            </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (Session::has('tipe'))
                    <div class="alert alert-{{ Session::get('status') }} alert-dismissible fade show" role="alert">
                        {{ Session::get('message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="row">
                    <div class="col-md-3">
                        @include('admin.peserta.side-left')
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9" id="sideright">
                        @include('admin.peserta.side-right')
                    </div>
                    <!-- /.col -->
                </div>
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>

@endsection

@push('script')
    <script>
        function deleteDataPembayaran(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var nominal = event.target.querySelector('input[name="nominal"]').value;
            var tanggal = event.target.querySelector('input[name="tanggal"]').value;
            Swal.fire({
                title: `Yakin Ingin menghapus pembayaran dengan nominal: ${nominal} tanggal: ${tanggal}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.peserta') }}/detail/{{ $peserta->id }}/deletePembayaran";
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
                            console.log(response);
                        }
                    });
                }
            })
        }

        function cardRefresh() {
            var cardRefresh = document.querySelector('#card_refresh');
            cardRefresh.click();
            var cardRefreshLeftSideAcc = document.querySelector('#card_refresh_left_side_acc');
            cardRefreshLeftSideAcc.click();
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
