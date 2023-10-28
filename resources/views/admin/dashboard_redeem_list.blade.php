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
                                    <th>No</th>
                                    <th>Event</th>
                                    <th>Category</th>
                                    <th>E-voucher</th>
                                    <th>Nama</th>
                                    <th>Ticket</th>
                                    <th>Seat Number</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $i = 1;
                                @endphp
                                @foreach ($redeem_voucher_success as $key => $value)
                                    <tr>
                                        <th>{{ $i }}</th>
                                        <th>{{ $value->event }}</th>
                                        <th>{{ $value->kategory }}</th>
                                        <th>{{ $value->kode }}</th>
                                        <th>{{ $value->name }}</th>
                                        <th>{{ $value->barcode_no }}</th>
                                        <th>{{ $value->seat_number }}</th>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <a href="{{ route('excel_redeem') }}" class="btn btn-success">Export Excel</a>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" --}}
    {{-- integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"> --}}
    {{-- // </script> --}}



    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('js/apexcharts.js') }}"></script>

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

            $('#example').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });
        });
    </script>
</body>

</html>
