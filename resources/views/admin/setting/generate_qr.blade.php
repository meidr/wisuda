<div class="card card-warning" id="card_generate_qr">
    <div class="card-header">
        Generate Qr
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_generate_qr" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_generate_qr"
                data-load-on-init="false">
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
    <div class="card-body" id="card_refresh_content_generate_qr">
        <form id="form_generate_qr" action="{{ route('admin.setting.generateQr') }}" method="POST" target="_blank">
            @csrf
            <div class="form-group">
                <label for="tahun_id_generate_qr">Tahun Akademik</label>
                <select class="form-control select2bs4 w-100" name="tahun_id" id="tahun_id_generate_qr"
                    required>
                    @foreach ($tahun as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipe_generate_qr">Tipe</label>
                <select class="form-control select2bs4 w-100" name="tipe" id="tipe_generate_qr"
                    required>
                    @foreach ($tipe as $item)
                        <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin_generate_qr">Jenis Kelamin</label>
                <select class="form-control select2bs4 w-100" name="jenis_kelamin" id="jenis_kelamin_generate_qr"
                    required>
                    <option value="*">SEMUA JENIS KELAMIN</option>
                    @foreach (\Helper::getEnumValues('users', 'jenis_kelamin', ['*']) as $item)
                        <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="dari_generate_qr">Dari</label>
                <input type="number" name="dari" class="form-control" id="dari_generate_qr"
                    placeholder="Masukkan Dari" value="1" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="kelipatan_generate_qr">Kelipatan</label>
                <input type="number" name="kelipatan" class="form-control" id="kelipatan_generate_qr"
                    placeholder="Masukkan Kelipatan" autocomplete="off" value="5" required>
            </div>
            <div class="form-group">
                <label for="sampai_generate_qr">Sampai</label>
                <input type="number" name="sampai" class="form-control" id="sampai_generate_qr"
                    placeholder="Masukkan Sampai" autocomplete="off" required readonly>
                <small id="sampai_help_generate_qr" class="text-danger d-none">*Tunggu sebentar, sedang
                    diproses</small>
            </div>
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-success w-100" id="form_submit_generate_qr">
                        <i class="fas fa-plus-circle mx-2"></i>Generate QR</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary w-100" data-toggle="modal"
                        data-target="#modal_generate_qr">
                        <i class="fas fa-file mx-2"></i>Log Generate Qr</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

{{-- Modal Tambah --}}
<div class="modal fade" id="modal_generate_qr" tabindex="-1" role="dialog" aria-labelledby="modal_generate_qr">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Log Generate Qr</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="log_generate_qr"></ul>
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
            initGenerateQr();

            $('#card_refresh_generate_qr').on('overlay.removed.lte.cardrefresh', function() {
                initGenerateQr();
            });
        });

        function initGenerateQr() {
            //Initialize Select2 Elements
            $('.select2bs4').each(function() {
                $(this).select2({
                    theme: 'bootstrap4',
                    dropdownParent: $(this).parent()
                });
            });

            getPesertaGenerateQr();
            $('#tahun_id_generate_qr').change(function(e) {
                getPesertaGenerateQr();
            });
            $('#tipe_generate_qr').change(function(e) {
                getPesertaGenerateQr();
            });
            $('#jenis_kelamin_generate_qr').change(function(e) {
                getPesertaGenerateQr();
            });

            $('#form_generate_qr').submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.setting.generateQr') }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        let html =
                            `<div  class="spinner-border spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>`;
                        $('#form_submit_generate_qr').html(html);
                    },
                    success: function(response) {
                        if (response.message == 500) {
                            swalToast(response.message, response.data);
                            $('#form_submit_generate_qr').html(
                                `<i class="fas fa-plus-circle mx-2"></i>Generate QR`);
                            return;
                        }

                        let content = `
                            <li class="list-group-item">${response.tanggal} | <b>Dari: ${response.req.dari},
                                Kelipatan: ${response.req.kelipatan},
                                Sampai: ${response.req.sampai}</b>:
                                <ol>`;

                        response.log.forEach(log => {
                            content += `
                                        <li>
                                            ${log}
                                        </li>
                                    `;
                        });
                        content += `
                                </ol>
                            </li>
                        `;
                        $('#log_generate_qr').append(content);

                        let dari = parseInt($('#dari_generate_qr').val());
                        let kelipatan = parseInt($('#kelipatan_generate_qr').val());
                        let sampai = parseInt($('#sampai_generate_qr').val());
                        let kelipatanSelanjutnya = dari + kelipatan;

                        if (kelipatanSelanjutnya > sampai) { // selesai
                            swalToast(response.message, response.data);
                            $('#form_submit_generate_qr').html(
                                `<i class="fas fa-plus-circle mx-2"></i>Generate QR`);
                        }

                        if (kelipatanSelanjutnya <= sampai) {
                            $('#dari_generate_qr').val(kelipatanSelanjutnya);
                            $('#form_submit_generate_qr').click();
                        }
                    },
                });
            });
        }

        function getPesertaGenerateQr() {
            let tahun_id = $('#tahun_id_generate_qr').val();
            let jenis_kelamin = $('#jenis_kelamin_generate_qr').val();
            let tipe = $('#tipe_generate_qr').val();

            $.ajax({
                type: "GET",
                url: "{{ route('admin.setting.getPeserta') }}",
                data: {
                    'tahun_id': tahun_id,
                    'jenis_kelamin': jenis_kelamin,
                    'tipe': tipe,
                },
                dataType: "json",
                beforeSend: function() {
                    $('#sampai_help_generate_qr').removeClass('d-none');
                    $('#form_submit_generate_qr').attr('disabled', true);
                },
                complete: function() {
                    $('#sampai_help_generate_qr').addClass('d-none');
                    $('#form_submit_generate_qr').attr('disabled', false);
                },
                success: function(response) {
                    if (response.status) {
                        $('#dari_generate_qr').val(1);
                        $('#sampai_generate_qr').val(response.data);
                    }
                }
            });
        }
    </script>
@endpush
