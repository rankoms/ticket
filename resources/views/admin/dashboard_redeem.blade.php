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
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
</head>

<body>

    <div class="container">
        <div class="row mb-4 header">
            <div class="col-lg-6 col-sm-12 mb-3">
                <h1>Report</h1>
                <span>Laporan dashboard data pengunjung</span>
            </div>
            <div class="col-lg-6 col-sm-12 d-flex justify-content-end">
                <a href="javascript:history.back()" class="back">Back</a>
                @include('partials.user_dropdown')
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-sm-5 p-0">
                        <input type="text" name="dates" id="dates" class="form-control"
                            value="{{ $date_range }}">
                    </div>
                </div>
                <div class="row">
                    <div class="align-items-center col-lg-3 col-sm-12 d-flex justify-content-center wrapper-chart">
                        <div id="chart">
                        </div>
                    </div>
                    <div class="col-lg-9 col-sm-12">
                        <div class="row">
                            <div class="col-lg-6 col-sm-12">
                                <div class="small-box bg-info justify-content-between d-flex">
                                    <div class="icon">
                                        <i class="fa fa-clipboard-list"></i>
                                    </div>
                                    <div class="inner text-center">
                                        <p>Pending</p>
                                        <h3>{{ $jumlah_belum }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-12">
                                <div class="small-box bg-success justify-content-between d-flex">
                                    <div class="icon">
                                        <i class="fa fa-sign-in-alt"></i>
                                    </div>
                                    <div class="inner text-center">
                                        <p>Redeem</p>
                                        <h3>{{ $jumlah_sudah }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 col-sm-12">
                                <div class="box bg-danger ticket-not-valid">
                                    <div class="align-items-center d-flex inner justify-content-center text-center">
                                        <p class="m-0">Redeem Not Valid</p>
                                        <h3>{{ $redeem_not_valid }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 row">
                    <div class="col-sm-12">
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Redeem</th>
                                    <th>Pending</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($kategory_aset as $key => $value)
                                    <tr>
                                        <th>{{ $key }}</th>
                                        <th>{{ isset($value['sudah']) ? $value['sudah'] : 0 }}</th>
                                        <th>{{ isset($value['belum']) ? $value['belum'] : 0 }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="{{ route('excel_redeem', ['start_date' => $request->start_date, 'end_date' => $request->end_date]) }}"
                            class="btn btn-success">Export Excel</a>
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
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



    <script>
        var options = {
            series: [{{ $jumlah_belum }}, {{ $jumlah_sudah }}],
            chart: {
                type: 'pie',
            },
            dataLabels: {
                enabled: false
            },
            labels: ['Pending', 'Redeem'],
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

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
    <script>
        $(document).ready(function() {

            $('input[name="dates"]').daterangepicker({
                opens: 'left',
                autoUpdateInput: false,
                locale: {
                    cancelLabel: 'Clear'
                }
            }, function(start, end, label) {
                $('#dates').val(start.format('YYYY-MM-DD') + ' s/d ' + end.format('YYYY-MM-DD'))
                redirect_reload('{{ $request->event }}', start.format('YYYY-MM-DD'), end
                    .format('YYYY-MM-DD'));
            });


            function redirect_reload(event, start_date = "", end_date = "") {
                url =
                    "{{ route('redeem_voucher.dashboard', ['start_date' => 'val_start_date', 'end_date' => 'val_end_date', 'event' => 'val_event']) }}";
                url = url.replace('amp;start_date', 'start_date');
                url = url.replace('amp;end_date', 'end_date');
                url = url.replace('amp;event', 'event');
                url = url.replace('val_start_date', start_date);
                url = url.replace('val_end_date', end_date);
                url = url.replace('val_event', event);
                // console.log(url)
                window.location.href = url;
            }
            $('#example').DataTable({
                order: [
                    [0, 'desc']
                ],
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });
        });
    </script>
</body>

</html>
