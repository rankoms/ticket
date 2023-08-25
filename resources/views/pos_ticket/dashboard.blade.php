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
<style>
    body {
        font-family: 'Poppins';
        background: url('{{ asset('images/bg-pos.png') }}');
        background-repeat: no-repeat;
        background-size: cover;
        height: 100%;
    }
</style>

<body>

    <div class="container">
        <div class="row mb-4 header">
            <div class="col-lg-3 col-sm-12 mb-3">
                <h1>Report</h1>
                <span>Laporan dashboard data pengunjung</span>
            </div>
            <div class="col-lg-4 col-sm-12 mb-3 text-center align-self-center">
                <h4 id="time-now">
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
                    <div
                        class="col-lg-2 col-sm-12 d-flex justify-content-center wrapper-chart p-0 border-0 bg-transparent">
                        <img src="{{ asset('/') . Auth::user()->logo }}" alt="Logo"
                            style="
                        width: 100%;
                        object-fit: contain;
                        max-height: 133px;" />
                    </div>
                    <div class="col-lg-10 col-sm-12">
                        <div class="row gx-1">
                            <div class="col-lg-4 col-sm-12 pl-2 pr-1">
                                <div class="small-box bg-ijo text-center">
                                    <div class="inner text-center pt-3">
                                        <p>Total Revenue</p>
                                        <h3>Rp. {{ number_format($total_revenue, 0, ',', '.') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12 pl-2 pr-1">
                                <div class="small-box bg-sold justify-content-around d-flex">
                                    <div class="icon">
                                        <i class="fa fa-shopping-cart"></i>
                                    </div>
                                    <div class="inner text-center pt-3">
                                        <p>Total Ticket Sold</p>
                                        <h3>{{ number_format($tiket_sold, 0, ',', '.') }}</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-sm-12 pl-2">
                                <div class="small-box bg-sold-day justify-content-around d-flex">
                                    <div class="icon">
                                        <i class="fa fa-ticket-alt"></i>
                                    </div>
                                    <div class="inner text-center">
                                        <p>Ticket Sold / Day</p>
                                        <h3>{{ number_format($tiket_sold_day, 0, ',', '.') }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-3">

                                <select name="user_id" id="user_id" class="form-control">
                                    <option value="">Pilih Admin</option>
                                    @foreach ($data_user as $key => $value)
                                        <option value="{{ $value->user->id }}"
                                            {{ $request->user_id == $value->user->id ? 'selected' : '' }}>
                                            {{ $value->user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <input type="text" name="dates" id="dates" class="form-control"
                                    value="{{ $tanggal }}">
                            </div>
                            <div class="col-sm-3">
                                <a href="{{ route('pos_ticket.excel_pos', ['user_id' => $request->user_id, 'start_date' => $request->start_date, 'end_date' => $request->end_date]) }}"
                                    class="btn btn-success">Export Excel</a>
                            </div>
                        </div>
                        <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Category</th>
                                    <th>Qty</th>
                                    <th>Date</th>
                                    <th>Admin By</th>
                                    <th>Total Harga</th>
                                    <th>Payment Method</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $no = 1;
                                @endphp
                                @foreach ($pos as $key => $value)
                                    <tr>
                                        <th>{{ $no++ }}</th>
                                        <th>{{ $value->name }}</th>
                                        <th>{{ $value->email }}</th>
                                        <th>{{ $value->no_telp }}</th>
                                        <th>{{ $value->category }}</th>
                                        <th>{{ $value->quantity }}</th>
                                        <th>{{ $value->date_minutes }}</th>
                                        <th>{{ $value->user->name }}</th>
                                        <th>Rp. {{ number_format($value->total_harga, 0, ',', '.') }}</th>
                                        <th>{{ $value->payment_method }}</th>
                                        <th><a href="{{ route('pos_ticket.cetak', ['id' => $value->payment_code]) }}"
                                                target="_blank" class="btn btn-success">Cetak</a>
                                        </th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-center">
                        {{-- @if (isset($is_current))
                            <a href="{{ route('excel_ticket_current', ['event' => $request->event]) }}"
                                class="btn btn-success">Export Excel</a>
                        @else
                            <a href="{{ route('excel_ticket', ['event' => $request->event]) }}"
                                class="btn btn-success">Export Excel</a>
                        @endif --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('mobile/js/jquery.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>



    <script src="{{ url('js/jquery.dataTables.min.js') }}"></script>

    <script>
        $(document).ready(function() {

            $(function() {
                $('#user_id').on('change', function() {
                    redirect_reload($(this).val(), '{{ $request->start_date }}',
                        '{{ $request->end_date }}');
                })

                function redirect_reload(user_id, start_date = "", end_date = "") {
                    url =
                        "{{ route('pos_ticket.dashboard', ['user_id' => 'val_user_id', 'start_date' => 'val_start_date', 'end_date' => 'val_end_date']) }}";
                    url = url.replace('amp;start_date', 'start_date');
                    url = url.replace('amp;end_date', 'end_date');
                    url = url.replace('val_user_id', user_id);
                    url = url.replace('val_start_date', start_date);
                    url = url.replace('val_end_date', end_date);
                    // console.log(url)
                    window.location.href = url;
                }
                $('input[name="dates"]').daterangepicker({
                    opens: 'left',
                    autoUpdateInput: false,
                    locale: {
                        cancelLabel: 'Clear'
                    }
                }, function(start, end, label) {
                    $('#dates').val(start.format('YYYY-MM-DD') + ' s/d ' + end.format('YYYY-MM-DD'))
                    redirect_reload('{{ $request->user_id }}', start.format('YYYY-MM-DD'), end
                        .format('YYYY-MM-DD'));
                });

                $('input[name="dates"]').on('cancel.daterangepicker', function(ev, picker) {
                    redirect_reload('{{ $request->user_id }}')
                });
            });
            $('#example').DataTable({

                dom: 'Bfrtip',
                buttons: [
                    'excel'
                ]
            });
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
