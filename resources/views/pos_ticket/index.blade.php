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

<style>
    body {
        /* background: url('{{ asset('bg-pos.jpg') }}'); */
        background-repeat: round;
        height: 100%;
    }
</style>

<body>

    <div class="container">
        <div class="row mb-4 header">
            <div class="col-lg-6 col-sm-12">
                <h1>POS</h1>
                <span>Masukan data pengunjung</span>
            </div>
            <div class="col-lg-6 col-sm-12 d-flex justify-content-end">
                @include('partials.user_dropdown')
            </div>
        </div>
        <div class="pb-4 d-flex align-items-center justify-content-center dashboard">
            <section class="">
                <div class="row dashboard">
                    <form id="form-pos">
                        @csrf
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
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <select name="category" id="category" class="form-control">
                                    <option value="">Pilih Category</option>
                                </select>
                                <i class="fa fa-chevron-down"></i>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <input type="text" name="harga_satuan" id="harga_satuan" placeholder="Harga Satuan"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <input type="text" name="quantity" id="quantity" placeholder="Quantity"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <input type="text" name="total_harga" id="total_harga" placeholder="Total Harga"
                                    class="form-control" readonly>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <input type="text" name="name" id="name" placeholder="Masukan Nama"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <input type="email" name="email" id="email" placeholder="Masukan Email"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <input type="text" name="no_telp" id="no_telp" placeholder="Masukan No HP"
                                    class="form-control">
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button type="submit" class="button-search">Submit</button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    <script src="{{ asset('js/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('mobile/js/jquery.min.js') }}"></script>
</body>

<script src="{{ url('js/sweetalert2@11.js') }}"></script>
<script>
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
    $('#event').on('change', function(e) {
        var data = getJSON("{{ route('pos_ticket.category_select') }}", {
            _token: '{{ csrf_token() }}',
            event: $(this).val()
        });
        $('#category').find('option').not(':first').remove();
        $.each(data.data, function(key, value) {
            $('#category').append(`
                <option value="${value['category']}" data-harga_satuan="${value['harga_satuan']}">${value['category']}</option>
            `);
        });
    });

    $('#category').on('change', function() {
        $('#harga_satuan').val(formatRupiah($(this).find('option:selected').attr("data-harga_satuan")));
    });
    $('#quantity').on('change keyup keydown', function() {
        var harga_satuan = remove_titik($('#harga_satuan').val());
        var quantity = $(this).val();
        var total_harga = parseInt(harga_satuan) * parseInt(quantity);
        total_harga = total_harga ? total_harga : 0;
        $('#total_harga').val(formatRupiah(total_harga));
    });

    function remove_titik(angka) {

        var regex = /[.,\s]/g;

        var result = angka.replace(regex, '');
        return result;
    }

    function formatRupiah(bilangan) {
        var number_string = bilangan.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah
    }

    function resetForm() {
        $('input').removeClass('invalid');
        $('select').removeClass('invalid');
        $('.invalid-feedback div').html('');
        $('textarea').val('');
        $('select').val('');
        $('input').val('');

    }

    $('#form-pos').on('submit', function(e) {

        e.preventDefault();
        var formData = $(this).serialize();
        $.ajax({
            url: "{{ route('pos_ticket.store') }}",
            method: 'POST',
            data: formData,
            global: false,
            async: false,
            dataType: 'json',
            beforeSend: function() {

            },
            success: function(response) {
                const meta = response.meta;
                resetForm();
                $('#name').focus();

                Swal.fire({
                    title: meta.message,
                    icon: 'success',
                    showDenyButton: true,
                    confirmButtonText: 'OK',
                    denyButtonText: `Cetak Ticket`,
                    denyButtonColor: '#3085d6',
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {

                    } else if (result.isDenied) {
                        // Swal.fire('Changes are not saved', '', 'info')
                        var url = "{{ route('pos_ticket.cetak', [':id']) }}";
                        url = url.replace(':id', response.data.payment_code);
                        return window.location.href = url;
                    }
                })
            },
            error: function(error) {

                const data = JSON.parse(error.responseText);

                if (data.errors) {
                    var idx = 0;

                    $.each(data.errors, function(key, value) {
                        $('#' + key.split('.')[0]).addClass('invalid');
                        $('#' + key.split('.')[0] + '_invalid-feedback').html(
                            value
                            .join(' '));

                        if (idx == 0) {
                            $('#' + key.split('.')[0]).focus();
                        }

                        idx++;
                    });
                } else {
                    Swal.fire(
                        'Fail',
                        error.responseJSON.message,
                        'error'
                    );
                }
            },
        });
    });
</script>

</html>
