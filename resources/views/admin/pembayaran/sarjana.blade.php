{{-- Modal Tambah --}}
<form action="" id="form_add_pembayaran_s1" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="modal fade" id="modal_add_pembayaran_s1" tabindex="-1" role="dialog"
        aria-labelledby="modal_add_pembayaran_s1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pembayaran S1</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search">Cari</label>
                        <div class="input-group">
                            <input type="input" name="search" class="form-control" id="search_s1"
                                placeholder="Masukkan NIM / Nama" value="{{ old('search') }}" onfocus="this.select();">
                            <button type="button" class="btn btn-primary" id="search_btn_s1" style="cursor: pointer"
                                onclick="cekPesertaS1('#modal_add_pembayaran_s1', '#search_s1','#nim_s1', '#nama_s1', '#nama_ayah_s1',
                                '#judul_s1','#tanggal_sidang_s1','#jenis_kelamin_s1',
                                '#prodi_s1', '#tahun_s1', '#jenis_pembayaran_s1', '#jumlah_s1', '#ukuran_baju_s1', '#keterangan_s1', '#form_submit_s1' )" />
                            <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nim_s1">NIM</label>
                                <input type="input" name="nim" class="form-control" id="nim_s1" disabled
                                    required placeholder="Masukkan NIM" value="{{ old('nim_s1') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_s1">Nama</label>
                                <input type="input" name="nama" class="form-control" id="nama_s1" disabled
                                    required placeholder="Masukkan Nama" value="{{ old('nama_s1') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_ayah_s1">Nama Ayah <span class="text-warning">*Bisa dikosongi</span></label>
                        <input type="input" name="nama_ayah" class="form-control" id="nama_ayah_s1" disabled
                            placeholder="Masukkan Nama Ayah" value="{{ old('nama_ayah_s1') }}">
                    </div>
                    <div class="form-group">
                        <label for="judul_s1">Judul <span class="text-warning">*Bisa dikosongi</span></label>
                        <input type="input" name="judul" class="form-control" id="judul_s1" disabled
                            placeholder="Masukkan Judul" value="{{ old('judul_s1') }}">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_sidang_s1">Tanggal Sidang <span class="text-warning">*Bisa
                                dikosongi</span></label>
                        <input type="date" name="tanggal_sidang" class="form-control" id="tanggal_sidang_s1" disabled
                            placeholder="Masukkan Tanggal Sidang" value="{{ old('tanggal_sidang_s1') }}">
                    </div>
                    <div class="form-group">
                        <label for="tahun_s1">Tahun</label>
                        <select class="form-control select2bs4 w-100" id="tahun_s1" name="tahun_id" disabled required>
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahun as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin_s1">Jenis Kelamin</label>
                        <select class="form-control select2bs4 w-100" id="jenis_kelamin_s1" name="jenis_kelamin"
                            disabled required>
                            <option value="">Pilih Tahun Terlebih Dahulu</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prodi_s1">Prodi</label>
                        <select class="form-control select2bs4 w-100" id="prodi_s1" name="prodi_id" disabled required>
                            <option value="">Pilih Prodi</option>
                            @foreach ($prodiS1 as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_s1">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" id="jumlah_s1"
                            placeholder="Masukkan Jumlah yang Dibayar" value="{{ old('jumlah_s1') }}"
                            onkeyup="formatRupiah(this.value,'#jumlahS1Help')" onfocus="this.select();" disabled
                            required>
                        <small id="jumlahS1Help" class="form-text text-muted">Rp.</small>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pembayaran_s1">Jenis Pembayaran</label>
                        <select class="form-control select2bs4 w-100" id="jenis_pembayaran_s1"
                            name="jenis_pembayaran" disabled required>
                            <option value="">Pilih Jenis Pembayaran</option>
                            @foreach (\Helper::getEnumValues('pembayaran', 'jenis_pembayaran') as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ukuran_baju_s1">Ukuran Baju <span class="text-warning">*Bisa
                                dikosongi</span></label>
                        <select class="form-control select2bs4 w-100" id="ukuran_baju_s1" name="ukuran_baju"
                            disabled>
                            <option value="">Pilih Ukuran Baju</option>
                            @foreach (\Helper::getEnumValues('peserta', 'ukuran_baju') as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_s1">Keterangan <span class="text-warning">*Bisa
                                dikosongi</span></label>
                        <textarea name="keterangan" rows="3" class="form-control" id="keterangan_s1" disabled
                            placeholder="Masukkan Keterangan"></textarea>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="form_submit_s1" disabled>Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
@push('script')
    <script>
        var jenisKelamin = null;
        $(document).ready(function() {
            //autocomplete s1
            $("#search_s1").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "get",
                        data: {
                            term: request.term,
                            tipe: 'sarjana'
                        },
                        url: "{{ route('operasi.peserta.autocomplete') }}",
                        success: function(data) {
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    var valItem = ui.item.value;

                    valItem = valItem.split('-');
                    valItem = valItem[0].substr(0, valItem[0].length - 1);
                    $('#search_s1').val(valItem);
                    document.getElementById('search_btn_s1').click();
                    return false; // make #search can edit
                }
            });
        });

        $('#modal_add_pembayaran_s1').on('shown.bs.modal', function() {
            $('#search_s1').focus();
        })

        $('#form_add_pembayaran_s1').submit(function(e) {
            e.preventDefault();
            let fd = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.pembayaran.registrasi') }}",
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#form_submit_s1').attr('disabled', true);
                    $('#form_submit_s1').text('Loading...');
                },
                success: function(response) {
                    $('#modal_add_pembayaran_s1').modal('hide');
                    swalToast(response.message, response.data);
                    $('#search_s1').val('');
                    $('#search_btn_s1').click();
                    cardRefresh();
                },
                complete: function() {
                    $('#form_submit_s1').attr('disabled', false);
                    $('#form_submit_s1').text('Simpan');
                }
            });
        });

        $('#tahun_s1').change(function(e) {
            setJenisKelaminS1();
        });

        function setJenisKelaminS1() {
            $.ajax({
                type: "GET",
                url: "{{ route('operasi.kuota.getData') }}",
                data: {
                    tahun_id: $('#tahun_s1').val(),
                    jenjang: 'S1',
                },
                dataType: "json",
                beforeSend: function() {
                    $('#jenis_kelamin_s1').empty();
                    $('#jenis_kelamin_s1').append('<option value="">Loading...</option>');
                },
                success: function(response) {
                    if (!response.status) {
                        $('#jenis_kelamin_s1').empty();
                        $('#jenis_kelamin_s1').append('<option value="">Pilih Tahun Terlebih Dahulu</option>');
                    }

                    if (response.status) {
                        $('#jenis_kelamin_s1').empty();
                        $('#jenis_kelamin_s1').append('<option value="">Siap dipilih..</option>');
                        response.data.forEach(kuota => {
                            $('#jenis_kelamin_s1').append(`
                                <option value="${kuota.jenis}_${kuota.kuota}" ${kuota.jenis == jenisKelamin ? 'selected' : ''}>${kuota.jenis} (${kuota.kuota})</option>
                            `);
                        });
                    }
                }
            });
        }


        function cekPesertaS1(eModal, eSearch, eNim, eNama, eNamaAyah, eJudul, eTanggalSidang, eJenisKelamin, eProdi,
            eTahun,
            eJenisPembayaran, eJumlah, eUkuranBaju, eKeterangan, eFormSubmit) {

            $(eNim).attr('disabled', true);
            $(eNama).attr('disabled', true);
            $(eNamaAyah).attr('disabled', true);
            $(eJudul).attr('disabled', true);
            $(eTanggalSidang).attr('disabled', true);
            $(eJenisKelamin).prop('disabled', true).trigger('change');
            $(eProdi).prop('disabled', true).trigger('change');
            $(eTahun).prop('disabled', true).trigger('change');
            $(eJenisPembayaran).prop('disabled', true).trigger('change');
            $(eUkuranBaju).prop('disabled', true).trigger('change');
            $(eJumlah).attr('disabled', true);
            $(eKeterangan).attr('disabled', true);
            $(eFormSubmit).attr('disabled', true);

            $.ajax({
                type: "POST",
                url: "{{ route('operasi.peserta.getData') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: $(eSearch).val(),
                    tipe: 'sarjana'
                },
                beforeSend: function() {
                    $(`${eModal} .overlay`).remove();
                    var div = '<div class="overlay bkg-white">' +
                        '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                        '</div>';
                    $(`${eModal} .modal-header`).append(div);
                },
                success: function(response) {
                    let data = response.data;
                    jenisKelamin = data?.user?.jenis_kelamin ?? null;

                    if (response.code == 403) {
                        $(eNim).val('');
                        $(eNama).val('');
                        $(eNamaAyah).val('');
                        $(eJudul).val('');
                        $(eTanggalSidang).val('');
                        $(eJenisKelamin).val('').change();
                        $(eTahun).val('').change();
                        $(eProdi).val('').change();
                        $(eUkuranBaju).val('').change();
                        swalToast(500, response.data);
                        return;
                    }

                    $(eNim).removeAttr('disabled');
                    $(eNama).removeAttr('disabled');
                    $(eNamaAyah).removeAttr('disabled');
                    $(eJudul).removeAttr('disabled');
                    $(eTanggalSidang).removeAttr('disabled');
                    $(eJenisKelamin).prop('disabled', false).trigger('change');
                    $(eProdi).prop('disabled', false).trigger('change');
                    $(eTahun).prop('disabled', false).trigger('change');
                    $(eJenisPembayaran).prop('disabled', false).trigger('change');
                    $(eUkuranBaju).prop('disabled', false).trigger('change');
                    $(eJumlah).removeAttr('disabled');
                    $(eKeterangan).removeAttr('disabled');
                    $(eFormSubmit).removeAttr('disabled');

                    if (response.status == false) {
                        $(eNim).val('');
                        $(eNama).val('');
                        $(eNamaAyah).val('');
                        $(eJudul).val('');
                        $(eTanggalSidang).val('');
                        $(eJenisKelamin).val('').change();
                        $(eTahun).val('').change();
                        $(eProdi).val('').change();
                        $(eUkuranBaju).val('').change();
                        return;
                    }

                    // cek pasca atau sarjana
                    if (data.prodi.jenjang != "S1") {
                        swalToast(500, 'Bukan mahasiswa S1');
                        $(eNim).prop('disabled', true);
                        $(eNama).prop('disabled', true);
                        $(eNamaAyah).prop('disabled', true);
                        $(eJudul).prop('disabled', true);
                        $(eTanggalSidang).prop('disabled', true);
                        $(eJenisKelamin).prop('disabled', true).trigger('change');
                        $(eProdi).prop('disabled', true).trigger('change');
                        $(eTahun).prop('disabled', true).trigger('change');
                        $(eJenisPembayaran).prop('disabled', true).trigger('change');
                        $(eJumlah).prop('disabled', true);
                        $(eUkuranBaju).prop('disabled', true).trigger('change');
                        $(eKeterangan).prop('disabled', true);
                        $(eFormSubmit).prop('disabled', true);

                        $(eNim).val('');
                        $(eNama).val('');
                        $(eNamaAyah).val('');
                        $(eJudul).val('');
                        $(eTanggalSidang).val('');
                        $(eJenisKelamin).val('').change();
                        $(eTahun).val('').change();
                        $(eProdi).val('').change();
                        $(eUkuranBaju).val('').change();
                        return;
                    }

                    $(eNim).val(data.nim);
                    $(eNama).val(data.nama);
                    $(eNamaAyah).val(data.nama_ayah);
                    $(eJudul).val(data.judul);
                    $(eTanggalSidang).val(data.tanggal_sidang);
                    $(eTahun).val(data.tahun?.id).change();
                    $(eProdi).val(data.prodi?.id).change();
                    $(eUkuranBaju).val(data.ukuran_baju).change();
                },
                complete: function(response) {
                    $(`${eModal} .overlay`).remove();
                }
            });
        }
    </script>
@endpush
