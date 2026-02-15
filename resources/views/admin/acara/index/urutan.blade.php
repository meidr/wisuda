<div class="row">
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                Urutan
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="card_refresh_urutan" data-card-widget="card-refresh"
                        data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_urutan"
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
            <div class="card-body" id="card_refresh_content_urutan">
                <form id="form_urutan" action="{{ route('admin.acara.storeUrutan') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="tahun_id_urutan">Tahun Akademik</label>
                        <select class="form-control select2bs4 w-100" name="tahun_id" id="tahun_id_urutan" required>
                            @foreach ($tahun as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin_urutan">Jenis Kelamin</label>
                        <select class="form-control select2bs4 w-100" name="jenis_kelamin" id="jenis_kelamin_urutan"
                            required>
                            <option value="">Pilih Jenis Kelamin</option>
                            @foreach (\Helper::getEnumValues('users', 'jenis_kelamin', ['*']) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="file_excel">File Excel: </label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" accept=".xlsx, .xls" id="file_excel"
                                    name="file_excel" required>
                                <label class="custom-file-label" for="file_excel" id="sk_label">Pilih File</label>
                            </div>
                        </div>
                        <small>File harus berekstensi .xlsx, .xls"</small>
                    </div>
                    <button class="btn btn-primary w-100" type="submit">Mulai Urutan</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>

@push('script')
    <script>
        initUrutan();
        $(document).ready(function() {
            $('#card_refresh_urutan').on('overlay.removed.lte.cardrefresh', function() {
                initUrutan();
            });
        });

        function initUrutan() {
            bsCustomFileInput.init();

            // $('#form_urutan').submit(function(e) {
            //     e.preventDefault();
            //     $.ajax({
            //         type: "POST",
            //         url: $(this).attr('action'),
            //         data: new FormData(this),
            //         processData: false,
            //         contentType: false,
            //         dataType: "json",
            //         beforeSend: function() {
            //             $(e.currentTarget).find('button[type="submit"]').attr(
            //                 'disabled', true);
            //         },
            //         complete: function() {
            //             $(e.currentTarget).find('button[type="submit"]').attr(
            //                 'disabled', false);
            //         },
            //         success: function(response) {
            //             swalToast(response.message, response.data);
            //         }
            //     });
            // });
        }
    </script>
@endpush
