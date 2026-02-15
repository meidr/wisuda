@push('css')
    <style>
        .biodata input[readonly],
        .biodata textarea[readonly] {
            background-color: #f8f9fa !important;
        }

        .biodata .select2-container--disabled .select2-selection__rendered {
            background-color: #f8f9fa !important;
        }
    </style>
@endpush
<form class="form-horizontal biodata" id="form-biodata" method="POST" action="#"">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <label for="username" class="col-sm-3 col-form-label">Username</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="username" name="username" value="{{ @$peserta->user->username }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="nim" class="col-sm-3 col-form-label">NIM</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nim" name="nim" value="{{ $peserta->nim }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="nama" class="col-sm-3 col-form-label">Nama</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama" name="nama" value="{{ $peserta->nama }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="prodi_id" class="col-sm-3 col-form-label">Prodi</label>
        <div class="col-sm-9">
            <select class="form-control select2bs4 w-100" id="prodi_id" name="prodi_id" disabled>
                @foreach ($prodi as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $peserta->prodi_id ? 'selected' : '' }}>
                        {{ strtoupper($item->nama) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="nama_ayah" class="col-sm-3 col-form-label">Nama Ayah</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama_ayah" name="nama_ayah" value="{{ $peserta->nama_ayah }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="judul" class="col-sm-3 col-form-label">Judul</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="judul" name="judul" value="{{ $peserta->judul }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="tanggal_sidang" class="col-sm-3 col-form-label">Tanggal Sidang</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" id="tanggal_sidang" name="tanggal_sidang" value="{{ $peserta->tanggal_sidang }}"
                readonly>
        </div>
    </div>
    {{-- <div class="form-group row">
        <label for="nama_arab" class="col-sm-3 col-form-label">Nama Arab</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nama_arab" name="nama_arab" value="{{ $peserta->nama_arab }}"
                readonly>
        </div>
    </div> --}}
    <div class="form-group row">
        <label for="tanggal_daftar" class="col-sm-3 col-form-label">Tanggal Daftar</label>
        <div class="col-sm-9">
            <input type="date" class="form-control" id="tanggal_daftar" name="tanggal_daftar"
                value="{{ $peserta->tanggal_daftar }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="tempat_lahir" class="col-sm-3 col-form-label">Tempat Lahir</label>
        <div class="col-sm-3">
            <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                value="{{ $peserta->tempat_lahir }}" readonly>
        </div>
        <label for="tanggal_lahir" class="col-sm-3 col-form-label">Tanggal Lahir</label>
        <div class="col-sm-3">
            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                value="{{ $peserta->tanggal_lahir }}" readonly />
        </div>
    </div>
    <div class="form-group row">
        <label for="nomor_hp" class="col-sm-3 col-form-label">Nomor HP/WA</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nomor_hp" name="nomor_hp" value="{{ $peserta->nomor_hp }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="jenis_kelamin" class="col-sm-3 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-9">
            <select class="form-control select2bs4 w-100" id="jenis_kelamin" name="jenis_kelamin" disabled>
                @foreach (BulkData::jenisKelamin as $item)
                    <option value="{{ $item }}" {{ $item == $peserta->user->jenis_kelamin ? 'selected' : '' }}>
                        {{ strtoupper($item) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="tipe_identitas" class="col-sm-3 col-form-label">Tipe Identitas</label>
        <div class="col-sm-9">
            <select class="form-control select2bs4 w-100" id="tipe_identitas" name="tipe_identitas" disabled>
                @foreach (Helper::getEnumValues('peserta', 'tipe_identitas') as $item)
                    <option value="{{ $item }}" {{ $item == $peserta->tipe_identitas ? 'selected' : '' }}>
                        {{ strtoupper($item) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label for="nomor_identitas" class="col-sm-3 col-form-label">Nomor Identitas</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="nomor_identitas" name="nomor_identitas"
                value="{{ $peserta->nomor_identitas }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="propinsi" class="col-sm-3 col-form-label">Propinsi</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="propinsi" name="propinsi"
                value="{{ $peserta->propinsi }}" readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="kota" class="col-sm-3 col-form-label">Kota</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="kota" name="kota" value="{{ $peserta->kota }}"
                readonly>
        </div>
    </div>
    <div class="form-group row">
        <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
        <div class="col-sm-9">
            <textarea class="form-control" name="alamat" id="alamat" rows="3" readonly>{{ $peserta->alamat }}</textarea>
        </div>
    </div>
    <div class="form-group row">
        <label for="status_id" class="col-sm-3 col-form-label">Status</label>
        <div class="col-sm-9">
            <select class="form-control select2bs4 w-100" id="status_id" name="status_id" disabled>
                @foreach ($status as $item)
                    <option value="{{ $item->id }}" {{ $item->id == $peserta->status_id ? 'selected' : '' }}>
                        {{ strtoupper($item->nama) }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group row">
        <div class="offset-sm-3 col-sm-9">
            <button type="button" class="btn btn-primary mr-3" id="button_edit_biodata">Edit Data</button>
            <button type="button" class="btn btn-danger mr-3 d-none" id="button_cancel_biodata">Batal</button>
            <button type="submit" class="btn btn-success mr-3 d-none" id="button_submit_biodata">Simpan</button>
        </div>
    </div>
</form>

@push('script')
    <script>
        initBiodata();

        function initBiodata() {

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        
            $('#button_edit_biodata').click(function(e) {
                $('#button_edit_biodata').prop('disabled', true);
                $('.biodata input[readonly]').removeAttr('readonly');
                $('.biodata textarea[readonly]').removeAttr('readonly');
                $('.biodata .select2bs4').prop('disabled', false).trigger('change');
                $('#button_cancel_biodata').removeClass("d-none");
                $('#button_submit_biodata').removeClass("d-none");
            });

            $('#button_cancel_biodata').click(function(e) {
                $('#button_edit_biodata').prop('disabled', false);
                $('.biodata input').prop('readonly', true);
                $('.biodata textarea').prop('readonly', true);
                $('.biodata .select2bs4').prop('disabled', true).trigger('change');
                $('#button_cancel_biodata').addClass("d-none");
                $('#button_submit_biodata').addClass("d-none");
            });

            $('#form-biodata').submit(function(e) {
                // e.preventDefault();
                let html = `<div class="d-flex align-items-center">
                        <strong>Proses..</strong>
                        <div class="spinner-border spinner-border-sm ml-auto" role="status_id" aria-hidden="true"></div>
                        </div>`;
                $('#button_cancel_biodata').prop("disabled", true);
                $('#button_submit_biodata').prop("disabled", true);
                $('#button_submit_biodata').html(html);
                // this.submit();
                e.preventDefault();
                let fd = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ url()->current() }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        swalToast(response.message, response.data);
                        cardRefresh();
                        saveStateTab('#nav_biodata');
                    }
                });
            });
        }
    </script>
@endpush
