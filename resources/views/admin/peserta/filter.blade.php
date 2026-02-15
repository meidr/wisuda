@push('css')
    <style>
        /* Custom CSS */
        @media (max-width: 575.98px) {
            .mobile-width {
                width: 100% !important;
                /* Apply w-100 only on mobile */
            }
        }
    </style>
@endpush

{{-- FILTER --}}
<div class="row">
    <div class="col-12">
        <form action="{{ route('admin.peserta.export') }}" method="POST" target="_blank">
            @csrf
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="tahun_id" name="tahun_id" required>
                            <option value="*">SEMUA TAHUN</option>
                            @foreach ($tahun as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="prodi_id" name="prodi_id" required>
                            <option value="*">SEMUA PROGRAM STUDI</option>
                            <option value="S1">SEMUA PRODI S1</option>
                            <option value="PASCA">SEMUA PRODI PASCA</option>
                            @foreach ($prodi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="jenis_kelamin" name="jenis_kelamin" required>
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
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="tanggal" name="tanggal" required>
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
                            <input type="text" class="form-control float-right" id="range_tanggal"
                                name="range_tanggal">
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <select class="form-control select2bs4 w-100" id="status_id" name="status_id" required>
                            <option value="*">SEMUA STATUS</option>
                            @foreach ($status as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
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
