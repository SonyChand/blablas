<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ public_path('assets\css\bootstrap.min.css') }}">
    <style>
        /* Add your custom styles here */
        body {
            font-size: 11pt;
            font-family: Arial, sans-serif;
            margin-left: 24pt;
            margin-right: 16pt;
            line-height: 1.2;
        }

        .logo {
            width: 75px;
            /* Adjust the width as needed */
            height: auto;
        }

        .table-borderless>tbody>tr>td,
        .table-borderless>tbody>tr>th,
        .table-borderless>tfoot>tr>td,
        .table-borderless>tfoot>tr>th,
        .table-borderless>thead>tr>td,
        .table-borderless>thead>tr>th {
            border: none;
        }
    </style>
</head>

<body>
    <table class="table-sm table-borderless w-100 mb-2"
        style="border-color: black !important;border-bottom-style:double !important;border-bottom:3px;line-height:1.2;">
        <tr>
            <td style="width: 15% !important;" class="text-center">
                <img src="{{ public_path('assets\assets\img\logos\logoDinkes.png') }}" alt="Logo" class="logo">
            </td>
            <td style="width: 85% !important;" class="text-center">
                <span style="font-size: 15pt;"><strong>PEMERINTAH KABUPATEN CIAMIS</strong></span><br>
                <span style="font-size: 15pt;"><strong>DINAS KESEHATAN</strong></span><br>
                <span>
                    Jalan Mr. Iwa Kusumasomantri No. 12<br>
                    Tlp. (0265) 771139, Faximile (0265) 773828 <br>
                    Website: www.dinkes.ciamiskab.go.id, Pos 46213
                </span>
            </td>
        </tr>
    </table><br>

    <table class="table table-lg border border-dark" style="line-height: 1.5;">
        <tr class="border border-dark">
            <td class="text-center border border-dark" colspan="2">LEMBAR DISPOSISI</td>
        </tr>
        <tr class="border border-dark">
            <td class="border border-dark">
                Surat dari : @foreach ($disposition->letter->source_letter as $src)
                    {{ ucwords(str_replace('_', ' ', $src)) }},
                @endforeach
                <br>
                <br>
                No Surat : {{ $disposition->letter->letter_number }}<br>
                Tgl Surat :
                {{ \Carbon\Carbon::parse($disposition->letter->letter_date)->translatedFormat('d F Y') }}<br>
            </td>
            <td class="border border-dark">
                Diterima Tgl :
                {{ \Carbon\Carbon::parse($disposition->disposition_date)->translatedFormat('d F Y') }}<br>
                No. Agenda :{{ $disposition->agenda_number }}<br>
                Sifat : {{ $disposition->letter->letter_nature }}<br><br>
                <input type="checkbox" {{ $disposition->letter_nature == 'sangat_segera' ? 'checked' : '' }}> Sangat
                Segera <br>
                <input type="checkbox" {{ $disposition->letter_nature == 'segera' ? 'checked' : '' }}> Segera <br>
                <input type="checkbox" {{ $disposition->letter_nature == 'rahasia' ? 'checked' : '' }}> Rahasia
            </td>
        </tr>
        <tr class="border border-dark">
            <td colspan="2" height="50px" class="border border-dark">
                Hal : {{ $disposition->letter->subject }}
            </td>
        </tr>
        <tr class="border border-dark">
            <td class="border border-dark">
                Diteruskan kepada Sdr. : <br><br>
                @foreach ($disposition->disposition_to as $dis)
                    <input type="checkbox" checked> {{ ucwords(str_replace('_', ' ', $dis)) }} <br>
                @endforeach
                <input type="checkbox"> ................. <br>
                <input type="checkbox"> ................. <br>
                <input type="checkbox"> ................. <br>
            </td>
            <td class="border border-dark">
                Dengan Hormat harap : <br><br>
                <input type="checkbox"> Tanggapan dan saran <br>
                <input type="checkbox"> Proses lebih lanjut <br>
                <input type="checkbox"> Koordinasi/konfirmasikan <br>
                <input type="checkbox"> ....................... <br>
            </td>
        </tr>
        <td colspan="2" height="100px" class="border border-dark">
            Catatan : <br>{{ $disposition->notes }}
        </td>
    </table>





    <table class="table table-sm table-borderless mt-5" style="page-break-after: avoid;line-height: 1.2 !important">
        <tr class="text-center">
            <td style="width: 40%;"></td>
            <td style="width: 20%;">
            </td>
            <td style="width: 40%;">
                <span>{{ $disposition->employee->position }} Kesehatan Kab. Ciamis</span>
            </td>
        </tr>
        <tr class="text-center" style="line-height: 1,1 !important">
            <td></td>
            <td></td>
            <td>
                <img src="{{ public_path('assets\assets\img\logos\logoDinkes.png') }}" alt="Logo" class="logo"
                    style="width: 60px !important">
            </td>
        </tr>
        <tr class="text-center" style="line-height: 1,1 !important">
            <td></td>
            <td></td>
            <td>
                <strong>{{ $disposition->employee->name }}</strong><br>
                {{ $disposition->employee->rank }}<br>
                NIP. {{ $disposition->employee->employee_identification_number }}
            </td>
        </tr>
    </table>
</body>

</html>
