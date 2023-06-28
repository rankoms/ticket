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
    <link href="{{ url('css/examples.css') }}" rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Poppins';
            src: url('/fonts/Poppins/Poppins-Regular.ttf');
        }

        @font-face {
            font-family: 'Poppins';
            src: url('/fonts/Poppins/Poppins-SemiBold.ttf');
            font-weight: 700;
        }

        .swal2-modal {
            width: 393px !important;
        }

        .swal-print .swal2-image {
            margin: 0 !important;
            height: auto;
            width: 100%;
        }

        .swal-wide {
            width: 850px !important;
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

        body {
            width: 100%;
            height: 100%;
            background: url('../../images/redeem/panel.png') center top no-repeat;
            background-size: cover;
            position: relative;
        }

        .wrapping-logo {
            margin-bottom: 73px;
        }

        .logo-text {
            color: #FFF;
            font-size: 40px;
            font-family: Poppins;
            font-weight: 600;
            letter-spacing: -1px;
            margin-top: 10px;
        }

        h1 {
            color: #052440;
            font-size: 42px;
            font-family: Poppins;
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
            font-family: Poppins;
            text-align: center
        }

        #btn-submit {
            color: #FFF;
            font-size: 22px;
            font-family: Poppins;
            font-weight: 600;
            line-height: 100%;
            padding: 15px;
            border-radius: 15px;
            background: #6DD36B;
        }
    </style>
</head>

<!-- <body style="background-image:url('images/bg.png');"> -->

<form action="" id="form-voucher">
    <div class="min-vh-100 d-flex flex-row align-items-center">
        <div class="container">
            <div class="row justify-content-center text-center wrapping-logo">

                <div class="col">
                    <img src="{{ asset('images/redeem/logo.png') }}" alt="Logo" height="91px" width="166px" />
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
                        <input class="form-control mb-3" id="voucher" name="voucher" size="16" type="text"
                            placeholder="" autofocus autocomplete="off">
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
        document.getElementById("voucher").focus();
    }, 500);
    var onBtnClose = () => {
        Swal.close();
    };
    $('#form-voucher').on('submit', function(e) {
        e.preventDefault();
        var data = getJSON("{{ route('redeem_voucher.cek_redeem_voucher') }}", {
            _token: '{{ csrf_token() }}',
            voucher: $('#voucher').val()
        });

        if (data.meta.code != 200) {
            Swal.fire(
                'Gagal',
                data.meta.message,
                'error'
            )
            Swal.fire({
                title: 'E-Ticket Tidak Terdaftar',
                text: data.meta.message,
                icon: 'error',
                showConfirmButton: false,
                showCloseButton: true,

                background: 'rgba(255,255,255,0.4)',
                backdrop: `
					rgba(0,0,123,0.4)
					url("/images/bg3.png")
				`,
                color: '#000',
                showCloseButton: true,
            })

        } else {
            if (data.data.status == 1) {

                Swal.fire({
                    imageUrl: '{{ asset('images/redeem/already.png') }}',
                    customClass: 'swal-wide',
                    imageAlt: 'Custom image',
                    imageWidth: 400,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    html: `
            <h3 class="transaction-success">Your e-ticket has been redeemed</h3>
            <div class="please-check">Please return to the previous page</div>
            <hr>
            <div class="container container-form">
                <div class="mb-4 row">
                    <div class="row col-8 p-0 m-0">
                        <div class="col-12 p-0 m-0">
                            <label class="float-start">Full Name</label>
                            <input type="text" name="fullname" placeholder="Full Name"
                            class="form-control" required readonly value="${$('#fullname').val()}">
                        </div>
                        <div class="col-12 p-0 m-0">
                            <label class="float-start">Category</label>
                            <input type="text" name="category" placeholder="Full Name" class="form-control" required readonly value="${$('#category').find(":selected").html()}">
                        </div>
                    </div>
                    <div class="col-4">
                        {!! QrCode::size(110)->generate(11) !!}
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
                id = data.data.id;
                Swal.fire({
                    title: data.data.name,
                    showCloseButton: true,
                    icon: 'success',
                    background: 'rgba(255,255,255,0.4)',
                    backdrop: `
					rgba(0,0,123,0.4)
						url("/images/bg3.png")
					`,
                    color: '#000',
                    html: `<p>${data.data.email}</p>
								<p>${data.data.kategory}</p>
						`,
                    confirmButtonText: 'Redeem E-Ticket',
                }).then((result) => {
                    if (result.isConfirmed) {
                        var data = getJSON(
                            "{{ route('redeem_voucher.redeem_voucher_update_ticket') }}", {
                                _token: '{{ csrf_token() }}',
                                id: id
                            });

                        Swal.fire({
                            timer: 2000,
                            icon: 'success',
                            title: data.meta.message,
                            showConfirmButton: false,
                            background: 'rgba(255,255,255,0.4)',
                            backdrop: `
							rgba(0,0,123,0.4)
						url("/images/bg3.png")
						`,
                            color: '#000'
                        })
                    }
                    $('#voucher').val('');
                    $('#voucher').focus();
                });
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
