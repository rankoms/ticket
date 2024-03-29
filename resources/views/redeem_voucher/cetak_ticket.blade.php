<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Ticket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Sofia Pro Bold:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        @font-face {
            font-family: 'Sofia Pro Bold';
            src: url('{{ asset('fonts/Sofia_Pro_Bold.otf') }}');

        }

        .content {

            text-align: center;
        }

        @page {
            size: 4.13in 5.83in;
            margin: 0;
        }

        html,
        body {
            width: 4.13in;
            height: 5.83in;
            margin: 0;
            padding: 0;
            font-family: 'Sofia Pro Bold', 'Arial';
        }

        #utama td {
            text-align: left;
            padding-left: 20px;
            padding-right: 10px
        }

        #utama tr {
            min-height: 80px;
            height: 80px;
        }

        hr {

            width: 50%;
            border-radius: 100%;
            background-color: #000;
            border-top: 1px solid #000;
            margin-top: auto;
            margin-bottom: auto;
        }

        @media print {
            @page {
                size: 4.13in 5.83in;
                margin: 0;
            }

            #non-printable {
                display: none;
            }

            html,
            body {
                width: 4.13in;
                height: 5.83in;
                margin: 0;
                padding: 0;
                font-family: 'Sofia Pro Bold', 'Arial';
                overflow: hidden;
            }

            .content {
                text-align: center;
                height: 100%;
                padding: 0;
                margin: 0;
            }

            hr {

                width: 50%;
                border-radius: 100%;
                background-color: #000;
                border-top: 1px solid #000;
            }

        }
    </style>
</head>

<body>
    <a id="non-printable" style="width:100%" href="{{ route('pos_ticket.index') }}">
        <button>Kembali</button>
    </a>
    <div class="content">
        <table width="100%" id="utama" style="margin-top: 370px;">
            <tr>
                <td style="text-align: center ; font-size: 30px">
                    <div
                        style="font-size: {{ strlen($redeem_voucher->name) >= 25 ? 20 : 30 }}px;line-height: 1;text-align:center;">
                        <span>{{ $redeem_voucher->name }}</span>
                    </div>
                    <hr>

                    <div
                        style="font-size: {{ strlen($redeem_voucher->nama_perusahaan) >= 20 ? 20 : 30 }}px;line-height: 1;text-align:center;">
                        <span>
                            {{ $redeem_voucher->nama_perusahaan }}
                        </span>
                    </div>
                </td>
            </tr>
        </table>
        <button onclick="window.print();" id="non-printable">Cetak Halaman</button>
    </div>


</body>
<script>
    window.print();
    window.onafterprint = back;

    function back() {
        // window.history.back();
        window.location.href = "{{ route('redeem_voucher.ticket') }}"
    }
</script>

</html>
