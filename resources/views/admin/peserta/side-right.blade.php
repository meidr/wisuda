<div class="card card-primary card-outline" id="card">
    <div class="card-header p-2">
        <div class="card-tools m-1">
            <button type="button" class="btn btn-tool" id="card_refresh" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card-refresh-content"
                data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
        </div>
        <ul class="nav nav-pills" id="tab_detail">
            <li class="nav-item tab_detail"><a class="nav-link active" id="nav_biodata" href="#biodata"
                    data-toggle="tab">Biodata
                    Diri</a>
            </li>
            <li class="nav-item tab_detail"><a class="nav-link" id="nav_dokumen" href="#dokumen"
                    data-toggle="tab">Dokumen</a>
            </li>
            <li class="nav-item tab_detail"><a class="nav-link" id="nav_pembayaran" href="#pembayaran"
                    data-toggle="tab">Pembayaran</a>
            </li>
            <li class="nav-item tab_detail"><a class="nav-link" id="nav_setting" href="#setting"
                    data-toggle="tab">Setting</a>
            </li>
        </ul>
    </div><!-- /.card-header -->

    <div class="card-body" id="card-refresh-content">
        <div class="tab-content">
            <div class="active tab-pane" id="biodata">
                @include('admin.peserta.side-right.biodata')
            </div>
            <div class="tab-pane" id="dokumen">
                @include('admin.peserta.side-right.dokumen')
            </div>
            <div class="tab-pane" id="pembayaran">
                @include('admin.peserta.side-right.pembayaran')
            </div>
            <div class="tab-pane" id="setting">
                @include('admin.peserta.side-right.setting')
            </div>
        </div>
        <!-- /.tab-content -->
    </div><!-- /.card-body -->
</div>
<!-- /.card -->
@push('script')
    <script>
        loadStateTab();

        var prodiDiterima = null;
        $('#tab_detail a').on('shown.bs.tab', function(e) {
            var selectedTab = $(e.target).attr('id');
            saveStateTab(`#${selectedTab}`);
        });

        $('#card_refresh').on('overlay.removed.lte.cardrefresh', function() {
            initBiodata();
            initDokumen();
            initPembayaran();
            initSetting();

            loadStateTab();
            $('.modal-backdrop.fade.show').remove();
        });

        function loadStateTab() {
            // change tab active
            $('.tab_detail a').removeClass('active');
            $('#nav_biodata').addClass('active');
            let lastTab = localStorage.getItem('lastTab');
            $(lastTab).tab('show');

            // change scrollposition
            let scrollPosition = localStorage.getItem('scrollPosition');
            scrollToPosition(scrollPosition);
        }
    </script>
@endpush
