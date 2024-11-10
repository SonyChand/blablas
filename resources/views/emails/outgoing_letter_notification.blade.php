<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Aktivitas {{ $action }} surat keluar

    </title>
    <style>
        body {
            font-family: sans-serif;
            line-height: 1.5;
            color: #333;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #eee;
            background-color: #f9f9f9;
            border-radius: 8px;
        }

        h1 {
            color: #007bff;
            /* Blue color */
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            /* Blue color */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        /* Add Bootstrap CSS */
        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #212529;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
        }

        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #dee2e6;
            background-color: #f1f1f1;
        }

        .table tbody+tbody {
            border-top: 2px solid #dee2e6;
        }

        .table .table {
            background-color: #fff;
        }

        .text-primary {
            color: #007bff !important;
        }

        .text-warning {
            color: #ffc107 !important;
        }

        ul {
            padding-left: 20px;
        }

        ul li {
            list-style-type: disc;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Halo Admin,</h1>
        <p>Ada {{ $action }} data surat keluar pada sistem anda</p>

        <p><strong>Detail Data:</strong></p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Nama:</strong> {{ $user->name }}</li>
            <li><strong>Tanggal:</strong> {{ $letter->created_at }}</li>
            <li><strong>Nomor Surat:</strong> {{ $letter->letter_number }}</li>
            <li><strong>Jenis Surat:</strong>
                {{ $action == 'perubahan' ? ($letter['letter_type'] == $oldData['letter_type'] ? '- ' . ucwords(str_replace('_', ' ', $letter['letter_type'])) : '-') : '' . ucwords(str_replace('_', ' ', $letter['letter_type'])) }}
            </li>
            <li><strong>IP Address:</strong> {{ request()->ip() }}</li>
            <li><strong>Lokasi:</strong>
                @if ($location)
                    {{ $location->countryName }}, {{ $location->regionName }}
                @else
                    Tidak diketahui
                @endif
            </li>
        </ul>

        @if ($action == 'perubahan')
            <p><strong>Perubahan Data:</strong></p>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kolom</th>
                        <th>Sebelumnya</th>
                        <th>Sekarang</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($letter['letter_type'] != $oldData['letter_type'])
                        <tr>
                            <td><strong>Jenis Surat:</strong></td>
                            <td>{{ ucwords(str_replace('_', ' ', $oldData['letter_type'])) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $letter['letter_type'])) }}</td>
                        </tr>
                    @endif
                    @if ($letter['letter_number'] != $oldData['letter_number'])
                        <tr>
                            <td><strong>Nomor Surat:</strong></td>
                            <td>{{ $oldData['letter_number'] }}</td>
                            <td>{{ $letter['letter_number'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['letter_date'] != $oldData['letter_date'])
                        <tr>
                            <td><strong>Tanggal Surat:</strong></td>
                            <td>{{ \Carbon\Carbon::parse($oldData['letter_date'])->translatedFormat('d F Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($letter['letter_date'])->translatedFormat('d F Y') }}</td>
                        </tr>
                    @endif
                    @if ($letter['letter_nature'] != $oldData['letter_nature'])
                        <tr>
                            <td><strong>Sifat Surat:</strong></td>
                            <td>{{ $oldData['letter_nature'] }}</td>
                            <td>{{ $letter['letter_nature'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['letter_subject'] != $oldData['letter_subject'])
                        <tr>
                            <td><strong>Subjek Surat:</strong></td>
                            <td>{{ $oldData['letter_subject'] }}</td>
                            <td>{{ $letter['letter_subject'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['letter_destination'] != $oldData['letter_destination'])
                        <tr>
                            <td><strong>Tujuan Surat:</strong></td>
                            <td>
                                <ul>
                                    @foreach ($oldData['letter_destination'] as $dest)
                                        <li>{{ ucwords(str_replace('_', ' ', $dest)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($letter['letter_destination'] as $dest)
                                        <li>{{ ucwords(str_replace('_', ' ', $dest)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                    @if ($letter['sign_name'] != $oldData['sign_name'])
                        <tr>
                            <td><strong>Nama:</strong></td>
                            <td>{{ $oldData['sign_name'] }}</td>
                            <td>{{ $letter['sign_name'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['sign_nip'] != $oldData['sign_nip'])
                        <tr>
                            <td><strong>NIP:</strong></td>
                            <td>{{ $oldData['sign_nip'] }}</td>
                            <td>{{ $letter['sign_nip'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['sign_position'] != $oldData['sign_position'])
                        <tr>
                            <td><strong>Jabatan:</strong></td>
                            <td>{{ $oldData['sign_position'] }}</td>
                            <td>{{ $letter['sign_position'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['to'] != $oldData['to'])
                        <tr>
                            <td><strong>Yth Kepada:</strong></td>
                            <td>{{ $oldData['to'] }}</td>
                            <td>{{ $letter['to'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['letter_body'] != $oldData['letter_body'])
                        <tr>
                            <td><strong>Isi Surat:</strong></td>
                            <td>{{ $oldData['letter_body'] }}</td>
                            <td>{{ $letter['letter_body'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['letter_closing'] != $oldData['letter_closing'])
                        <tr>
                            <td><strong>Penutup Surat:</strong></td>
                            <td>{{ $oldData['letter_closing'] }}</td>
                            <td>{{ $letter['letter_closing'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['sign_name'] != $oldData['sign_name'])
                        <tr>
                            <td><strong>Nama Penandatangan:</strong></td>
                            <td>{{ $oldData['sign_name'] }}</td>
                            <td>{{ $letter['sign_name'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['sign_nip'] != $oldData['sign_nip'])
                        <tr>
                            <td><strong>NIP Penandatangan:</strong></td>
                            <td>{{ $oldData['sign_nip'] }}</td>
                            <td>{{ $letter['sign_nip'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['sign_position'] != $oldData['sign_position'])
                        <tr>
                            <td><strong>Jabatan Penandatangan:</strong></td>
                            <td>{{ $oldData['sign_position'] }}</td>
                            <td>{{ $letter['sign_position'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['attachment'] != $oldData['attachment'])
                        <tr>
                            <td><strong>Lampiran:</strong></td>
                            <td>{{ ucwords(str_replace('_', ' ', $oldData['attachment'])) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $letter['attachment'])) }}</td>
                        </tr>
                    @endif
                    @if ($letter['operator_name'] != $oldData['operator_name'])
                        <tr>
                            <td><strong>Nama Operator:</strong></td>
                            <td>{{ $oldData['operator_name'] }}</td>
                            <td>{{ $letter['operator_name'] }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif

        <p>Terima kasih,<br>
            {{ config('app.name', 'Sistem') }}</p>
    </div>
</body>

</html>
