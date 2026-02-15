<div class="card card-primary" id="card_otp">
    <div class="card-header">
        Setting WhatsApp
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_otp" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_otp"
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
    <div class="card-body" id="card_refresh_content_otp">
        <form method="POST" id="form_otp">
            @csrf
            {{-- <div class="form-group">
                <label for="otp">OTP</label>
                <select class="form-control select2bs4 w-100" name="otp" id="otp" required>
                    @foreach (BulkData::statusValueNama as $item)
                        <option value="{{ $item['value'] }}" {{ $setting['otp'] == $item['value'] ? 'selected' : '' }}>
                            {{ $item['nama'] }}</option>
                    @endforeach
                </select>
            </div> --}}
            <div class="form-group">
                <label for="vendor_notifikasi">Vendor</label>
                <select class="form-control select2bs4 w-100" name="vendor_notifikasi" id="vendor_notifikasi" required>
                    @foreach (BulkData::vendor as $item)
                        <option value="{{ $item }}"
                            {{ $setting['vendor_notifikasi'] == $item ? 'selected' : '' }}>{{ $item }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Isi Pesan</label>
                <textarea type="text" name="isi_pesan_wa" rows="3" class="form-control" placeholder="Masukkan Isi Pesan Wa"
                    required>{{ $setting['isi_pesan_wa'] }}</textarea>
            </div>
            <div class="card card-primary card-outline card-tabs">
                <div class="card-header p-0 pt-1 border-bottom-0">
                    <ul class="nav nav-tabs" id="tabs-otp-header" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="tabs-zenzifa-tab" data-toggle="pill" href="#tabs-zenziva"
                                role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Zenzifa</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="tabs-fonnte-tab" data-toggle="pill" href="#tabs-fonnte"
                                role="tab" aria-controls="custom-tabs-three-home" aria-selected="true">Fonnte</a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="tabs-otp-content">
                        <div class="tab-pane fade active show" id="tabs-zenziva" role="tabpanel"
                            aria-labelledby="tabs-zenziva">
                            <div class="form-group">
                                <label>Userkey</label>
                                <input type="text" name="userkey_zenziva" class="form-control"
                                    placeholder="Masukkan userkey" value="{{ $zenziva->userkey }}" required>
                            </div>
                            <div class="form-group">
                                <label>Passkey</label>
                                <input type="text" name="passkey_zenziva" class="form-control" required
                                    placeholder="Masukkan nomor WA CS" value="{{ $zenziva->token }}">
                            </div>
                        </div>
                        <div class="tab-pane fade" id="tabs-fonnte" role="tabpanel" aria-labelledby="tabs-fonnte">
                            <div class="form-group">
                                <label>Passkey</label>
                                <input type="text" name="passkey_fonnte" class="form-control" required
                                    placeholder="Masukkan nomor WA CS" value="{{ $fonnte->token }}">
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <button class="btn btn-primary w-100" type="submit" id="form_submit_otp">Simpan</button>
        </form>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@push('script')
    <script>
        $(document).ready(function() {
            initOtp();

            $('#card_refresh_otp').on('overlay.removed.lte.cardrefresh', function() {
                initOtp();
            });
        });

        function cardRefreshOtp() {
            var cardRefresh = document.querySelector('#card_refresh_otp');
            cardRefresh.click();
        }

        function initOtp() {
            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            });

            $('#form_otp').submit(function(e) {
                e.preventDefault();

                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.setting.save') }}",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#form_submit_otp').attr('disabled', true);
                        $('#form_submit_otp').html('Loading...');
                    },
                    complete: function() {
                        $('#form_submit_otp').attr('disabled', false);
                        $('#form_submit_otp').html('Simpan');
                    },
                    success: function(response) {
                        swalToast(response.message, response.data);
                        cardRefreshOtp();
                    }
                });
            });
        }
    </script>
@endpush
