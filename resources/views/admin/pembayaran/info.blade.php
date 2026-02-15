<div class="row">
    <div class="col-12 col-md-3">
        <div class="info-box" data-toggle="modal" data-target="#modal_detail" style="cursor: pointer">
            <span class="info-box-icon bg-info"><i class="fas fa-money-bill"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Hari ini<span class="text-muted"> *Klik</span></span>
                <span class="info-box-number" id="hari_ini"></span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fas fa-money-bill"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Harus diterima</span>
                <span class="info-box-number" id="harus_diterima">Loading...</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fas fa-money-bill"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Telah diterima</span>
                <span class="info-box-number" id="telah_diterima">Loading...</span>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-3">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fas fa-money-bill"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Belum diterima</span>
                <span class="info-box-number" id="belum_diterima">Loading...</span>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="modal_add">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Pembayaran</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-3">Banin</div>
                    <div class="col-9 font-weight-bold">: <span id="hari_ini_banin"></span></div>
                </div>
                <div class="row">
                    <div class="col-3">Banat</div>
                    <div class="col-9 font-weight-bold">: <span id="hari_ini_banat"></span> </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-3">TOTAL</div>
                    <div class="col-9 font-weight-bold">: <span id="hari_ini_total"></span></div>
                </div>
            </div>
            <div class="modal-footer justify-content-end">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            changeInfo();
        });

        function changeInfo() {
            $.ajax({
                type: "GET",
                url: "{{ route('admin.pembayaran.dataInfo') }}",
                data: {
                    tahun: $('#filter_tahun').val(),
                    prodi_id: $('#filter_prodi_id').val(),
                    tanggal: $('#filter_tanggal').val(),
                    range_tanggal: $('#filter_range_tanggal').val(),
                    jenis_kelamin: $('#filter_jenis_kelamin').val(),
                },
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (!response.status) {
                        return;
                    }

                    let data = response.data;
                    $('#hari_ini').html(doubleToIdr(data.pembayaranHariIni));
                    $('#hari_ini_banin').html(doubleToIdr(data.pembayaranHariIniBanin));
                    $('#hari_ini_banat').html(doubleToIdr(data.pembayaranHariIniBanat));
                    $('#hari_ini_total').html(doubleToIdr(data.pembayaranHariIni));
                    $('#harus_diterima').html(doubleToIdr(data.harusDiterima));
                    $('#belum_diterima').html(doubleToIdr(data.belumDiterima));
                    $('#telah_diterima').html(doubleToIdr(data.telahDiterima));
                }
            });
        }
    </script>
@endpush
