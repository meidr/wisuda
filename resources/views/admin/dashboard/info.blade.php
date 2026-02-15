<div class="col-md-12 col-sm-12 col-12">
    <div class="card card-success">
        <div class="card-header">
            <h3 class="card-title">Informasi</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="maximize">
                    <i class="fas fa-expand"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="info-box">
                @php
                    $foto = auth()->user()->foto != null ? asset('/foto/' . auth()->user()->foto) : asset('/img/logo uii dalwa.png');
                @endphp
                <span class="info-box-icon"><img src="{{ $foto }}" width="200" alt=""></span>
                <div class="info-box-content">
                    <span class="info-box-text">Selamat Datang di Sistem Informasi Wisuda
                        Universitas Islam Internasion Darullughah Wadda'wah,</span>
                    <span class="info-box-text">anda masuk dengan akun
                        <b>{{ auth()->user()['nama'] }}</b></span>
                </div>
            </div>
        </div>
    </div>
</div>
