<!-- Profile Image -->
<div class="card card-primary card-outline">
    <button type="button" class="btn btn-tool d-none" id="card_refresh_left_side_acc" data-card-widget="card-refresh"
        data-source="{{ url()->current() }}" data-source-selector="#card-refresh-content-left-side-acc"
        data-load-on-init="false">
        <i class="fas fa-sync-alt"></i>
    </button>
    <div class="card-body box-profile" id="card-refresh-content-left-side-acc">
        <div class="text-center">
            @if (@$foto->path)
                <img src="{{ \App\Http\Services\GoogleDrive::showImage($foto->path) }}"
                    style="width: 100px;height:100px;object-fit: cover" class="profile-user-img img-fluid img-circle"
                    alt="User Image">
            @else
                <img src="{{ asset('/img/logo uii dalwa.png') }}" class="profile-user-img img-fluid img-circle"
                    alt="User Image">
            @endif
        </div>

        <h3 class="profile-username text-center">{{ @$peserta->nama }}</h3>
        <div class="text-center"><span class="badge badge-{{ @$peserta->status->warna }}">{{ @$peserta->status->nama }}</span></div>
        <ul class="list-group list-group-unbordered my-3">
            <li class="list-group-item">
                <b>Username</b> <a class="float-right">{{ @$peserta->user->username }}</a>
            </li>
            <li class="list-group-item">
                <b>Tanggal Daftar</b> <a
                    class="float-right">{{ date('d M Y', strtotime(@$peserta->tanggal_daftar)) }}</a>
            </li>
            <li class="list-group-item">
                <b>Program</b> <a class="float-right">{{ @$peserta->getProdi->alias }}</a>
            </li>
        </ul>
        <button class="btn btn-primary btn-block" id="button_terverifikasi"><i class="fas fa-edit mr-1"></i> Ganti
            Terverifikasi</button>
        <a href="{{ route('peserta.formulir.cetak', ['idPeserta' => @$peserta->id, 'noUnik' => @$peserta->user->no_unik]) }}"
            class="btn btn-secondary btn-block" target="_blank"><b><i class="fas fa-print mr-1"></i> Cetak
                Formulir</b></a>
    </div>
</div>
<!-- /.card -->

@push('script')
    <script>
        initSideLeft();
        $('#card_refresh_left_side_acc').on('overlay.removed.lte.cardrefresh', function() {
            initSideLeft();
        });

        function initSideLeft() {
            $('#button_terverifikasi').click(function(e) {
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.peserta.updateStatusTerverifikasi', ['peserta' => $peserta]) }}",
                    data: {
                        '_token': "{{ csrf_token() }}",
                        '_method': 'PUT'
                    },
                    dataType: "json",
                    beforeSend: function() {
                        $('#button_terverifikasi').html('loading...');
                        $('#button_terverifikasi').attr('disabled', true);
                    },
                    complete: function() {
                        $('#button_terverifikasi').html(
                            `<i class="fas fa-edit mr-1"></i> Ganti Terverifikasi`);
                        $('#button_terverifikasi').attr('disabled', false);
                    },
                    success: function(response) {
                        swalToast(response.message, response.data);
                        cardRefresh();
                    }
                });
            });
        }
    </script>
@endpush
