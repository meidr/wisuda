@php
    $inValue = in_array($value, $data);
    if (!$inValue) {
        if ($value == '') {
            $inValue = true;
        }
    }
@endphp
<select class="form-control select2bs4 w-100" name="{{ $name }}" id="{{ $name }}" disabled>
    <option value="">Pilih</option>
    @foreach ($data as $p)
        <option value="{{ $p }}" {{ $p == $value ? 'selected' : '' }}
            {{ !$inValue && strtolower($p) == 'lainnya' ? 'selected' : '' }}>
            {{ $p }}
        </option>
    @endforeach
</select>
<input type="text" class="form-control mt-2 {{ !$inValue ? '' : 'd-none' }}" name="{{ $name }}"
    id="{{ $name }}_lainnya" value="{{ !$inValue ? $value : '' }}" placeholder="{{ $placeholder }}"
    {{ !$inValue ? 'readonly' : 'disabled' }}>

@push('script')
    <script>
        function {{ $function }}() {
            $('#{{ $name }}').change(function() {
                let $getValue = $(this).val();
                if ($getValue != 'Lainnya') {
                    $('#{{ $name }}_lainnya').prop('disabled', true);
                    $('#{{ $name }}_lainnya').addClass('d-none');
                } else {
                    $('#{{ $name }}_lainnya').removeAttr('disabled');
                    $('#{{ $name }}_lainnya').removeClass('d-none');
                }
            });
        }
    </script>
@endpush
