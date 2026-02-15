{{-- FILTER --}}
<div class="row">
    <div class="col-12">
        <form action="{{ route('admin.pembayaran.export') }}" method="POST" target="_blank">
            @csrf
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="filter_tahun" name="tahun" required>
                            <option value="*">SEMUA TAHUN</option>
                            @foreach ($tahun as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="filter_prodi_id" name="prodi_id" required>
                            <option value="*">SEMUA PRODI</option>
                            <option value="sarjana">SARJANA</option>
                            <option value="pascasarjana">PASCASARJANA</option>
                            @foreach ($prodiS1 as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                            @foreach ($prodiPasca as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="filter_tanggal" name="tanggal" required>
                            <option value="*">SEMUA TANGGAL</option>
                            <option value="-">Pilih Tanggal Dibawah</option>
                        </select>
                    </div>
                    <div class="form-group d-none" id="form_group_range_tanggal">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <i class="far fa-calendar-alt"></i>
                                </span>
                            </div>
                            <input type="text" class="form-control float-right" id="filter_range_tanggal"
                                name="range_tanggal">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="filter_jenis_kelamin" name="jenis_kelamin" required>
                            @if (\Auth::user()->jenis_kelamin == '*')
                                <option value="*">SEMUA JENIS KELAMIN</option>
                                @foreach (BulkData::jenisKelamin as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            @else
                                <option value="{{ \Auth::user()->jenis_kelamin }}">
                                    {{ strtoupper(\Auth::user()->jenis_kelamin) }}</option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end mb-3 flex-wrap align-content-center">
                <div class="ml-0 ml-sm-2 mt-3 mt-sm-0 mobile-width">
                    <button class="btn btn-success mobile-width" type="submit" name="submit" value="excel">Export
                        Excel</button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            $('#filter_tahun').change(function(e) {
                table1.ajax.reload();
                changeInfo();
            });
            $('#filter_prodi_id').change(function(e) {
                table1.ajax.reload();
                changeInfo();
            });
            $('#filter_jenis_kelamin').change(function(e) {
                table1.ajax.reload();
                changeInfo();
            });

            //Date range picker
            $('#filter_range_tanggal').daterangepicker({
                locale: {
                    format: 'DD/MM/YYYY'
                }
            })

            $('#filter_range_tanggal').change(function(e) {
                table1.ajax.reload();
                changeInfo();
            });

            $('#filter_tanggal').change(function(e) {
                let tanggal = $(this).val();
                if (tanggal == "*") {
                    $("#form_group_range_tanggal").addClass('d-none');
                } else {
                    $("#form_group_range_tanggal").removeClass('d-none');
                }
                table1.ajax.reload();
            });
        });
    </script>
@endpush
