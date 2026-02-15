@include('admin.pembayaran.tabel')
@include('admin.pembayaran.pembayaran')
@push('script')
    <script>
        function initPembayaran() {
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
        }
    </script>
@endpush
