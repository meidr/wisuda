<div class="row">
    <div class="col-6">
        <div class="form-group">
            <select class="form-control select2bs4 w-100" id="tahun_id" required>
                <option value="*">SEMUA TAHUN</option>
                @foreach ($tahun as $item)
                    <option value="{{ $item->id }}" {{ $item->status == 'Y' ? 'selected' : '' }}>{{ $item->nama }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            @php
                $jk = Helper::getEnumValues('users', 'jenis_kelamin');
                $index = array_search('*', $jk);
                unset($jk[$index]);
            @endphp
            <select class="form-control select2bs4 w-100" id="jenis_kelamin" required>

                @if (Auth::user()->role_id == 1)
                    <option value="*">SEMUA JENIS KELAMIN</option>
                    @foreach ($jk as $item)
                        <option value="{{ $item }}">{{ strtoupper($item) }}</option>
                    @endforeach
                @else
                    @php
                        $key = array_search(Auth::user()->jenis_kelamin, $jk);
                        $jk = $jk[$key];
                    @endphp
                    <option value="{{ $jk }}">{{ strtoupper($jk) }}</option>
                @endif
            </select>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            $('#tahun_id').change(function(e) {
                document.getElementById('card_refresh_prodi').click();
            });
            $('#jenis_kelamin').change(function(e) {
                document.getElementById('card_refresh_prodi').click();
            });
        });
    </script>
@endpush
