<div class="card card-success" id="card_foto">
    <div class="card-header">
        Download Foto
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_foto" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_foto"
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
    <div class="card-body" id="card_refresh_content_foto">
        <form id="form_foto" action="{{ route('admin.acara.downloadFoto') }}" method="POST" target="_blank">
            @csrf
            <div class="form-group">
                <label for="tahun_id_foto">Tahun Akademik</label>
                <select class="form-control select2bs4 w-100" name="tahun_id" id="tahun_id_foto" required>
                    @foreach ($tahun as $item)
                        <option value="{{ $item->id }}">{{ $item->nama }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="tipe">Tipe</label>
                <select class="form-control select2bs4 w-100" name="tipe" id="tipe" required>
                    @foreach ($tipe as $item)
                        <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="jenis_kelamin_foto">Jenis Kelamin</label>
                <select class="form-control select2bs4 w-100" name="jenis_kelamin" id="jenis_kelamin_foto" required>
                    <option value="*">SEMUA JENIS KELAMIN</option>
                    @foreach (\Helper::getEnumValues('users', 'jenis_kelamin', ['*']) as $item)
                        <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="dari_foto">Dari</label>
                <input type="number" name="dari" class="form-control" id="dari_foto" placeholder="Masukkan Dari"
                    value="1" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="kelipatan_foto">Kelipatan</label>
                <input type="number" name="kelipatan" class="form-control" id="kelipatan_foto"
                    placeholder="Masukkan Kelipatan" autocomplete="off" value="5" required>
            </div>
            <div class="form-group">
                <label for="sampai_foto">Sampai</label>
                <input type="number" name="sampai" class="form-control" id="sampai_foto" placeholder="Masukkan Sampai"
                    autocomplete="off" required readonly>
                <small id="sampai_help_foto" class="text-danger d-none">*Tunggu sebentar, sedang
                    diproses</small>
            </div>
            <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-success w-100" id="form_submit_foto">
                        <i class="fas fa-plus-circle mx-2"></i>Download Foto</button>
                </div>
                <div class="col-6">
                    <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modal_foto">
                        <i class="fas fa-file mx-2"></i>Log Download Foto</button>
                </div>
            </div>
        </form>
    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

{{-- Modal Tambah --}}
<div class="modal fade" id="modal_foto" tabindex="-1" role="dialog" aria-labelledby="modal_foto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Log Download Foto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="list-group" id="log_foto"></ul>
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

            $('#card_refresh_foto').on('overlay.removed.lte.cardrefresh', function() {
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

            getPeserta();
            $('#tahun_id_foto').change(function(e) {
                getPeserta();
            });
            $('#tipe').change(function(e) {
                getPeserta();
            });
            $('#jenis_kelamin_foto').change(function(e) {
                getPeserta();
            });

            $('#form_foto').submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.acara.downloadFoto') }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        let html =
                            `<div  class="spinner-border spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>`;
                        $('#form_submit_foto').html(html);
                    },
                    error: function(data) {
                        console.log(data);
                    },
                    success: function(response) {
                        if (response.message == 500) {
                            swalToast(response.message, response.data);
                            $('#form_submit_foto').html(
                                `<i class="fas fa-plus-circle mx-2"></i>Download Foto`);
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
                        $('#log_foto').append(content);

                        let dari = parseInt($('#dari_foto').val());
                        let kelipatan = parseInt($('#kelipatan_foto').val());
                        let sampai = parseInt($('#sampai_foto').val());
                        let kelipatanSelanjutnya = dari + kelipatan;

                        if (kelipatanSelanjutnya > sampai) { // selesai
                            swalToast(response.message, response.data);
                            $('#form_submit_foto').html(
                                `<i class="fas fa-plus-circle mx-2"></i>Download Foto`);
                        }

                        if (kelipatanSelanjutnya <= sampai) {
                            $('#dari_foto').val(kelipatanSelanjutnya);
                            $('#form_submit_foto').click();
                        }
                    },
                });
            });
        }

        function getPeserta() {
            let tahun_id = $('#tahun_id_foto').val();
            let jenis_kelamin = $('#jenis_kelamin_foto').val();
            let tipe = $('#tipe').val();

            $.ajax({
                type: "GET",
                url: "{{ route('admin.setting.getPeserta') }}",
                data: {
                    'tahun_id': tahun_id,
                    'jenis_kelamin': jenis_kelamin,
                    'tipe': tipe
                },
                dataType: "json",
                beforeSend: function() {
                    $('#sampai_help_foto').removeClass('d-none');
                    $('#form_submit_foto').attr('disabled', true);
                },
                complete: function() {
                    $('#sampai_help_foto').addClass('d-none');
                    $('#form_submit_foto').attr('disabled', false);
                },
                success: function(response) {
                    if (response.status) {
                        $('#dari_foto').val(1);
                        $('#sampai_foto').val(response.data);
                    }
                }
            });
        }
    </script>
@endpush
