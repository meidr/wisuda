<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Jumlah</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_jumlah" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_jumlah"
                data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
            </button>
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

    <div class="card-body" id="card_refresh_content_jumlah">
        <div class="callout callout-info">
            <p>Jumlah {{ $tahunPelajaranAdmin }}</p>
        </div>
        @foreach ($dataProdi['jumlah'] as $strata => $jenisKelamin)
            @foreach ($jenisKelamin as $jenis => $jumlah)
                <div class="info-box">
                    <span class="info-box-icon bg-{{ $prodiColor[$strata] }}"><i class="far fa-star"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text"><strong>{{ $strata }} - {{ strtoupper($jenis) }}
                            </strong></span>
                        <span class="info-box-number">{{ $jumlah }}</span>
                    </div>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
