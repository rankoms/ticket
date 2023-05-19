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
    @foreach ($pos_ticket as $key => $pos)
        <div class="content">
            {!! QrCode::size(110)->generate($pos->barcode_no) !!}
            <br>
            <br>
            <br>
            <img src="{{ $logo }}" alt="" width="auto" height="70px" style="margin-bottom: 20px">
            <br>
            <table width="100%" id="utama">
                <tr>
                    <td>
                        <span>Event</span>
                        <br>
                        <span>{{ $pos->event }}</span>
                    </td>
                    <td>Tempat<br>
                        <span>{{ $pos->vanue }}</span>
                    </td>
                </tr>
                <tr>
                    <td>Tanggal Event
                        <br>
                        <span>{{ $pos->date }}</span>
                    </td>
                    <td>Kategori
                        <br>
                        <span>{{ $pos->category }}</span>
                    </td>
                </tr>
                <tr>
                    <td>Harga
                        <br>
                        <span>Rp. {{ formatter_number($pos->harga_satuan) }}</span>
                    </td>
                    <td>ID Pesanan
                        <br>
                        <span>{{ $pos->payment_code }}</span>
                    </td>
                </tr>
            </table>
            {{-- <table width="100%">
                <tr>
                    <td>{!! QrCode::size(110)->generate($pos->barcode_no) !!}</td>
                    <td>
                        <img src="{{ $logo }}" alt="" width="55px" height="55px"
                            style="margin-bottom: 20px">
                    </td>
                </tr>

            </table> --}}
            <button onclick="window.print();" id="non-printable">Cetak Halaman</button>
        </div>
    @endforeach


</body>
<script>
    window.print();
    window.onafterprint = back;

    function back() {
        window.history.back();
    }
</script>

</html>
