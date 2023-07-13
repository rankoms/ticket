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
            height: 7.50in;
            margin: 0;
            padding: 0;
            font-family: 'Arial';
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
                size: 4.13in 7.50in;
                margin: 0;

            }

            #non-printable {
                display: none;
            }

            html,
            body {
                width: 4.13in;
                height: 7.50in;
                margin: 0;
                padding: 0;
                font-family: 'Arial';
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
            <div style="font-size: 36px">
                {{ $pos->category }}
            </div>
            <br>
            <br>
            <br>
            <table width="100%" style="font-size: 12px">
                <tr>

                    <th width="50%" align="left" style="padding-left:43px; padding-bottom: 67px">
                        {{ \Carbon\Carbon::parse($pos->created_at)->format('l, F jS Y \a\t h:i:s A') }}
                    </th>
                    <th>

                        {!! QrCode::size(110)->generate($pos->barcode_no) !!}
                    </th>
                </tr>
            </table>
            <br>
            <button onclick="window.print();" id="non-printable">Cetak Halaman</button>
        </div>
    @endforeach


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
