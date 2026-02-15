@push('css')
    <style>
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endpush
<div class="card card-success">
    <div class="card-header">
        Tes Kirim WhatsApp
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_tes" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_tes"
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

    <div class="card-body" id="card_refresh_content_tes">
        <form id="form_tes" action="{{ route('admin.setting.tes') }}" method="post">
            @csrf
            <div class="form-group">
                <label>Nomer HP Tujuan</label>
                <input type="number" name="nomor_hp" class="form-control" placeholder="Masukkan Hp Tujuan" required>
            </div>
            <button class="btn btn-success w-100" id="form_submit_tes">Kirim</button>
        </form>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            initTes();

            $('#card_refresh_tes').on('overlay.removed.lte.cardrefresh', function() {
                initTes();
            });
        });

        function cardRefreshTes() {
            var cardRefresh = document.querySelector('#card_refresh_tes');
            cardRefresh.click();
        }

        function initTes() {
            $('#form_tes').submit(function (e) { 
                e.preventDefault();
                $.ajax({
                    type: "POST",
                    url: "{{ route('admin.setting.tes') }}",
                    data: new FormData(this),
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#form_submit_tes').attr('disabled', true);
                        $('#form_submit_tes').html('Loading...');
                    },
                    complete: function() {
                        $('#form_submit_tes').attr('disabled', false);
                        $('#form_submit_tes').html('Simpan');
                    },
                    success: function(response) {
                        swalToast(response.message, response.data);
                        cardRefreshTes();
                        console.log(response);
                    }
                });
            });

        }
    </script>
@endpush
