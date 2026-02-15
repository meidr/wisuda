{{-- Modal Tambah --}}
<form action="" id="form_add_pembayaran_pasca" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="modal fade" id="modal_add_pembayaran_pasca" tabindex="-1" role="dialog"
        aria-labelledby="modal_add_pembayaran_pasca">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pembayaran Pasca</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="search">Cari</label>
                        <div class="input-group">
                            <input type="input" name="search" class="form-control" id="search_pasca"
                                placeholder="Masukkan NIM / Nama" value="{{ old('search') }}" onfocus="this.select();">
                            <button type="button" class="btn btn-primary" id="search_btn_pasca" style="cursor: pointer"
                                onclick="cekPesertaPasca('#modal_add_pembayaran_pasca', '#search_pasca','#nim_pasca', '#nama_pasca', '#nama_ayah_pasca',
                                '#judul_pasca','#tanggal_sidang_pasca', '#jenis_kelamin_pasca',
                                '#prodi_pasca', '#tahun_pasca', '#jenis_pembayaran_pasca', '#jumlah_pasca', '#ukuran_baju_pasca','#keterangan_pasca', '#form_submit_pasca' )" />
                            <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nim_pasca">NIM</label>
                                <input type="input" name="nim" class="form-control" id="nim_pasca" disabled
                                    required placeholder="Masukkan NIM" value="{{ old('nim_pasca') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_pasca">Nama</label>
                                <input type="input" name="nama" class="form-control" id="nama_pasca" disabled
                                    required placeholder="Masukkan Nama" value="{{ old('nama_pasca') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="nama_ayah_pasca">Nama Ayah <span class="text-warning">*Bisa dikosongi</span></label>
                        <input type="input" name="nama_ayah" class="form-control" id="nama_ayah_pasca" disabled
                            placeholder="Masukkan Nama Ayah" value="{{ old('nama_ayah_pasca') }}">
                    </div>
                    <div class="form-group">
                        <label for="judul_pasca">Judul <span class="text-warning">*Bisa dikosongi</span></label>
                        <input type="input" name="judul" class="form-control" id="judul_pasca" disabled
                            placeholder="Masukkan Judul" value="{{ old('judul_pasca') }}">
                    </div>
                    <div class="form-group">
                        <label for="tanggal_sidang_pasca">Tanggal Sidang <span class="text-warning">*Bisa dikosongi</span></label>
                        <input type="date" name="tanggal_sidang" class="form-control" id="tanggal_sidang_pasca"
                            disabled placeholder="Masukkan Tanggal Sidang" value="{{ old('tanggal_sidang_pasca') }}">
                    </div>
                    <div class="form-group">
                        <label for="tahun_pasca">Tahun</label>
                        <select class="form-control select2bs4 w-100" id="tahun_pasca" name="tahun_id" disabled
                            required>
                            <option value="">Pilih Tahun</option>
                            @foreach ($tahun as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin_pasca">Jenis Kelamin</label>
                        <select class="form-control select2bs4 w-100" id="jenis_kelamin_pasca" name="jenis_kelamin"
                            disabled required>
                            <option value="">Pilih Tahun Terlebih Dahulu</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="prodi_pasca">Prodi</label>
                        <select class="form-control select2bs4 w-100" id="prodi_pasca" name="prodi_id" disabled
                            required>
                            <option value="">Pilih Prodi</option>
                            @foreach ($prodiPasca as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_pasca">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" id="jumlah_pasca"
                            placeholder="Masukkan Jumlah yang Dibayar" value="{{ old('jumlah_pasca') }}"
                            onkeyup="formatRupiah(this.value,'#jumlahPascaHelp')" onfocus="this.select();" disabled
                            required>
                        <small id="jumlahPascaHelp" class="form-text text-muted">Rp.</small>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pembayaran_pasca">Jenis Pembayaran</label>
                        <select class="form-control select2bs4 w-100" id="jenis_pembayaran_pasca"
                            name="jenis_pembayaran" disabled required>
                            <option value="">Pilih Jenis Pembayaran</option>
                            @foreach (\Helper::getEnumValues('pembayaran', 'jenis_pembayaran') as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="ukuran_baju_pasca">Ukuran Baju <span class="text-warning">*Bisa dikosongi</span></label>
                        <select class="form-control select2bs4 w-100" id="ukuran_baju_pasca" name="ukuran_baju"
                            disabled>
                            <option value="">Pilih Ukuran Baju</option>
                            @foreach (\Helper::getEnumValues('peserta', 'ukuran_baju') as $item)
                                <option value="{{ $item }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan_pasca">Keterangan <span class="text-warning">*Bisa dikosongi</span></label>
                        <textarea name="keterangan" rows="3" class="form-control" id="keterangan_pasca" disabled
                            placeholder="Masukkan Keterangan"></textarea>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="form_submit_pasca" disabled>Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
@push('script')
    <script>
        var jenisKelamin = null;
        $(document).ready(function() {
            //autocomplete pasca
            $("#search_pasca").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "get",
                        data: {
                            term: request.term,
                            tipe: 'pasca'
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
                    $('#search_pasca').val(valItem);
                    document.getElementById('search_btn_pasca').click();
                    return false; // make #search can edit
                }
            });
        });

        $('#modal_add_pembayaran_pasca').on('shown.bs.modal', function() {
            $('#search_pasca').focus();
        })

        $('#form_add_pembayaran_pasca').submit(function(e) {
            e.preventDefault();
            let fd = new FormData(this);
            $.ajax({
                type: "POST",
                url: "{{ route('admin.pembayaran.registrasi') }}",
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#form_submit_pasca').attr('disabled', true);
                    $('#form_submit_pasca').text('Loading...');
                },
                success: function(response) {
                    console.log(response);
                    $('#modal_add_pembayaran_pasca').modal('hide');
                    swalToast(response.message, response.data);
                    $('#search_pasca').val('');
                    $('#search_btn_pasca').click();
                    cardRefresh();
                },
                complete: function() {
                    $('#form_submit_pasca').attr('disabled', false);
                    $('#form_submit_pasca').text('Simpan');
                }
            });
        });

        $('#tahun_pasca').change(function(e) {
            setJenisKelaminPasca();
        });

        function setJenisKelaminPasca() {
            $.ajax({
                type: "GET",
                url: "{{ route('operasi.kuota.getData') }}",
                data: {
                    tahun_id: $('#tahun_pasca').val(),
                    jenjang: 'Pasca',
                },
                dataType: "json",
                beforeSend: function() {
                    $('#jenis_kelamin_pasca').empty();
                    $('#jenis_kelamin_pasca').append('<option value="">Loading...</option>');
                },
                success: function(response) {
                    if (!response.status) {
                        $('#jenis_kelamin_pasca').empty();
                        $('#jenis_kelamin_pasca').append(
                            '<option value="">Pilih Tahun Terlebih Dahulu</option>');
                    }

                    if (response.status) {
                        $('#jenis_kelamin_pasca').empty();
                        $('#jenis_kelamin_pasca').append('<option value="">Siap dipilih..</option>');
                        response.data.forEach(kuota => {
                            $('#jenis_kelamin_pasca').append(`
                                <option value="${kuota.jenis}_${kuota.kuota}" ${kuota.jenis == jenisKelamin ? 'selected' : ''}>${kuota.jenis} (${kuota.kuota})</option>
                            `);
                        });
                    }
                }
            });
        }

        function cekPesertaPasca(eModal, eSearch, eNim, eNama, eNamaAyah, eJudul, eTanggalSidang, eJenisKelamin, eProdi,
            eTahun,
            eJenisPembayaran, eJumlah, eUkuranBaju, eKeterangan, eFormSubmit) {

            $(eNim).removeAttr('disabled');
            $(eNama).removeAttr('disabled');
            $(eNamaAyah).removeAttr('disabled');
            $(eJudul).removeAttr('disabled');
            $(eTanggalSidang).removeAttr('disabled');
            $(eJenisKelamin).prop('disabled', false).trigger('change');
            $(eProdi).prop('disabled', false).trigger('change');
            $(eTahun).prop('disabled', false).trigger('change');
            $(eJenisPembayaran).prop('disabled', false).trigger('change');
            $(eJumlah).removeAttr('disabled');
            $(eUkuranBaju).prop('disabled', false).trigger('change');
            $(eKeterangan).removeAttr('disabled');
            $(eFormSubmit).removeAttr('disabled');

            $.ajax({
                type: "POST",
                url: "{{ route('operasi.peserta.getData') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: $(eSearch).val(),
                    tipe: 'pasca'
                },
                beforeSend: function() {
                    $(`${eModal} .overlay`).remove();
                    var div = '<div class="overlay bkg-white">' +
                        '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                        '</div>';
                    $(`${eModal} .modal-header`).append(div);
                },
                
               success: function(response) {
    console.log("Response:", response);

    let data = response.data;
    let user = data?.user;

    if (!user || !user.id) {
        console.warn('Data atau ID user tidak ditemukan:', data);
        return;
    }

    jenisKelamin = user.jenis_kelamin ?? null;

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
                    if (user.prodi?.jenjang == "S1") {
        swalToast(500, "Bukan Mahasiswa Pasca")
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

                    $(eNim).val(user.nim);
                    $(eNama).val(user.nama);
                    $(eNamaAyah).val(user.nama_ayah);
                    $(eJudul).val(user.judul);
                    $(eTanggalSidang).val(user.tanggal_sidang);
                    $(eTahun).val(user.tahun?.id).change();
                    $(eProdi).val(user.prodi?.id).change();
                    $(eUkuranBaju).val(user.ukuran_baju).change();
                },
                complete: function(response) {
                    $(`${eModal} .overlay`).remove();
                }
            });
        }
    </script>
@endpush
