<!-- TO DO List -->
<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="ion ion-clipboard mr-1"></i>
            Catatan
        </h3>

        <div class="card-tools">
            <div id="show_paginator" class="small"></div>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul class="todo-list" data-widget="todo-list" id="todo-list">
            @php
                $i = 1;
            @endphp
            @foreach ($daftarTugas as $dt)
                <li>
                    <!-- drag handle -->
                    <span class="handle">
                        <i class="fas fa-ellipsis-v"></i>
                        <i class="fas fa-ellipsis-v"></i>
                    </span>
                    <!-- checkbox -->
                    <div class="icheck-primary d-inline ml-2">
                        <input type="checkbox" value="" name="todo{{ $i }}"
                            data-id="{{ $dt->id }}" onchange="editCheck(event)" id="todoCheck{{ $i }}"
                            {{ $dt->status == 'done' ? 'checked' : '' }}>
                        <label for="todoCheck{{ $i++ }}"></label>
                    </div>
                    <!-- todo text -->
                    <span class="text">{{ $dt->tugas }}</span>
                    <!-- Emphasis label -->
                    <small class="badge badge-{{ $dt->peringatan }}"><i
                            class="far fa-clock"></i>{{ $dt->deadline_baru }}</small>
                    <!-- General tools such as edit or delete-->
                    <div class="tools">
                        <i class="fas fa-edit" data-toggle="modal" data-target="#modal-edit-item"
                            data-id="{{ $dt->id }}" data-tugas="{{ $dt->tugas }}"
                            data-deadline="{{ $dt->deadline }}"></i>
                        <i class="fas fa-trash-o"></i>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <button type="button" class="btn btn-primary float-right" data-toggle="modal"
            data-target="#modal-tambah-item"><i class="fas fa-plus"></i>
            Tambah item</button>

        <!-- modal form tambah -->
        <div class="modal fade" id="modal-tambah-item">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Tambah Item</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ route('operasi.daftarTugas.tambah') }}" method="POST" id="formTambahDaftarTugas">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="tugas">Tugas</label>
                                <input type="text" class="form-control" id="tugas" aria-describedby="tugasHelp"
                                    placeholder="Masukkan tugas" name="tugas" required>
                            </div>
                            <div class="form-group">
                                <label>Deadline</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#reservationdatetime" name="deadline"
                                        placeholder="Masukkan deadline" required />
                                    <div class="input-group-append" data-target="#reservationdatetime"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Tambahkan</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- modal edit -->
        <div class="modal fade" id="modal-edit-item" tabindex="-1" role="dialog" aria-labelledby="exampleModalEdit"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-edit-title">Title
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formEditDaftarTugas">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="modal-edit-tugas" class="col-form-label">Tugas</label>
                                <input type="text" class="form-control" id="modal-edit-tugas" name="tugas"
                                    required>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="id" id="modal-edit-id" required>
                                <label>Deadline</label>
                                <div class="input-group date" id="reservationdatetime2" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#reservationdatetime2" id="modal-edit-deadline" name="deadline"
                                        required>
                                    <div class="input-group-append" data-target="#reservationdatetime2"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger mr-auto"
                                id="modal-edit-hapus">Hapus</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- /.card -->

@push('script')
    <script>
        // Make the dashboard widgets sortable Using jquery UI
        var currentPagePagination = 1;

        // jQuery UI sortable for the todo list
        $('.todo-list').sortable({
            placeholder: 'sort-highlight',
            handle: '.handle',
            forcePlaceholderSize: true,
            zIndex: 999999
        })

        //Date and time picker
        $('#reservationdatetime').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });
        $('#reservationdatetime2').datetimepicker({
            icons: {
                time: 'far fa-clock'
            }
        });

        //Date picker
        $('#reservationdate').datetimepicker({
            format: 'yyyy-M-DD'
        });
        $('#reservationdate2').datetimepicker({
            format: 'yyyy-M-DD'
        });

        // paginator
        $('#show_paginator').bootpag({
            total: {{ $jumlahHalaman }}, // total pages
            page: 1, // default page
            maxVisible: 5, // visible pagination
            leaps: true // next/prev leaps through maxVisible
        }).on("page", function(event, num) {
            gantiHalaman(num);
        });

        $("#formTambahDaftarTugas").submit(function(e) {
            e.preventDefault();
            var data = $(this).serializeArray();
            var url = "{{ route('operasi.daftarTugas.tambah') }}"
            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    console.log(response);
                    if (response.message == 200) {
                        $('#modal-tambah-item').modal('toggle')
                        swalToast(response.message, response.data);
                        refreshPagination(1);
                    }
                }
            });
        });

        $('#modal-edit-item').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var id = button.data('id'); // Extract info from data-* attributes
            var tugas = button.data('tugas');
            var deadline = button.data('deadline');

            $('#modal-edit-title').html("Edit");
            $('#modal-edit-id').val(id);
            $('#modal-edit-tugas').val(tugas);
            $('#modal-edit-deadline').val(deadline);
        })

        $('#formEditDaftarTugas').submit(function(e) {
            e.preventDefault();
            var id = $(this).serializeArray()[2].value;
            var url = "{{ route('operasi.daftarTugas.edit') }}";

            var data = $(this).serialize();
            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    $('#modal-edit-item').modal('toggle')
                    swalToast(response.message, response.data);
                    refreshPagination(currentPagePagination);
                }
            });
        });

        $('#modal-edit-hapus').click(function(e) {
            e.preventDefault();
            var data = $('#formEditDaftarTugas').serialize();
            var id = $('#formEditDaftarTugas').serializeArray()[2].value;
            var url = "{{ route('operasi.daftarTugas.show') }}/" + id + "/hapus"

            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    $('#modal-edit-item').modal('toggle')
                    swalToast(response.message, response.data);
                    refreshPagination(currentPagePagination);
                }
            });
        });

        function refreshPagination(halamanTujuan) {
            $.ajax({
                type: "get",
                url: "{{ route('operasi.daftarTugas.jumlahHalaman') }}",
                dataType: "json",
                success: function(response) {
                    $('#show_paginator').bootpag({
                        total: response.data, // total pages
                        page: halamanTujuan, // default page
                        maxVisible: 5, // visible pagination
                        leaps: true // next/prev leaps through maxVisible
                    });
                    gantiHalaman(halamanTujuan);
                }
            });
        }

        // refresh halaman to do list
        function gantiHalaman(halaman) {
            var offset = (5 * halaman) - 5;
            var url = "{{ route('operasi.daftarTugas.show') }}" + "/" + offset;
            currentPagePagination = halaman;
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    $("#todo-list").empty();
                    var data = response.data;
                    var i = 1;
                    data.forEach(dat => {
                        var checked = "";
                        if (dat.status == "done") {
                            checked = "checked"
                        }
                        var div = '<li class="anim-fade ' + dat.status + '">' +
                            '<span class="handle">' +
                            '<i class="fas fa-ellipsis-v"></i>' +
                            '<i class="fas fa-ellipsis-v"></i>' +
                            '</span>' +
                            '<div class="icheck-primary d-inline ml-2">' +
                            '<input type="checkbox" value="" name="todo' + i + '" id="todoCheck' + i +
                            '" data-id="' + dat.id + '" onchange="editCheck(event)" ' + checked + ' >' +
                            '<label for="todoCheck' + i++ + '"></label>' +
                            '</div>' +
                            '<span class="text">' + dat.tugas + '</span>' +
                            '<small class="badge badge-' + dat.peringatan + '"><i' +
                            'class="far fa-clock"></i>' + dat.deadline_baru + '</small>' +
                            '<div class="tools">' +
                            '<i class="fas fa-edit" data-toggle="modal" data-target="#modal-edit-item" data-id="' +
                            dat.id + '" data-tugas="' + dat.tugas + '" data-deadline="' + dat.deadline +
                            '"></i>' +
                            '<i class="fas fa-trash-o"></i>' +
                            '</div>' +
                            '</li>';
                        $('#todo-list').append(div);
                    });
                }
            });
        }

        function editCheck(event) {
            var cek = $(event.currentTarget).is(':checked');
            var id = $(event.currentTarget).attr('data-id');
            if (cek) {
                ajaxEdit(id, "done");
            } else {
                ajaxEdit(id, "aktif");
            }
        }

        function ajaxEdit(id, status) {
            var url = "{{ route('operasi.daftarTugas.show') }}" + "/" + id + "/edit" + "/" + status
            $.ajax({
                type: "get",
                url: url,
                dataType: "json",
                success: function(response) {
                    var message = response.message;
                    var data = response.data;
                    swalToast(message, data);
                }
            });
        }
    </script>
@endpush
