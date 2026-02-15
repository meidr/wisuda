{{-- Modal Tambah --}}
<form action="" id="form_add_pembayaran" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="modal fade" id="modal_add_pembayaran" role="dialog" aria-labelledby="modal_add_pembayaran">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="peserta_id" name="peserta_id">
                        <label for="search">Cari</label>
                        <div class="input-group">
                            <input type="input" name="search" class="form-control" id="search"
                                placeholder="Masukkan NIM / Nama" value="{{ old('search') }}" onfocus="this.select();">
                            <button type="button" class="btn btn-primary" id="search_btn" style="cursor: pointer"
                                onclick="getDataPeserta('#search','#peserta_id','#nim', '#nama', '#jenis_kelamin', '#prodi', '#jumlah', '#jenis_pembayaran','#keterangan',
                                '#modal_add_pembayaran')">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nim">NIM</label>
                                <input type="input" name="nim" class="form-control" id="nim" disabled
                                    placeholder="Masukkan NIM" value="{{ old('nim') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="input" name="nama" class="form-control" id="nama" disabled
                                    placeholder="Masukkan Nama" value="{{ old('nama') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin">Jenis Kelamin</label>
                                <input type="input" name="jenis_kelamin" class="form-control" id="jenis_kelamin"
                                    disabled placeholder="Masukkan Jenis Kelamin" value="{{ old('jenis_kelamin') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prodi">Prodi</label>
                                <input type="input" name="prodi" class="form-control" id="prodi" disabled
                                    placeholder="Masukkan Prodi" value="{{ old('prodi') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" id="jumlah"
                            placeholder="Masukkan Jumlah yang Dibayar" value="{{ old('jumlah') }}"
                            onkeyup="formatRupiah(this.value,'#jumlahHelp')" onfocus="this.select();" disabled required>
                        <small id="jumlahHelp" class="form-text text-muted">Rp.</small>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pembayaran">Jenis Pembayaran</label>
                        <div class="form-group">
                            <select class="form-control select2bs4 w-100" id="jenis_pembayaran" name="jenis_pembayaran"
                                required disabled>
                                <option value="">Pilih Jenis Pembayaran</option>
                                @foreach (\Helper::getEnumValues('pembayaran', 'jenis_pembayaran') as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" rows="3" class="form-control" id="keterangan" disabled
                            placeholder="Masukkan Keterangan"></textarea>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="form_submit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>

{{-- Modal Edit --}}
<form action="" id="form_edit_pembayaran" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="modal fade" id="modal_edit_pembayaran" tabindex="-1" role="dialog"
        aria-labelledby="modal_edit_pembayaran">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit Pembayaran</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" id="id_edit" name="id">
                        <label for="search_edit">Cari</label>
                        <div class="input-group">
                            <input type="input" name="search" class="form-control" id="search_edit"
                                placeholder="Masukkan NIM / Nama" value="{{ old('search') }}" readonly
                                onfocus="this.select();">
                            <button type="button" class="btn btn-primary" id="search_btn_edit"
                                style="cursor: pointer"
                                onclick="getDataPeserta('#search_edit','#peserta_id_edit','#nim_edit', '#nama_edit', '#jenis_kelamin_edit', '#prodi_edit', 
                                '#jumlah_edit','#jenis_pembayaran_edit', '#keterangan_edit','#modal_edit_pembayaran')">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nim_edit">NIM</label>
                                <input type="input" name="nim" class="form-control" id="nim_edit" disabled
                                    placeholder="Masukkan NIM" value="{{ old('nim') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama_edit">Nama</label>
                                <input type="input" name="nama" class="form-control" id="nama_edit" disabled
                                    placeholder="Masukkan Nama" value="{{ old('nama') }}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jenis_kelamin_edit">Jenis Kelamin</label>
                                <input type="input" name="jenis_kelamin" class="form-control"
                                    id="jenis_kelamin_edit" disabled placeholder="Masukkan Jenis kelamin"
                                    value="{{ old('jenis_kelamin') }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="prodi_edit">Prodi</label>
                                <input type="input" name="prodi" class="form-control" id="prodi_edit" disabled
                                    placeholder="Masukkan Prodi" value="{{ old('prodi') }}">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jenis_pembayaran_edit">JenisPembayaran</label>
                        <div class="form-group">
                            <select class="form-control select2bs4 w-100" id="jenis_pembayaran_edit"
                                name="jenis_pembayaran" required disabled>
                                <option value="*">Pilih Jenis Pembayaran</option>
                                @foreach (\Helper::getEnumValues('pembayaran', 'jenis_pembayaran') as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="jumlah_edit">Jumlah</label>
                        <input type="number" name="jumlah" class="form-control" id="jumlah_edit"
                            placeholder="Masukkan Jumlah yang Dibayar" value="{{ old('jumlah') }}"
                            onkeyup="formatRupiah(this.value,'#jumlahHelpEdit')" onfocus="this.select();" disabled>
                        <small id="jumlahHelpEdit" class="form-text text-muted">Rp.</small>
                    </div>

                    <div class="form-group">
                        <label for="keterangan_edit">Keterangan</label>
                        <textarea name="keteranga" rows="3" class="form-control" id="keterangan_edit" disabled
                            placeholder="Masukkan Keterangan"></textarea>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="form_submit_edit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>


@push('script')
    <script>
        $(document).ready(function() {
            //Initialize Select2 Elements
            $('select:not(.normal)').each(function() {
                $(this).select2({
                    theme: 'bootstrap4',
                    dropdownParent: $(this).parent()
                });
            });

            // data table and card refresh
            table1 = dataTable('#table_pembayaran');
            $('div.dataTables_filter input', table1.table().container()).focus();

            $('#card_refresh_pembayaran').click(function(e) {
                table1.ajax.reload();
            });

            //autocomplete nim
            $("#search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        type: "get",
                        data: {
                            term: request.term
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
                    $('#search').val(valItem);
                    document.getElementById('search_btn').click();
                    return false; // make #search can edit
                }
            });
        });
    </script>

    <script>
        $('#modal_add_pembayaran').on('shown.bs.modal', function() {
            $('#search').focus();
            @if (isset($peserta))
                $('#search').attr('disabled', true);
                $('#search').val('{{ $peserta->nim }}');
                document.getElementById('search_btn').click();
            @endif
        })

        $('#form_add_pembayaran').submit(function(e) {
            e.preventDefault();
            var data = $(this).serialize();
            var url = "{{ route('admin.pembayaran.add') }}";
            var fd = new FormData($(this)[0]);

            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#form_submit').attr('disabled', true);
                },
                success: function(response) {
                    swalToast(response.message, response.data);
                    cardRefresh();
                },
                complete: function() {
                    $('#modal_add_pembayaran').modal('toggle');
                    $('#form_submit').attr('disabled', false);
                }
            });
        });

        $('#modal_edit_pembayaran').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var peserta_nim = button.data('peserta_nim');
            var jumlah = button.data('jumlah');
            var jenis_pembayaran = button.data('jenis_pembayaran');
            var keterangan = button.data('keterangan');

            var modal = $(this);
            modal.find('#id_edit').val(id);
            modal.find('#search_edit').val(peserta_nim);
            modal.find('#jumlah_edit').val(jumlah);
            formatRupiah(jumlah, '#jumlahHelpEdit');
            modal.find('#jenis_pembayaran_edit').val(jenis_pembayaran).change();
            modal.find('#keterangan_edit').val(keterangan);
            document.getElementById('search_btn_edit').click();
        })

        $('#form_edit_pembayaran').submit(function(e) {
            e.preventDefault();

            var url = "{{ route('admin.pembayaran.edit') }}";
            var fd = new FormData($('#form_edit_pembayaran')[0]);

            $.ajax({
                type: "post",
                url: url,
                data: fd,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    $('#form_submit_edit').attr('disabled', true);
                },
                success: function(response) {
                    swalToast(response.message, response.data);
                    cardRefresh();
                },
                complete: function() {
                    $('#modal_edit_pembayaran').modal('toggle');
                    $('#form_submit_edit').prop("disabled", false);
                }
            });
        });
    </script>

    <script>
        function getDataPeserta(eSearch, ePesertaId, eNik, eNama, eJenisKelamin, eProdi, eJumlah, eJenisPembayaran,
            eKeterangan, eModal) {
            $(eNik).val('');
            $(eNama).val('');
            $(eJenisKelamin).val('');
            $(eProdi).val('');
            $(ePesertaId).val('');
            $.ajax({
                type: "POST",
                url: "{{ route('operasi.peserta.getData') }}",
                data: {
                    _token: "{{ csrf_token() }}",
                    search: $(eSearch).val()
                },
                beforeSend: function() {
                    $(`${eModal} .overlay`).remove();
                    var div = '<div class="overlay bkg-white">' +
                        '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                        '</div>';
                    $(`${eModal} .modal-header`).append(div);
                },
                success: function(response) {
                    if (!response.status) {
                        swalToast(500, response.data);
                        $(eJumlah).prop('disabled', true);
                        $(eJenisPembayaran).prop('disabled', true);
                        $(eKeterangan).prop('disabled', true);
                        return;
                    }

                    let data = response.data;
                    $(eNik).val(data.nim);
                    $(eNama).val(data.nama);
                    $(eJenisKelamin).val(data.user.jenis_kelamin);
                    $(eProdi).val(data.prodi != null ? data.prodi.nama : '');
                    $(ePesertaId).val(data.id);
                    if (response.status) {
                        $(eJumlah).removeAttr('disabled');
                        $(eJumlah).focus();
                        $(eJenisPembayaran).removeAttr('disabled');
                        $(eKeterangan).removeAttr('disabled');
                    }
                },
                complete: function(response) {
                    $(`${eModal} .overlay`).remove();
                }
            });
        }

        function deleteData(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var nim = event.target.querySelector('input[name="nim"]').value;
            var jumlah = event.target.querySelector('input[name="jumlah"]').value;
            Swal.fire({
                title: `Yakin Ingin menghapus <br>${nim}<br>${jumlah}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.pembayaran.delete') }}";
                    var fd = new FormData($(event.target)[0]);

                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            swalToast(response.message, response.data);
                            cardRefresh();
                        }
                    });
                }
            })
        }

        function cardRefresh() {
            var cardRefresh = document.querySelector('#card_refresh_pembayaran');
            cardRefresh.click();
            changeInfo();
        }

        function swalToast(message, data) {
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            if (message == 200) {
                Toast.fire({
                    icon: 'success',
                    title: data
                });
            } else {
                Toast.fire({
                    icon: 'error',
                    title: data
                });
            }
        }

        function dataTable(id) {
            var url = "{{ route('admin.pembayaran.data') }}"
            var datatable = $(id).DataTable({
                // responsive: true,
                // dom: "Bfrltip",
                autoWidth: false,
                processing: true,
                serverSide: true,
                order: [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    data: function(d) {
                        d.tahun = $('#filter_tahun').val();
                        d.prodi_id = $('#filter_prodi_id').val();
                        d.tanggal = $('#filter_tanggal').val();
                        d.range_tanggal = $('#filter_range_tanggal').val();
                        d.jenis_kelamin = $('#filter_jenis_kelamin').val();
                        d.nim = "{{ isset($peserta) ? $peserta->nim : '' }}";
                    },
                    beforeSend: function() {
                        $('#card_pembayaran .overlay').remove();
                        var div = '<div class="overlay">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('#card_pembayaran').append(div);
                    },
                    complete: function() {
                        $('#card_pembayaran .overlay').remove();
                    }
                },
                deferRender: true,
                columns: [{
                        data: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        },
                        className: "align-middle"
                    },
                    {
                        data: 'tahun_nama',
                        name: 'tahun_nama',
                        className: "align-middle"
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        className: "align-middle"
                    },
                    {
                        data: 'peserta_nim',
                        name: 'peserta_nim',
                        className: "align-middle",
                    },
                    {
                        data: 'peserta_nama',
                        name: 'peserta_nama',
                        className: "align-middle",
                    },
                    {
                        data: 'users_jk',
                        name: 'users_jk',
                        className: "align-middle",
                    },
                    {
                        data: 'prodi_nama',
                        name: 'prodi_nama',
                        className: "align-middle",
                    },
                    {
                        data: 'jumlah',
                        name: 'jumlah',
                        className: "align-middle",
                    },
                    {
                        data: 'jenis_pembayaran',
                        name: 'jenis_pembayaran',
                        className: "align-middle",
                    },
                    {
                        data: 'keterangan',
                        name: 'keterangan',
                        className: "align-middle",
                    },
                    {
                        data: 'action',
                        name: 'action',
                        className: "align-middle",
                        'searchable': false,
                    },
                ],
                buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
            })
            datatable.buttons().container().appendTo(id + '_filter .col-md-6:eq(0)');
            return datatable;
        }
    </script>
@endpush
