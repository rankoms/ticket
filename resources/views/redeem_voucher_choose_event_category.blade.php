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
                <h1>Redeem Voucher</h1>
                {{-- <span>Laporan dashboard data pengunjung</span> --}}
            </div>
            <div class="col-lg-6 col-sm-12 d-flex justify-content-end">
                @include('partials.user_dropdown')
            </div>
        </div>
        @php
            // $type = 'Redeem Voucher WIth Inject';
            // $type_array = ['redeem_only' => 'Redeem E-Voucher Only', 'redeem_with_voucher' => 'Redeem E-voucher With Print Ticket', 'redeem_with_inject' => 'Redeem E-voucher With Inject Ticket'];
        @endphp
        <div class="content d-flex align-items-center justify-content-center dashboard">
            <section class="">
                <div class="row dashboard">
                    <form action="">
                        <div class="row mb-4">
                            <h1>{{ type_array_redeem()[$type] }}</h1>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <select name="event" id="event" class="form-control" required>
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
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <select name="category" id="category" class="form-control" required>
                                    <option value="">Pilih Category</option>
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
    <script src="{{ asset('mobile/js/jquery.min.js') }}"></script>
</body>
<script>
    $('#event').on('change', function() {
        var dataCategories = getJSON('{{ route('redeem_voucher.category_select') }}', {
            'event': $(this).val()
        }, 'GET');
        $('#category option').remove();
        $('#category').append(`<option value="">Pilih Kategori</option>`)
        $('#category').append(`<option value="All Category">All Category</option>`)
        $.each(dataCategories.data, function(key, value) {
            $('#category').append(`
                <option value="${value.kategory}">${value.kategory}</option>
                `);
        })
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

</html>
