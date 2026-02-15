<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title text-white">Calon Mahasiswa Banat</h3>
        <div class="card-tools">
            <button type="button" class="btn btn-tool" id="card_refresh_cm_banat" data-card-widget="card-refresh"
                data-source="{{ url()->current() }}" data-source-selector="#card_refresh_content_cm_banat"
                data-load-on-init="false">
                <i class="fas fa-sync-alt text-white"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="remove"><i
                    class="fas fa-times text-white"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="maximize">
                <i class="fas fa-expand text-white"></i>
            </button>
            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                <i class="fas fa-minus text-white"></i>
            </button>
        </div>
    </div>
    <div class="card-body" id="card_refresh_content_cm_banat">
        <div class="row">
            <div class="col-md-8">
                <p class="text-center">
                    <strong>Calon Mahasiswa Banat {{ $tahunPelajaranAdmin }}</strong>
                </p>
                <div class="chart" style="height: 400px">
                    <canvas id="chart_calon_mahasiswa_banat"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <p class="text-center">
                    <strong>Jumlah</strong>
                </p>
                <div id="jumlah_cm_banat"></div>
            </div>
        </div>
    </div>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            initpesertaBanat();

            $('#card_refresh_cm_banat').on('overlay.removed.lte.cardrefresh', function() {
                initpesertaBanat();
            });
        });

        function initpesertaBanat() {
            $.ajax({
                type: "get",
                url: "{{ route('admin.dashboard.getDataProdi') }}",
                success: function(response) {
                    let dataProdi = response;
                    let areaChartData = {
                        labels: dataProdi['label_banat'],
                        datasets: [{
                            label: '',
                            backgroundColor: dataProdi['warna_banat'],
                            borderColor: dataProdi['warna_banat'],
                            data: dataProdi['jumlah_banat']
                        }, ],
                    }

                    let barChartData = $.extend(true, {}, areaChartData);
                    barChartData.datasets[0] = areaChartData.datasets[0];

                    new Chart($('#chart_calon_mahasiswa_banat').get(0).getContext('2d'), {
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
                    response.data.forEach(item => {
                        contentJumlah += `
                        <div class="progress-group">
                            <span class="progress-text">${item.prodi}</span>
                            <span class="float-right">${item.terisi_banat}</span>
                            <div class="progress progress-sm">
                                <div class="progress-bar bg-${item.color}" style="width: 100%">
                                </div>
                            </div>

                        </div>
                        `;
                    });
                    $('#jumlah_cm_banat').append(contentJumlah);
                }
            });
        }
    </script>
@endpush
