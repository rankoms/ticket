<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Bersama</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">


    <link rel="stylesheet" href="{{ url('css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="{{ url('css') }}/custom-admin.css">
</head>

<body>

    <div class="container">
        <div class="row mb-4 header">
            <div class="col-lg-3 col-sm-12 mb-3">
                <h1>Report</h1>
                <span>Laporan dashboard data pengunjung</span>
            </div>
            <div class="col-lg-4 col-sm-12 mb-3 text-center align-self-center">
                <h4 id="time-now">
                    {{ $tanggal }}
                </h4>
            </div>
            <div class="col-lg-5 col-sm-12 d-flex justify-content-end">
                <a href="javascript:history.back()" class="back">Back</a>
                @include('partials.user_dropdown')
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="align-items-center col-lg-3 col-sm-12 d-flex justify-content-center wrapper-chart p-0">
                        <div id="chart">
                        </div>
                    </div>
                    <div class="col-lg-9 col-sm-12">
                        <div class="row gx-1">
                            <div class="col-lg-3 col-sm-12 pr-1">
                                <div class="small-box bg-biru justify-content-between d-flex">
                                    <div class="icon">
                                        <i class="fa fa-clipboard-list"></i>
                                    </div>
                                    <div class="inner text-center">
                                        <p>Pending</p>
                                        <h3 id="jumlah_pending">{{ $jumlah_pending }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 pl-2 pr-1">
                                <div class="small-box bg-ijo text-center">
                                    <div class="inner text-center pt-3">
                                        <p>Total Scan Ticket</p>
                                        <h3 id="total_scan_ticket">{{ $jumlah_checkin + $jumlah_checkout }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 pl-2 pr-1">
                                <div class="small-box bg-teal justify-content-between d-flex">
                                    <div class="icon">
                                        <i class="fa fa-sign-in-alt"></i>
                                    </div>
                                    <div class="inner text-center">
                                        <p>Check-in</p>
                                        <h3 id="jumlah_checkin">{{ $jumlah_checkin }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-12 pl-2">
                                <div class="small-box bg-kuning justify-content-between d-flex">
                                    <div class="icon">
                                        <i class="fa fa-sign-out-alt"></i>
                                    </div>
                                    <div class="inner text-center">
                                        <p>Check-out</p>
                                        <h3 id="jumlah_checkout">{{ $jumlah_checkout }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="box bg-danger ticket-not-valid">
                                    <div class="align-items-center d-flex inner justify-content-center text-center">
                                        <p class="m-0">Ticket Not Valid</p>
                                        <h3>{{ $ticket_not_valid }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-lg-12">
                        <div id="line-chart"></div>
                    </div>
                </div>
                <div class="mt-4 row">
                    <div class="col-sm-12">
                        <table id="table_kategori" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Kategory</th>
                                    <th>Pending</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategory_aset as $key => $value)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <th>{{ isset($value['pending']) ? $value['pending'] : 0 }}</th>
                                        <th>{{ isset($value['checkin']) ? $value['checkin'] : 0 }}</th>
                                        <th>{{ isset($value['checkout']) ? $value['checkout'] : 0 }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="gate_table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Gate</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($gate_aset as $key => $value)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <th>{{ isset($value['checkin']) ? $value['checkin'] : 0 }}</th>
                                        <th>{{ isset($value['checkout']) ? $value['checkout'] : 0 }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <table id="jenis_tiket_table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Jenis Tiket</th>
                                    <th>Pending</th>
                                    <th>Check-in</th>
                                    <th>Check-out</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenis_tiket as $key => $value)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <th>{{ isset($value['pending']) ? $value['pending'] : 0 }}</th>
                                        <th>{{ isset($value['checkin']) ? $value['checkin'] : 0 }}</th>
                                        <th>{{ isset($value['checkout']) ? $value['checkout'] : 0 }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        @if (isset($is_current))
                            <a href="{{ route('excel_ticket_current', ['event' => $request->event]) }}"
                                class="btn btn-success">Export Excel</a>
                        @else
                            <a href="{{ route('excel_ticket', ['event' => $request->event]) }}"
                                class="btn btn-success">Export Excel</a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('mobile/js/jquery.min.js') }}"></script>



    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('js/apexcharts.js') }}"></script>

    <script>
        var options = {
            series: [{{ $jumlah_pending }}, {{ $jumlah_checkin }}, {{ $jumlah_checkout }}],
            chart: {
                type: 'pie',
            },
            dataLabels: {
                enabled: false
            },
            labels: ['Pending', 'Checkin', 'Checkout'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var piechart = new ApexCharts(document.querySelector("#chart"), options);
        piechart.render();





        var options = {
            series: [{
                name: "Pengunjung",
                data: [{{ $data_ticket_history }}]
            }],
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: true
                }
            },
            dataLabels: {
                enabled: true
            },
            stroke: {
                curve: 'straight'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: [{!! $label_ticket_history !!}],
            }
        };

        var chart = new ApexCharts(document.querySelector("#line-chart"), options);
        chart.render();
        var table_kategori = $('#table_kategori').DataTable({
            order: [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            destroy: true,
            // ajax: {
            //     url: "{{ route('dashboard_ticket.table_kategori_aset') }}",
            //     data: {
            //         event: '{{ $request->event }}',
            //         percent_report_current: '{{ isset($percent_report_current) ? $percent_report_current : null }}'
            //     },
            //     type: "GET"
            // },
            // columns: [{
            //     data: null,
            //     className: "dt-left editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.kategory;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.pending;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.checkin;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.checkout;
            //     },
            // }]
        });
        var table_gate = $('#gate_table').DataTable({
            order: [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            destroy: true,
            // ajax: {
            //     url: "{{ route('dashboard_ticket.table_gate') }}",
            //     data: {
            //         event: '{{ $request->event }}',
            //         percent_report_current: '{{ isset($percent_report_current) ? $percent_report_current : null }}'
            //     },
            //     type: "GET"
            // },
            // columns: [{
            //     data: null,
            //     className: "dt-left editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.gate;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.checkin;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.checkout;
            //     },
            // }]
        });
        var table_jenis_tiket = $('#jenis_tiket_table').DataTable({
            order: [
                [0, 'desc']
            ],
            dom: 'Bfrtip',
            buttons: [
                'excel'
            ],
            destroy: true,
            // ajax: {
            //     url: "{{ route('dashboard_ticket.table_jenis_tiket') }}",
            //     data: {
            //         event: '{{ $request->event }}',
            //         percent_report_current: '{{ isset($percent_report_current) ? $percent_report_current : null }}'
            //     },
            //     type: "GET"
            // },
            // columns: [{
            //     data: null,
            //     className: "dt-left editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.jenis_tiket;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.pending;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.checkin;
            //     },
            // }, {
            //     data: null,
            //     className: "dt-center editor-delete",
            //     orderable: false,
            //     "mRender": function(data, type, row) {
            //         return data.checkout;
            //     },
            // }]
        });
        setInterval(() => {
            // window.location.reload();

            var data = getJSON('{{ route('post_dashboard_ticket') }}', {
                _token: '{{ csrf_token() }}',
                event: '{{ $request->event }}',
                percent_report_current: '{{ isset($percent_report_current) ? $percent_report_current : null }}'
            });

            $('#time-now').html(data.data.tanggal);
            $('#jumlah_pending').html(data.data.jumlah_pending);
            $('#jumlah_checkin').html(data.data.jumlah_checkin);
            $('#jumlah_checkout').html(data.data.jumlah_checkout);
            $('#total_scan_ticket').html(parseInt(data.data.jumlah_checkout) + parseInt(data.data.jumlah_checkin));




            piechart.updateSeries([data.data.jumlah_pending, data.data.jumlah_checkin, data.data.jumlah_checkout]);


            chart.updateOptions({
                xaxis: {
                    categories: data.data.label_ticket_history
                },
                series: [{
                    data: data.data.data_ticket_history
                }],
            });
            // table_kategori.ajax.reload();
            // table_gate.ajax.reload();
            // table_jenis_tiket.ajax.reload();


        }, 5000);
    </script>
    <script></script>
    <script>
        $(document).ready(function() {

        });

        function getJSON(url, data, type = 'POST') {
            return JSON.parse($.ajax({
                type: type,
                url: url,
                data: data,
                dataType: 'json',
                global: false,
                async: false,
                success: function(msg) {

                }
            }).responseText);
        }
    </script>
</body>

</html>
