<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Event Bersama</title>
    <link rel="stylesheet" href="{{ asset('bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ url('css') }}/custom-admin.css">
</head>

<body>

    <div class="container">
        <div class="row mb-4 header">
            <div class="col-lg-6 col-sm-12">
                <h1>Report</h1>
                <span>Laporan dashboard data pengunjung</span>
            </div>
            <div class="col-lg-6 col-sm-12 d-flex justify-content-end">
                @include('partials.user_dropdown')
            </div>
        </div>
        <div class="content d-flex align-items-center justify-content-center dashboard">
            <section class="">
                <div class="row dashboard">
                    <form action="">
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <select name="report" id="report" class="form-control" required>
                                    <option value="">Pilih Report</option>
                                    <option value="ticket">Ticket</option>
                                    <option value="redeem_voucher">Redeem (Count)</option>
                                    <option value="redeem_voucher_list">Redeem (List)</option>
                                    <option value="pos">POS</option>
                                    <option value="seating">Seating Chair</option>
                                </select>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <select name="event" id="event" class="form-control">
                                    <option value="">Pilih Event</option>
                                    @foreach ($event as $key => $value)
                                        <option value="{{ $value->event }}">
                                            {{ $value->event }}
                                        </option>
                                    @endforeach
                                </select>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="button-search">Search</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
