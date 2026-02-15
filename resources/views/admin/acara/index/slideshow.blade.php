<div class="row">
    <div class="col-12">
        <div class="card card-outline card-danger">
            <div class="card-header">
                SlideShow
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" id="card_refresh_ss" data-card-widget="card-refresh"
                        data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_ss"
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
            <div class="card-body" id="card_refresh_content_ss">
                <form id="form_ss" action="{{ route('admin.acara.slideshow') }}" method="GET" target="_blank">
                    <div class="form-group">
                        <label for="tahun_id_ss">Tahun Akademik</label>
                        <select class="form-control select2bs4 w-100" name="tahun_id" id="tahun_id_ss"
                            required>
                            @foreach ($tahun as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin_ss">Jenis Kelamin</label>
                        <select class="form-control select2bs4 w-100" name="jenis_kelamin" id="jenis_kelamin_ss" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            @foreach (\Helper::getEnumValues('users', 'jenis_kelamin', ['*']) as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button class="btn btn-danger w-100" type="submit">Mulai SlideShow</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
</div>
