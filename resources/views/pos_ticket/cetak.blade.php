<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Ticket</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
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
            font-family: 'Kanit', 'Arial';
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
                font-family: 'Kanit', 'Arial';
            }

            .content {
                text-align: center;
                height: 100%;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>


<body>
    <a id="non-printable" style="width:100%" href="{{ route('pos_ticket.index') }}">
        <button>Kembali</button>
    </a>
    <div class="content">
        <table width="100%" id="utama" style="margin-top: 300px;">
            <tr>
                <td style="text-align: center">
                    {{ $redeem_voucher->name }}
                    <hr>
                    {{ $redeem_voucher->nama_perusahaan }}
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
        window.location.href = "{{ route('pos_ticket.index') }}"
    }
</script>

</html>
