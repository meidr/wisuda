<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Wisuda</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_prodi" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_cm_banat"
                data-load-on-init="false">
                <i class="fas fa-sync-alt"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body" id="card_refresh_content_cm_banat">
        <div class="row">
            <div class="col-md-8">
                <p class="text-center">
                    <strong>Wisuda</strong>
                </p>
                <div class="chart" style="height: 400px">
                    <canvas id="chart_prodi"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <p class="text-center">
                    <strong>Jumlah</strong>
                </p>
                <div id="jumlah_prodi"></div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            initDaurah();

            $('#card_refresh_prodi').on('overlay.removed.lte.cardrefresh', function() {
                initDaurah();
            });
        });

        function initDaurah() {
            $.ajax({
                type: "get",
                url: "{{ route('admin.dashboard.getDaurah') }}",
                data: {
                    tahun_id: $('#tahun_id').val(),
                    jenis_kelamin: $('#jenis_kelamin').val()
                },
                success: function(response) {
                    let dataProdi = response;
                    let areaChartData = {
                        labels: dataProdi['label'],
                        datasets: [{
                            label: '',
                            backgroundColor: dataProdi['warna'],
                            borderColor: dataProdi['warna'],
                            data: dataProdi['jumlah']
                        }, ],
                    }

                    let barChartData = $.extend(true, {}, areaChartData);
                    barChartData.datasets[0] = areaChartData.datasets[0];

                    new Chart($('#chart_prodi').get(0).getContext('2d'), {
                        type: 'bar',
                        data: barChartData,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            datasetFill: false,
                            legend: {
                                display: false
                            },
                        },
                    })

                    // jumlah
                    let contentJumlah = '';
                    let total = 0;
                    response.data.forEach(item => {
                        console.log(item);
                        contentJumlah += `
                        <div class="progress-group">
                            <span class="progress-text">${item.label}</span>
                            <span class="float-right">${item.jumlah}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-${item.warna}" style="width: 100%">
                                </div>
                            </div>
                        </div>
                        `;
                        total += item.jumlah
                    });
                    contentJumlah += `
                    <div class="progress-group">
                        <span class="progress-text"><b>TOTAL</b></span>
                        <span class="float-right"><b>${total}</b></span>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-dark" style="width: 100%">
                            </div>
                        </div>
                    </div>
                    `;
                    $('#jumlah_prodi').append(contentJumlah);
                }
            });
        }
    </script>
@endpush
