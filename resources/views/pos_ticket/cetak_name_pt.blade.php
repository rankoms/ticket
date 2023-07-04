<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Cetak Ticket</title>
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
            overflow: hidden;
        }

        #utama td {
            text-align: left;
            /* padding-left: 10px;
            padding-right: 10px; */
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
                height: 300%;
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
    <a id="non-printable" style="width:100%" href="{{ route('pos_ticket.name_pt') }}">
        <button>Kembali</button>
    </a>
    @foreach ($pos_ticket as $key => $pos)
        <div class="content">
            <table width="100%" id="utama" style="margin-top: 370px;">
                <tr>
                    <td style="text-align: center ; font-size: 30px">
                        <div
                            style="font-size: {{ strlen($pos->name) >= 25 ? 20 : 30 }}px;line-height: 1;text-align:center;">
                            <span>{{ $pos->name }}</span>
                        </div>
                        <hr>
                        <div
                            style="font-size: {{ strlen($pos->category) >= 40 ? 20 : 30 }}px;line-height: 1;text-align:center;">
                            <span>
                                {{ $pos->category }}
                            </span>
                        </div>
                    </td>
                </tr>
            </table>
            <button onclick="window.print();" id="non-printable">Cetak Halaman</button>
        </div>
    @endforeach


</body>
<script>
    window.print();
    window.onafterprint = back;

    function back() {
        // window.history.back();
        window.location.href = "{{ route('pos_ticket.name_pt') }}"
    }
</script>

</html>
