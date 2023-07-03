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
        font-family: 'Poppins';
        background: url('{{ asset('images/bg-pos.png') }}');
        background-size: cover;
        height: 100%;
    }

    .swal2-modal {
        width: 393px !important;
    }

    .swal-print .swal2-image {
        margin: 0 !important;
        place-self: center !important;
        height: auto;
        width: 100%;
    }

    .swal-wide {
        width: 650px !important;
    }

    .swal-wide .swal2-html-container {
        margin: 0 !important;
    }

    .swal-wide .container-form {
        margin-top: 43px;
    }

    .swal-wide .btn-success {

        background: #34B53A !important;
        border-radius: 10px;
    }

    .swal-wide .btn-outline-danger {

        color: #dc3545 !important;
        border: 1px solid #dc3545 !important;
        background: #fff !important;
    }

    .transaction-success {
        margin-top: 12px;
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 600;
        font-size: 27px;
        line-height: 40px;
        /* identical to box height */

        letter-spacing: -1px;

        color: #000000;
    }

    .please-check {

        font-family: 'Poppins';
        font-style: normal;
        font-weight: 400;
        font-size: 15px;
        line-height: 22px;
        /* identical to box height */

        letter-spacing: -1px;

        color: #C2C2C2;
    }

    .wrapper-button-swal {

        margin-top: 25px;
    }

    .swal2-confirm {
        font-family: 'Poppins';
        background-color: #34B53A;
        width: 200px;
    }

    .swal2-deny {

        font-family: 'Poppins';
        width: 200px;
        background: #992320;
    }

    #btn-submit {

        background: #992320;
        border-radius: 10px;
        border: none;
        font-family: 'Poppins';
        font-style: normal;
        font-weight: 600;
        font-size: 20px;
        line-height: 100%;
    }
</style>

<body>

    <div class="container">
        <div class="text-center" style="margin-top: 31px">
            <img src="{{ asset('/') . Auth::user()->logo }}" alt="Logo" height="91px" width="auto" />
        </div>
        <div class="pb-4 d-flex align-items-center justify-content-center dashboard">
            <section class="">
                <div class="row dashboard">
                    <form id="form-pos">
                        @csrf
                        <input type="hidden" name="event" id="event" value="{{ $event }}">
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <label for="fullname">Nama</label>
                                <input type="text" name="fullname" id="fullname" placeholder="Nama"
                                    class="form-control" required>
                                <div class="invalid-feedback d-block invalid">
                                    <div id="fullname_invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-12 col-12 position-relative">
                                <label for="perusahaan">Perusahaan</label>
                                <input type="text" name="perusahaan" id="perusahaan" placeholder="Perusahaan"
                                    class="form-control" required>
                                <div class="invalid-feedback d-block invalid">
                                    <div id="perusahaan_invalid-feedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <button id="btn-submit" type="submit" class="button-search">Submit <i
                                    class="fa fa-arrow-right ml-2"
                                    style="
                                position: inherit;
                                color: #fff;"></i></button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
    {{-- <a href="{{ route('admin.dashboard') }}" class="btn btn-info position-absolute"
        style="bottom: 10px; left:10px">Report</a> --}}
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


    function resetForm() {
        $('input').removeClass('invalid');
        $('select').removeClass('invalid');
        $('.invalid-feedback div').html('');
        $('textarea').val('');
        $('select').val('');
        $("form").trigger("reset");

    }

    var onBtnPrint = (id) => {
        Swal.close();
        var url = "{{ route('pos_ticket.cetak_name_pt', [':id']) }}";
        url = url.replace(':id', id);
        return window.location.href = url;
    };

    var onBtnSubmit = (formData) => {

        Swal.close();
        $.ajax({
            url: "{{ route('pos_ticket.store_name_pt') }}",
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

                Swal.fire({
                    imageUrl: '{{ asset('/') . Auth::user()->logo }}',
                    imageAlt: 'Custom image',
                    customClass: 'swal-print',
                    imageWidth: 171,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    html: `
                        <h3 class="transaction-success">Transaction is successful</h3>
                        <div class="please-check">Please check your e-ticket</div>
                        <div class="wrapper-button-swal">
                            <button onclick="onBtnPrint('${response.data.payment_code}')" class="btn btn-print-ticket swal2-confirm swal2-styled">Print Ticket <i class="fa fa-ticket-alt ml-2"></i></button></br>
                            <button onclick="onBtnClose()" class="btn btn-done swal2-deny swal2-styled">Done</button>
                        </div>
                        `
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
    };
    var onBtnClose = () => {
        Swal.close();
    };


    $('#form-pos').on('submit', function(e) {

        e.preventDefault();
        var quantity = $('#quantity').val();
        var harga_satuan = $('#category').find(":selected").data('harga_satuan');
        var total_harga = quantity * harga_satuan;
        var total_harga = formatRupiah(total_harga, 'Rp. ');

        var formData = $(this).serialize();
        Swal.fire({
            imageUrl: '{{ asset('/') . Auth::user()->logo }}',
            customClass: 'swal-wide',
            imageAlt: 'Custom image',
            imageWidth: 171,
            allowOutsideClick: false,
            backdrop: true,
            imageHeight: 183,
            showConfirmButton: false,
            html: `
            <h3 class="transaction-success">Confirm Purchase</h3>
            <div class="please-check">You are one step away from completing the purchase, are you sure?</div>
            <hr>
            <div class="container container-form">
                <div class="mb-4 row">
                    <div class="col-12">
                        <label class="float-left">Nama</label>
                        <input type="text" name="fullname" placeholder="Full Name"
                        class="form-control" required readonly value="${$('#fullname').val()}">
                    </div>
                </div>
                <div class="mb-4 row">
                    <div class="col-12">
                        <label class="float-left">Perusahaan</label>
                        <input type="text" name="payment_method" placeholder="Full Name" class="form-control" required readonly value="${$('#perusahaan').val()}">
                    </div>
                </div>
                    
            <div>
            <div class="wrapper-button-swal">
                <button onclick="onBtnSubmit('${formData}')" class="btn btn-print-ticket swal2-confirm swal2-styled btn-success">Confirm</button>
                <button onclick="onBtnClose()" class="btn btn-done swal2-deny swal2-styled btn-outline-danger">Cancel</button>
            </div>
            `
        })

    });

    function formatRupiah(angka, prefix) {
        var number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return prefix + rupiah;
    }
</script>

</html>
