<div class="mb-3">
    <button type="button" class="btn btn-primary w-100" data-toggle="modal" data-target="#modal_add">
        Tambah Dokumen
    </button>
</div>

<table id="table_dokumen" class="table table-bordered table-hover table-sm-responsive">
    <thead>
        <tr>
            <th>No</th>
            <th>File</th>
            <th>Dokumen</th>
            <th>Tanggal</th>
            <th>Download</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>

<form id="form_add" enctype="multipart/form-data" method="POST">
    @csrf
    <div class="modal fade" id="modal_add">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Dokumen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="list_dokumen_id">Tipe</label>
                        <select class="form-control select2bs4" name="list_dokumen_id" id="list_dokumen_id" required>
                            <option value="">Pilih Tipe Dokumen</option>
                            @foreach ($listDokumen as $item)
                                <option value="{{ $item->id }}">{{ strtoupper($item->tipe) }} -
                                    {{ strtoupper($item->status) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Upload File <span class="text-secondary text-sm">*JPEG, PNG, JPG,
                                MAX 2MB</span></label>
                        <div id="container-dropzone">
                            <div class="needsclick dropzone" id="image-dropzone">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" id="form_submit">Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>
@push('script')
    <script>
        initDokumen();

        function initDokumen() {
            var uploadedImageMapDokumen = {};
            var nFileUploadDokumen = 1;
            var myDropzoneDokumen = null;
            Dropzone.autoDiscover = false;

            $(document).ready(function() {

                let tableDokumen = dataTableDokumen('#table_dokumen');
                createDropZoneAdd();
            });

            $('#form_add').submit(function(e) {
                e.preventDefault();
                let fd = new FormData(this);
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.peserta.saveDokumen', ['peserta' => $peserta]) }}",
                    data: fd,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#form_submit').prop("disabled", true);
                    },
                    complete: function() {
                        $('#form_submit').prop("disabled", false);
                    },
                    success: function(response) {
                        $('#modal_add').modal('hide');
                        swalToast(response.message, response.data);
                        if (response.message == 200) {
                            forgetDokumenSisa();
                        }
                        cardRefresh();
                        console.log(response);
                        saveStateTab('#nav_dokumen');
                    }
                });
            });
        }

        function createDropZoneAdd() {
            uploadedImageMapDokumen = {};
            nFileUploadDokumen = 1;
            myDropzoneDokumen = new Dropzone($('#image-dropzone').get(0), {
                url: "{{ route('admin.peserta.fileUpload') }}",
                maxFilesize: 200, // MB
                maxFiles: 1,
                addRemoveLinks: true,
                timeout: 180000,
                // autoProcessQueue: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                renameFilename: function(file) {
                    return `(${nFileUploadDokumen++}) ${file}`;
                },
                success: function(file, response) {
                    $('#form_add').append('<input type="text" name="dokumen" class="dokumen" value="' +
                        response.name +
                        '">')
                    uploadedImageMapDokumen[file.upload.filename] = response.name;
                    saveDokumenSisa(response.name);
                    $('#form_submit').prop("disabled", false);
                },
                removedfile: function(file) {
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
                        name = file.file_name
                    } else {
                        name = uploadedImageMapDokumen[file.upload.filename]
                    }
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: "post",
                        url: "{{ route('admin.peserta.fileDelete') }}",
                        data: {
                            dokumen: name
                        },
                        success: function(response) {
                            console.log(response);
                            $('#form_add').find('input[name="dokumen[]"][value="' + name + '"]')
                                .remove();
                            deleteDokumenSisa(response.name);
                        }
                    });
                },
                uploadprogress: function(file, progress, bytesSent) {
                    if (file.previewElement) {
                        var progressElement = file.previewElement.querySelector("[data-dz-uploadprogress]");
                        progressElement.style.width = progress + "%";
                    }
                    $('#form_submit').prop("disabled", true);
                }
            });
            myDropzoneDokumen.on("addedfile", function(file) {
                file.previewElement.querySelector('[data-dz-name]').textContent = file.upload.filename;
            });
        }

        function dataTableDokumen(id) {
            var url = "{{ route('admin.peserta.dataDokumen', ['peserta' => $peserta]) }}";
            var datatable = $(id).DataTable({
                responsive: true,
                autoWidth: false,
                processing: true,
                serverSide: true,
                "order": [
                    [0, "desc"]
                ],
                search: {
                    return: true,
                },
                ajax: {
                    url: url,
                    data: function(d) {
                        d.jenis = $('#filter-jenis').val();
                    },
                    beforeSend: function() {
                        $('.overlay').remove();
                        var div = '<div class="overlay">' +
                            '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                            '</div>';
                        $('#card').append(div);
                    },
                    complete: function() {
                        $('.overlay').remove();
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
                        data: 'file',
                        name: 'file',
                        className: "align-middle"
                    },
                    {
                        data: 'list_dokumen_tipe',
                        name: 'list_dokumen_tipe',
                        className: "align-middle"
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        className: "align-middle",
                    },
                    {
                        data: 'download',
                        name: 'download',
                        className: "align-middle",
                    },
                    {
                        data: 'delete',
                        name: 'delete',
                        className: "align-middle",
                    },
                ]
            })
            datatable.buttons().container().appendTo(id + '_wrapper .col-md-6:eq(0)');
            return datatable;
        }

        function deleteDataDokumen(event) {
            event.preventDefault();
            var id = event.target.querySelector('input[name="id"]').value;
            var tipe = event.target.querySelector('input[name="tipe"]').value;
            Swal.fire({
                title: `Yakin Ingin menghapus ${tipe}?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Iya',
                cancelButtonText: 'Batal',
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = "{{ route('admin.peserta.deleteDokumen', ['peserta' => $peserta]) }}";
                    var fd = new FormData($(event.target)[0]);

                    $.ajax({
                        type: "post",
                        url: url,
                        data: fd,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('.overlay').remove();
                            var div = '<div class="overlay">' +
                                '<i class="fas fa-2x fa-sync-alt fa-spin"></i>' +
                                '</div>';
                            $('#card').append(div);
                        },
                        complete: function() {
                            $('.overlay').remove();
                        },
                        success: function(response) {
                            swalToast(response.message, response.data);
                            cardRefresh();
                            console.log(response);
                        }
                    });
                }
            })
        }
    </script>
@endpush
