<!-- Calendar -->
<div class="card bg-gradient-primary">
    <div class="card-header border-0">

        <h3 class="card-title">
            <i class="far fa-calendar-alt"></i>
            Calendar
        </h3>
        <!-- tools card -->
        <div class="card-tools">
            <!-- button with a dropdown -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown"
                    data-offset="-52">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="dropdown-menu" role="menu">
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#modal-tambah-kalender">Add
                        new event</a>
                </div>
            </div>

            <button type="button" class="btn btn-primary btn-sm" data-card-widget="card-refresh"
                data-source="{{ route('admin.dashboard') }}" data-source-selector="#calender" data-load-on-init="false"
                id="calender_refresh">
                <i class="fas fa-sync-alt"></i>
            </button>

            <button type="button" class="btn btn-primary btn-sm" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>

            <button type="button" class="btn btn-primary btn-sm" id="calender_maximize_temp">
                <i class="fas fa-expand"></i>
            </button>

            <button hidden type="button" class="btn btn-tool" data-card-widget="maximize" id="calender_maximize">
                <i class="fas fa-expand"></i>
            </button>

            <button type="button" class="btn btn-primary btn-sm" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>

        </div>
        <!-- /. tools -->
    </div>
    <!-- /.card-header -->
    <div class="card-body pt-0">
        <!--The calendar -->
        <div id="calendar" style="width: 100%;"></div>

        <!-- modal tambah kalender-->
        <div class="modal fade" id="modal-tambah-kalender" style="color:black" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCalender" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-kalender-header">Tambah Event
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="formTambahKalender" method="post" action="{{ route('operasi.kalender.tambah') }}">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <label for="modal-kalender-title" class="col-form-label">Title</label>
                                <input type="text" class="form-control" id="modal-kalender-title" name="title"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>Mulai</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#reservationdate" id="modal-kalender-start" name="start"
                                        required>
                                    <div class="input-group-append" data-target="#reservationdate"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Selesai</label>
                                <div class="input-group date" id="reservationdate2" data-target-input="nearest">
                                    <input type="text" class="form-control datetimepicker-input"
                                        data-target="#reservationdate2" id="modal-kalender-end" name="end" required>
                                    <div class="input-group-append" data-target="#reservationdate2"
                                        data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Warna</label>
                                <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
                                    <ul class="fc-color-picker" id="color-chooser">
                                        <li><a class="text-primary" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li><a class="text-warning" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li><a class="text-success" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li><a class="text-danger" href="#"><i class="fas fa-square"></i></a>
                                        </li>
                                        <li><a class="text-secondary" href="#"><i
                                                    class="fas fa-square"></i></a></li>
                                    </ul>
                                    <input type="text" class="form-control" style="color:rgba(0,0,0,0)"
                                        id="modal-kalender-warna" name="warna" required readonly>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.card-body -->
</div>
<!-- /.card -->

@push('script')
    <script>
        var calendar;
        $(function() {
            /* initialize the calendar
             -----------------------------------------------------------------*/

            //Date for the calendar events (dummy data)
            var date = new Date()
            var d = date.getDate(),
                m = date.getMonth(),
                y = date.getFullYear()

            var Calendar = FullCalendar.Calendar;
            var Draggable = FullCalendar.Draggable;

            var calendarEl = document.getElementById('calendar');

            // initiate first data calender 
            var events = [];
            @foreach ($kalender as $k)
                var data = {
                    "id": "{{ $k->id }}",
                    "title": "{{ $k->title }}",
                    "start": new Date("{{ $k->start }}"),
                    "end": new Date("{{ $k->end }}"),
                    "backgroundColor": "{{ $k->warna }}",
                    "borderColor": "{{ $k->warna }}",
                    "allDay": false
                };
                if (Date.parse(data.start) == Date.parse(data.end)) {
                    data.allDay = true
                }
                events.push(data);
            @endforeach
            calendar = new Calendar(calendarEl, {
                themeSystem: 'bootstrap',
                height: 700,

                //Random default events
                events: events,
                editable: true,
                selectable: true,
                select: function(start, end, allDay) {
                    $('#modal-kalender-start').val(start.startStr);
                    $('#modal-kalender-end').val(start.startStr);
                    $('#modal-kalender-warna').css('background-color', 'rgb(0, 86, 179)');
                    $('#modal-kalender-warna').val('rgb(0, 86, 179)');

                    $('#modal-tambah-kalender').modal('toggle')
                },
                eventDrop: function(info) {
                    var id = info.event.id;
                    var start = changeFormatDate(info.event.start);
                    var end = info.event.end;
                    if (end == null) {
                        end = start;
                    } else {
                        end = changeFormatDate(end);
                    }
                    var data = {
                        "start": start,
                        "end": end,
                        "title": info.event.title,
                        "warna": info.event.backgroundColor,
                        "_token": "{{ csrf_token() }}"
                    };
                    var url = "{{ route('operasi.kalender') }}/" + id + "/edit";
                    $.ajax({
                        type: "post",
                        url: url,
                        data: data,
                        success: function(response) {
                            // console.log(response)
                            swalToast(response.message, response.data);
                        }
                    });
                },
                eventClick: function(info) {
                    Swal.fire({
                        title: 'Yakin hapus data ?',
                        showCancelButton: true,
                        confirmButtonText: 'Iya',
                        cancelButtonText: 'Batal',
                        customClass: {
                            actions: 'my-actions',
                            cancelButton: 'order-1 right-gap',
                            confirmButton: 'order-2',
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            var id = info.event.id;
                            var url = "{{ route('operasi.kalender') }}/" + id + "/hapus";
                            var data = {
                                "_token": "{{ csrf_token() }}",
                                "_method": "delete"
                            }
                            $.ajax({
                                type: "post",
                                url: url,
                                data: data,
                                success: function(response) {
                                    swalToast(response.message, response.data);
                                    var event = calendar.getEventById(info.event
                                        .id);
                                    event.remove();
                                }
                            });
                        }
                    })
                }
            });

            calendar.render();
            // $('#calendar').fullCalendar()

        });
        $('#formTambahKalender').submit(function(e) {
            e.preventDefault();
            var url = "{{ route('operasi.kalender.tambah') }}";
            var data = $(this).serialize();
            $.ajax({
                type: "post",
                url: url,
                data: data,
                success: function(response) {
                    var kalender = response.kalender;
                    $('#modal-tambah-kalender').modal('toggle')
                    swalToast(response.message, response.data);
                    var event = {
                        id: kalender.id,
                        title: kalender.title,
                        start: new Date(kalender.start),
                        end: new Date(kalender.end),
                        backgroundColor: kalender.warna,
                        backgroundBorder: kalender.warna,
                        allDay: false,
                    }
                    if (Date.parse(kalender.start) == Date.parse(kalender.end)) {
                        event.allDay = true
                    }
                    calendar.addEvent(event);

                    $('#modal-kalender-start').val('');
                    $('#modal-kalender-end').val('');
                    $('#modal-kalender-title').val('');
                }
            });
        });

        $('#color-chooser > li > a').click(function(e) {
            e.preventDefault()
            // Save color
            currColor = $(this).css('color')
            // Add color effect to button
            $('#modal-kalender-warna').css('background-color', currColor);
            $('#modal-kalender-warna').val(currColor);

        })

        $('#calender_refresh').click(function() {
            calendar.render();
        });

        $('#calender_maximize_temp').click(function() {
            document.querySelector('#calender_maximize').click();
            refreshCalenderWithDelay();
        });

        $('#navbar_burger').click(function() {
            refreshCalenderWithDelay();
        });

        function refreshCalenderWithDelay() {
            setTimeout(() => {
                document.querySelector('#calender_refresh').click();
            }, 500);
        }

        function changeFormatDate(date) {
            var formatDate = [{
                year: 'numeric'
            }, {
                month: 'numeric'
            }, {
                day: 'numeric'
            }];

            function format(m) {
                let f = new Intl.DateTimeFormat('en', m);
                return f.format(date);
            }
            return formatDate.map(format).join('-');
        }
    </script>
@endpush
