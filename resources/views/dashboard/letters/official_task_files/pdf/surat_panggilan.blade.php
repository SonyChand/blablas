<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <link rel="stylesheet" href="{{ public_path('assets/css/bootstrap.min.css') }}">
    <style>
        /* Add your custom styles here */
        body {
            font-size: 12pt;
            font-family: Arial, sans-serif;
            margin-left: 24pt;
            margin-right: 16pt;
            /* Add left margin */
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
    <table class="table-sm table-borderless w-100 mb-1"
        style="border-color: black !important;border-bottom-style:double !important;border-bottom:3px;line-height:1.2;">
        <tr>
            <td style="width: 15% !important;" class="text-center">
                <img src="{{ public_path('assets/assets/img/logos/logoDinkes.png') }}" alt="Logo" class="logo">
            </td>
            <td style="width: 85% !important;" class="text-center">
                <span style="font-size: 15pt;"><strong>PEMERINTAH KABUPATEN CIAMIS</strong></span><br>
                <span style="font-size: 15pt;"><strong>DINAS KESEHATAN</strong></span><br>
                <span>
                    Jalan. Mr. Iwa Kusumasomantri No 12<br>
                    Tlp. (0265) 771139, Faximile (0265) 773828 <br>
                    Website: www.dinkes.ciamiskab.go.id , Pos 46213
                </span>
            </td>
        </tr>
    </table><br>

    <p class="text-right">Ciamis, {{ $letter->letter_date }}</p>

    <table class="table table-sm table-borderless" style="line-height: 12px;">
        <tr>
            <td style="width: 15%;" class="mx-0">Nomor</td>
            <td>: {{ $letter->letter_number }}</td>
        </tr>
        <tr>
            <td>Sifat</td>
            <td>: {{ $letter->letter_nature }}</td>
        </tr>
        <tr>
            <td>Lampiran</td>
            <td>: {{ $letter->attachment }}</td>
        </tr>
        <tr>
            <td>Perihal</td>
            <td>: {{ $letter->letter_subject }}</td>
        </tr>
    </table>

    <p>Yth. {{ $letter->to }}</p>
    <div style="text-indent: 20px;" class="mt-0 pt-0">
        <p class="mb-0 pb-0">Di Tempat,</p><br>
        <p>{{ $letter->letter_body }}</p><br>
        <table class="table table-sm table-borderless mb-0" style="line-height: 12px;">
            <tr>
                <td style="width: 15%;">Hari</td>
                <td>: Selasa</td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td>: {{ $letter->date }}</td>
            </tr>
            <tr>
                <td>Pukul</td>
                <td>: 08.30 s/d selesai</td>
            </tr>
            <tr>
                <td>Tempat</td>
                <td>: Ruang Kepala Dinas</td>
            </tr>
            <tr>
                <td>Menghadap kepada</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: </td>
            </tr>
            <tr>
                <td>Untuk</td>
                <td>: </td>
            </tr>
        </table>
        <p>{{ $letter->letter_closure }}</p>
    </div>

    <table class="table table-sm table-borderless mt-5" style="page-break-after: avoid;">
        <tr class="text-center">
            <td style="width: 40%;"></td>
            <td style="width: 20%;"></td>
            <td style="width: 40%;">
                <span>Kepala Dinas Kesehatan Kab. Ciamis</span><br>
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td></td>
            <td>
                <img src="{{ public_path('assets/assets/img/logos/logoDinkes.png') }}" alt="Logo" class="logo"
                    style="width: 60px !important">
            </td>
        </tr>
        <tr class="text-center">
            <td></td>
            <td></td>
            <td>
                <strong>{{ $letter->sign_name }}</strong><br>
                {{ $letter->sign_position }}<br>
                NIP. {{ $letter->sign_nip }}
            </td>
        </tr>
    </table>
    <span>Tembusan:</span><br>
    Kepala UPTD Puskesmas Darnaraja
</body>

</html>
