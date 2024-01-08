<!DOCTYPE html>
<!--
* CoreUI - Free Bootstrap Admin Template
* @version v4.2.1
* @link https://coreui.io
* Copyright (c) 2022 creativeLabs Łukasz Holeczek
* Licensed under MIT (https://coreui.io/license)
-->
<html lang="en">

<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Open Source Bootstrap Admin Template">
    <meta name="author" content="Łukasz Holeczek">
    <meta name="keyword" content="Bootstrap,Admin,Template,Open,Source,jQuery,CSS,HTML,RWD,Dashboard">
    <title>Redeem Ticket</title>
    <link rel="apple-touch-icon" sizes="57x57" href="assets/favicon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="assets/favicon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="assets/favicon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="assets/favicon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="assets/favicon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="assets/favicon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="assets/favicon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="assets/favicon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/favicon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/favicon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="assets/favicon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/favicon/favicon-16x16.png">
    <link rel="manifest" href="assets/favicon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="assets/favicon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <!-- Vendors styles-->
    <link rel="stylesheet" href="{{ url('css/simplebar.css') }}">
    <link rel="stylesheet" href="{{ url('css/simplebar2.css') }}">
    <!-- Main styles for this application-->
    <link href="{{ url('css/style.css') }}" rel="stylesheet">
    <!-- We use those styles to show code examples, you should remove them in your application.-->
    <link rel="stylesheet" href="{{ url('css/prism.css') }}">
    <link rel="stylesheet" href="{{ url('adminlte') }}/plugins/fontawesome-free/css/all.min.css">
    <link href="{{ url('css/examples.css') }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Sofia Pro Bold';
            src: url('{{ asset('fonts/Sofia_Pro_Bold.otf') }}');

        }

        .swal2-modal {
            width: 393px !important;
        }

        .swal2-popup {
            padding: 0 !important;
        }

        .swal-print .swal2-image {
            margin: 0 !important;
            height: auto;
            width: 100%;
        }

        .swal-small {

            width: 500px !important;
        }

        .swal-wide {
            width: 650px !important;
        }

        .swal-wide .swal2-html-container {
            margin: 0 !important;
        }

        .swal-wide .container-form {
            padding: 15px 37px;
        }

        .swal-wide .btn-success,
        .swal-small .btn-success {

            background: #34B53A !important;
            border-radius: 10px;
        }

        .swal-wide .btn-outline-danger,
        .swal-small .btn-outline-danger {

            color: #dc3545 !important;
            border: 1px solid #dc3545 !important;
            background: #fff !important;
        }

        .swal-wide label,
        .swal-small label {
            margin-bottom: 10px;
            font-family: 'Sofia Pro Bold';
            font-weight: 900;
            font-size: 16px;
        }

        .swal-wide input,
        .swal-small input {
            font-family: 'Sofia Pro Bold';
            font-weight: 900;
            font-size: 16px;
        }

        .swal-wide .btn-primary,
        .swal-small .btn-primary {
            background: #0069C9 !important;
            color: #fff !important;
            padding: 8px 47px;
            font-family: 'Sofia Pro Bold';
            font-size: 14px;
        }

        .swal-wide .btn-orange,
        .swal-small .btn-orange {
            background: #FFA500 !important;
            color: #fff !important;
            padding: 8px 47px;
            font-family: 'Sofia Pro Bold';
        }

        .transaction-success {
            margin: 0;
            padding: 0;
            font-family: 'Sofia Pro Bold';
            font-style: normal;
            font-weight: 600;
            font-size: 19px;

            letter-spacing: -1px;

            color: #000000;
        }

        .please-check {

            font-family: 'Sofia Pro Bold';
            font-style: normal;
            font-weight: 300;
            font-size: 15px;
            line-height: 22px;
            /* identical to box height */

            letter-spacing: -1px;

            color: #C2C2C2;
        }

        .wrapper-button-swal {

            /* margin-top: 25px; */
        }

        .swal2-confirm {
            font-family: 'Sofia Pro Bold';
            background-color: #34B53A;
            width: 200px;
        }

        .swal2-deny {
            font-size: 14px !important;
            font-family: 'Sofia Pro Bold';
            width: 200px;
            background: #992320;
        }

        body {
            width: 100%;
            height: 100%;
            background: url('{{ asset('images/bg/' . Auth::user()->bg) }}') center top no-repeat;
            background-size: cover;
            position: relative;
        }

        .wrapping-logo {
            margin-bottom: 73px;
        }

        .logo-text {
            color: #FFF;
            font-size: 40px;
            font-family: Sofia Pro Bold;
            font-weight: 600;
            letter-spacing: -1px;
            margin-top: 10px;
        }

        h1 {
            color: #052440;
            font-size: 42px;
            font-family: Sofia Pro Bold;
            font-weight: 700;
            letter-spacing: -1px;
            padding: 0;
            margin: 0;
        }

        .wrapping-scanner {
            margin-bottom: 36px;
        }

        .text-scanner {
            color: #878787;
            font-size: 17px;
            font-family: Sofia Pro Bold;
            text-align: center
        }

        #btn-submit {
            color: #FFF;
            font-size: 22px;
            font-family: Sofia Pro Bold;
            font-weight: 600;
            line-height: 100%;
            padding: 15px;
            border-radius: 15px;
            background: #6DD36B;
        }

        .qrcode {
            margin-bottom: 14px;
            text-align: center;
            font-weight: 700;
        }

        .no_qrcode {
            color: #000;
            font-size: 12px;
            font-family: Sofia Pro Bold;
            font-weight: 700;
            margin-top: 7px;
        }
    </style>
    <link href="{{ url('css/customs/redeem_voucher.css') }}" rel="stylesheet">
</head>

<!-- <body style="background-image:url('images/bg.png');"> -->

<form action="" id="form-voucher">
    <div class="min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center text-center wrapping-logo">

                <div class="col">
                    <img src="{{ asset('/') . Auth::user()->logo }}" alt="Logo" height="91px" width="auto" />
                    <div class="logo-text">
                        Redeem System
                    </div>
                </div>
            </div>
            <div class="row justify-content-center opacity-100">
                <div class="col-md-6">
                    <div class="card p-4">
                        <div class="row">
                        </div>
                        <div class="clearfix">
                            <div class="wrapping-scanner">
                                <h1 class="text-center">Please Scan E-Ticket</h1>
                                <div class="text-scanner">Please scan the barcode or enter your e-ticket number.</div>
                            </div>
                        </div>
                        <input class="form-control mb-3" id="voucher" name="voucher" type="text" placeholder=""
                            autofocus autocomplete="off">
                        <button class="btn " style="width:100%" type="submit" id="btn-submit"
                            autofocus="false">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        <a href="{{ route('user.logout') }}" class="btn btn-danger position-absolute"
            style="bottom: 10px; right:10px">Logout</a>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-info position-absolute"
            style="bottom: 10px; left:10px">Report</a>
    </div>
</form>
<!-- CoreUI and necessary plugins-->
<script src="{{ url('js/coreui.bundle.min.js') }}"></script>
<script src="{{ url('js/simplebar.min.js') }}"></script>
<script src="{{ url('js/sweetalert2@11.js') }}"></script>
<script type="text/javascript" src="{{ url('js/jquery.min.js') }}"></script>

<script>
    setInterval(() => {
        if (Swal.getPopup()) {
            // document.getElementById("barcode_no").focus();

        } else {

            document.getElementById("voucher").focus();
        }
    }, 500);
    var onBtnClose = () => {
        Swal.close();
    };


    $('#form-voucher').on('submit', function(e) {
        e.preventDefault();
        var data = getJSON("{{ route('redeem_voucher.cek_redeem_voucher') }}", {
            _token: '{{ csrf_token() }}',
            voucher: $('#voucher').val(),
            event: '{{ $event }}',
            category: '{{ $category }}'
        });

        if (data.meta.code != 200) {


            Swal.fire({
                imageUrl: '{{ asset('images/redeem/not_valid.png') }}',
                customClass: 'swal-wide, swal-small',
                imageAlt: 'Custom image',
                imageWidth: 200,
                timer: 5000,
                allowOutsideClick: false,
                showConfirmButton: false,
                html: `
            <h3 class="transaction-success">E-ticket are not valid</h3>
            <div class="please-check">Please try again</div>
            <hr>
            <div class="wrapper-button-swal">
                <button onClick="onBtnClose()" class="btn btn-back swal2-success swal2-styled btn-orange">Back</button>
            </div>`,
                showCancelButton: false,
                showConfirmButton: false,
                cancelButtonColor: '#d33',
                showCloseButton: true,
                allowOutsideClick: false,
                background: 'rgba(255,255,255,0.4)',
                backdrop: `
						rgba(0,0,123,0.4)
						url("/images/bg3.png")
					`,
                color: '#000'
            }).then((result) => {
                $('#voucher').val('');
                $('#voucher').focus();
                /* Read more about isConfirmed, isDenied below */
                // window.location = "{{ route('redeem_voucher.index') }}/" + $('#voucher').val()
            });

        } else {
            if (data.data.status == 1) {

                Swal.fire({
                    imageUrl: '{{ asset('images/redeem/already.png') }}',
                    customClass: 'swal-wide custom-swal',
                    imageAlt: 'Custom image',
                    imageWidth: 200,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    html: `
            <h3 class="transaction-success">Your e-ticket has been redeemed</h3>
            <h3 class="transaction-success">${data.data.redeem_date}</h3>
            <div class="please-check">Please return to the previous page</div>
            <hr>
            <div class="container container-form">
                <div class="row">
                    <div class="row col-8 p-0 m-0">
                        <div class="col-12 p-0 m-0 mb-3">
                            <label class="float-start">Full Name</label>
                            <input type="text" name="fullname" placeholder="Full Name"
                            class="form-control" required readonly disabled value="${data.data.name}">
                        </div>
                        <div class="col-12 p-0 m-0 mb-3">
                            <label class="float-start">Category</label>
                            <input type="text" name="category" placeholder="Full Name" class="form-control" required readonly value="${data.data.kategory}" disabled>
                        </div>
                        <div class="col-12 p-0 m-0 mb-3" style="display: none;">
                                <label class="float-start">Package Name</label>
                                <input type="text" name="category_detail" placeholder="category_detail" class="form-control" required readonly value="${data.data.nama_perusahaan}" disabled>
                            </div>
                        
                        <div class="col-12 p-0 m-0 mb-3"">
                            <label class="float-start">QR Code Wristband</label>
                            <input type="text" name="barcode_no" id="barcode_no" placeholder="QR Code Wristband" class="form-control" required readonly value="${data.data.barcode_no}">
                        </div>

                        <div class="col-12 p-0 m-0 mb-3" style="display: none;">
                            <label class="float-start">Seat Number</label>
                            <input type="text" name="seat_number" id="seat_number" placeholder="Seat Number" class="form-control" required readonly value="${data.data.seat}" disabled>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="qrcode">
                            QR Code E-Voucher
                        </div>
                        <div>
                            ${data.data.barcode_image}
                        </div>
                        <div class="no_qrcode">
                            ${data.data.kode}
                        </div>
                    </div>
                </div>
                    
            <div>
            <div class="wrapper-button-swal">
                <button onclick="onBtnClose()" class="btn btn-done swal2-deny swal2-styled btn-outline-danger">Back</button>
            </div>`,
                    showCancelButton: false,
                    showConfirmButton: false,
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Ticket Sudah Di gunakan',
                    showCloseButton: true,
                    allowOutsideClick: false,
                    background: 'rgba(255,255,255,0.4)',
                    backdrop: `
						rgba(0,0,123,0.4)
						url("/images/bg3.png")
					`,
                    color: '#000'
                }).then((result) => {
                    $('#voucher').val('');
                    $('#voucher').focus();
                    /* Read more about isConfirmed, isDenied below */
                    // window.location = "{{ route('redeem_voucher.index') }}/" + $('#voucher').val()
                });
            } else {
                Swal.fire({
                    imageUrl: '{{ asset('images/redeem/confirm.png') }}',
                    customClass: 'swal-wide custom-swal',
                    imageAlt: 'Custom image',
                    imageWidth: 200,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    html: `
            <h3 class="transaction-success">Data Confirmation</h3>
            <div class="please-check">Please make sure the data created is correct</div>
            <hr>
            <div class="container container-form">
                <form id="form-redeem-barcode">
                    <div class="row">
                        <div class="row col-8 p-0 m-0">
                            <div class="col-12 p-0 m-0 mb-3">
                                <label class="float-start">Full Name</label>
                                <input type="text" name="fullname" placeholder="Full Name"
                                class="form-control" required readonly disabled value="${data.data.name}">
                            </div>
                            <div class="col-12 p-0 m-0 mb-3">
                                <label class="float-start">Category</label>
                                <input type="text" name="category" placeholder="Full Name" class="form-control" required readonly value="${data.data.kategory}" disabled>
                            </div>
                            <div class="col-12 p-0 m-0 mb-3" style="display: none;">
                                <label class="float-start">Package Name</label>
                                <input type="text" name="category_detail" placeholder="category_detail" class="form-control" required readonly value="${data.data.nama_perusahaan}" disabled>
                            </div>
                            <div class="col-12 p-0 m-0 mb-3">
                                <label class="float-start">QR Code Wristband</label>
                                <input type="text" name="barcode_no" id="barcode_no" placeholder="QR Code Wristband" class="form-control" disabled>
                            </div>
                            <div class="col-12 p-0 m-0 mb-3" style="display: none;">
                                <label class="float-start">Seat Number</label>
                                <input type="text" name="seat_number" placeholder="Seat Number"
                                class="form-control" required readonly disabled value="${data.data.seat}">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="qrcode">
                                QR Code E-Voucher
                            </div>
                            <div>
                                ${data.data.barcode_image}
                            </div>
                            <div class="no_qrcode">
                                ${data.data.kode}
                            </div>
                        </div>
                    </div>
                    <div class="wrapper-button-swal">
                        <button class="btn btn-done swal2-success swal2-styled btn-primary">Confirm</button>
                        <button onclick="onBtnClose()" type="button" class="btn btn-done swal2-deny swal2-styled btn-outline-danger">Cancel</button>
                    </div>
                </form>
            <div>

            `,
                    showCancelButton: false,
                    showConfirmButton: false,
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Ticket Sudah Di gunakan',
                    showCloseButton: true,
                    allowOutsideClick: false,
                    background: 'rgba(255,255,255,0.4)',
                    backdrop: `
						rgba(0,0,123,0.4)
						url("/images/bg3.png")
					`,
                    color: '#000'
                }).then((result) => {
                    $('#voucher').val('');
                    $('#voucher').focus();
                    /* Read more about isConfirmed, isDenied below */
                    // window.location = "{{ route('redeem_voucher.index') }}/" + $('#voucher').val()
                });


                $('#form-redeem-barcode').on('submit', function(e) {
                    e.preventDefault();
                    // alert('oke');

                    Swal.close();
                    var result = getJSON(
                        "{{ route('redeem_voucher.redeem_voucher_update_barcode') }}", {
                            _token: '{{ csrf_token() }}',
                            id: data.data.id,
                            barcode_no: $('#barcode_no').val(),
                            seat_number: $('#seat_number').val()
                        });

                    Swal.fire({
                        imageUrl: '{{ asset('images/redeem/success.png') }}',
                        customClass: 'swal-wide, swal-small',
                        imageAlt: 'Custom image',
                        imageWidth: 200,
                        timer: 5000,
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        html: `
            <h3 class="transaction-success">Redemption was successful</h3>
            <div class="please-check">Ticket has been successfully entered</div>
            <hr>
            <div class="wrapper-button-swal">
                <button onClick="onBtnClose()" class="btn btn-done swal2-success swal2-styled btn-primary">Done</button>
            </div>`,
                        showCancelButton: false,
                        showConfirmButton: false,
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Done',
                        showCloseButton: true,
                        allowOutsideClick: false,
                        background: 'rgba(255,255,255,0.4)',
                        backdrop: `
						rgba(0,0,123,0.4)
						url("/images/bg3.png")
					`,
                        color: '#000'
                    }).then((result) => {
                        $('#voucher').val('');
                        $('#voucher').focus();
                        /* Read more about isConfirmed, isDenied below */
                        // window.location = "{{ route('redeem_voucher.index') }}/" + $('#voucher').val()
                    });

                })
            }
        }
        $('#voucher').focus();
        $('#voucher').val('');
        document.getElementById("voucher").focus();
    });
    document.getElementById("voucher").focus();

    $(".swal2-modal").css('background-color', '#000'); //Optional changes the color of the sweetalert 
    $(".swal2-container.in").css('background-color', 'rgba(43, 165, 137, 0.45)'); //changes the color of the overlay
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
