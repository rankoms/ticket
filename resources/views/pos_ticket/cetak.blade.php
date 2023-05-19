<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Ticket</title>
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
    @foreach ($pos_ticket as $key => $pos)
        <div class="content">
            {!! QrCode::size(110)->generate($pos->barcode_no) !!}
            <br>
            <br>
            <img src="{{ $logo }}" alt="" width="110px" height="110px" style="margin-bottom: 20px">
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
</script>

</html>
