<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('css/bootstrap-grid.css') }}">

    <title>Event Bersama</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Courier+Prime:ital,wght@0,400;0,700;1,400;1,700&display=swap');
    </style>
    <style>
        @font-face {
            font-family: 'Courier Prime', monospace;
            src: url('fonts/Courier_Prime');
        }

        body {
            font-family: 'Courier Prime';
            padding: 0;
        }

        .bg-yellow {
            background-color: #DCBD7E;
        }

        .full {
            height: 100%;
            min-height: 100vh;
        }

        .half {
            height: 100%;
            min-height: 50vh;
        }

        .atas {

            height: 49vh;
            min-height: auto;
        }

        .half-atas-bg {

            height: 48vh;
            min-height: auto;
        }

        .bg-white {
            background-color: white;
        }

        .bg-blue {
            background-color: #1F4161;
        }

        img {
            padding: 0;
            margin: auto;
        }

        .wrapper {

            text-align: center;
            display: flex;
            vertical-align: middle;
            align-items: center;
            place-content: center;
        }

        .bg-yellow span {
            color: black;
        }

        .bg-blue span {
            color: white;
        }

        .wrapper span {
            display: block;
            font-weight: 700;
        }

        #dashboard_new a {
            padding: 0;
            margin: 0;
            text-decoration: none;
        }

        @media (max-width: 1201px) {
            .full {
                height: 100%;
                max-height: 300px;
                min-height: 150px;
            }

            .half {
                height: 100%;
                max-height: 300px;
                min-height: 150px;
            }
        }
    </style>

</head>

<body>
    <div>
        <div class="row p-0 m-0" id="dashboard_new">
            <div class="col-xl-6 col-sm-12 p-2 m-0 position-relative full">
                <a href="{{ route('redeem_voucher.barcode') }}">
                    <div class="bg-yellow full wrapper">
                        <div>
                            <img src="{{ asset('images/home/ticket.svg') }}" alt="POS" width="123px"
                                height="123px">
                            <span>Redeem E-Voucher Only</span>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-6 col-sm-12 p-2 m-0 position-relative full">
                <a href="{{ route('redeem_voucher.ticket') }}">
                    <div class="bg-blue full wrapper">
                        <div>
                            <img src="{{ asset('images/home/printer.svg') }}" alt="POS" width="123px"
                                height="123px">
                            <span>Redeem E-voucher With Print Ticket</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>

</html>
