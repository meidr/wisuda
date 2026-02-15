<div class="card card-success">
    <div class="card-header">
        <h3 class="card-title">Rekap</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_rekap" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_rekap"
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

    <div class="card-body" id="card_refresh_content_rekap">
        <div class="w-100 text-bold mb-2 text-center">- {{ $tahunPelajaranAdmin }} -</div>
        <table id="table1" class="table table-bordered table-hover table-responsive-sm">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Prodi</th>
                    <th>Banin</th>
                    <th>Banat</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($dataProdi['data'] as $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->prodi }}</td>
                        <td>{{ $item->terisi_banin }}</td>
                        <td>{{ $item->terisi_banat }}</td>
                        <td>{{ $item->terisi_banat + $item->terisi_banin }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
           initRekap();
           $('#card_refresh_rekap').on('overlay.removed.lte.cardrefresh', function() {
                initRekap();
            });
        });

        function initRekap(){
            $("#table1").DataTable({
                "buttons": ["excel", "pdf", "colvis"]
            }).buttons().container().appendTo('#table1_wrapper .col-md-6:eq(0)');
        }
    </script>
@endpush
