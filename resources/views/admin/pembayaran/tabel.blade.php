<div class="row">
    <div class="col-12">
        <div class="card" id="card_pembayaran">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal_add_pembayaran">
                    <i class="fas fa-plus-circle mx-2"></i>Tambah Data</button>
                @if (!isset($peserta))
                    <button type="button" class="btn btn-success" data-toggle="modal"
                        data-target="#modal_add_pembayaran_s1">
                        <i class="fas fa-plus-circle mx-2"></i>Tambah Data S1</button>
                    <button type="button" class="btn btn-dark" data-toggle="modal"
                        data-target="#modal_add_pembayaran_pasca">
                        <i class="fas fa-plus-circle mx-2"></i>Tambah Data Pasca</button>
                @endif
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="card_refresh_pembayaran">
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
            <div class="card-body" id="card_body_pembayaran">
                <div class="table-responsive">
                    <table id="table_pembayaran" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tahun</th>
                                <th>Tanggal</th>
                                <th>NIM</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Prodi</th>
                                <th>Jumlah</th>
                                <th>Jenis Pembayaran</th>
                                <th>Keterangan</th>
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
