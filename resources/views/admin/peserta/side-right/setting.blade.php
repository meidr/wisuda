<form class="form-horizontal setting" id="form-setting" method="POST" action="#"">
    @csrf
    @method('PUT')
    <div class="form-group row">
        <label for="password" class="col-sm-3 col-form-label">Password Baru</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="password" name="password">
        </div>
    </div>

    <div class="form-group row">
        <label for="password_confirm" class="col-sm-3 col-form-label">Konfirmasi Password</label>
        <div class="col-sm-9">
            <input type="text" class="form-control" id="password_confirm" name="password_confirm">
        </div>
    </div>

    <div class="form-group row">
        <div class="offset-sm-3 col-sm-9">
            <button type="submit" class="btn btn-primary mr-3" id="button_submit_setting">Simpan</button>
        </div>
    </div>
</form>

@push('script')
    <script>
        initSetting();

        function initSetting() {

            $(document).ready(function() {
                $("#form-setting").validate({
                    rules: {
                        password: {
                            required: true
                        },
                        password_confirm: {
                            required: true,
                            equalTo: "#password"
                        }
                    },
                    messages: {
                        password: {
                            required: "Password is required"
                        },
                        password_confirm: {
                            required: "Confirm Password is required",
                            equalTo: "Passwords do not match"
                        }
                    },
                    errorElement: 'span',
                    errorPlacement: function(error, element) {
                        error.addClass('pl-2 invalid-feedback');
                        element.closest('.form-group').append(error);
                    },
                    highlight: function(element, errorClass, validClass) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
            $('#form-setting').submit(function(e) {
                e.preventDefault();

                if ($(this).valid()) {
                    let html = `<div class="d-flex align-items-center">
                            <strong>Proses..</strong>
                            <div class="spinner-border spinner-border-sm ml-auto" role="status" aria-hidden="true"></div>
                            </div>`;
                    $('#button_submit_setting').html(html);
                    let fd = new FormData(this);

                    $.ajax({
                        type: "POST",
                        url: "{{ route('admin.peserta.updatePassword', ['peserta' => $peserta]) }}",
                        data: fd,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            swalToast(response.message, response.data);
                            cardRefresh();
                            saveStateTab('#nav_setting');
                        }
                    });
                }
            });
        }
    </script>
@endpush
