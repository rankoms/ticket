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

        table td {
            text-align: left;
            padding-left: 20px;
        }

        table tr {
            height: 60px;
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
                padding: 50px 0 0 0;
                height: 100%;
            }
        }
    </style>
</head>

<body>
    @foreach ($pos_ticket as $key => $pos)
        <div class="content">
            <img src="{{ $logo }}" alt="" width="70px" height="70px" style="margin-bottom: 20px">
            <br>
            <h5>{{ $pos->category }}</h5>
            {!! QrCode::size(70)->generate($pos->barcode_no) !!}
            <p>{{ $pos->barcode_no }}</p>
            {{-- <div>
                RACER : {{ $pos->name }} <br>
                CLUB : {{ $pos->club }} <br>
                NO START : {{ $pos->no_start }}<br>
                UNDIAN : {{ $pos->undian }}
            </div> --}}
            <table width="100%">
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
                    <td>Category
                        <br>
                        <span>{{ $pos->category }}</span>
                    </td>
                </tr>
                <tr>
                    <td>Harga
                        <br>
                        <span>{{ $pos->harga_satuan }}</span>
                    </td>
                    <td>ID Pesanan
                        <br>
                        <span>{{ $pos->payment_code }}</span>
                    </td>
                </tr>
            </table>
            <button onclick="window.print();" id="non-printable">Cetak Halaman</button>
        </div>
    @endforeach


</body>
<script>
    window.print();
</script>

</html>
