<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Aktivitas {{ $action }} surat masuk</title>
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
        <p>Ada penambahan data surat masuk pada sistem anda</p>

        <p><strong>Detail Data:</strong></p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Nama:</strong> {{ $user->name }}</li>
            <li><strong>Tanggal:</strong> {{ $letter->created_at }}</li>
            <li><strong>Nomor Surat:</strong> {{ $letter->letter_number }}</li>
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
                    @if ($letter['source_letter'] != $oldData['source_letter'])
                        <tr>
                            <td><strong>Sumber/Asal Surat:</strong></td>
                            <td>
                                <ul>
                                    @foreach ($oldData['source_letter'] as $src)
                                        <li>{{ ucwords(str_replace('_', ' ', $src)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($letter['source_letter'] as $src)
                                        <li>{{ ucwords(str_replace('_', ' ', $src)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                    @if ($letter['addressed_to'] != $oldData['addressed_to'])
                        <tr>
                            <td><strong>Ditujukan kepada:</strong></td>
                            <td>
                                <ul>
                                    @foreach ($oldData['addressed_to'] as $src)
                                        <li>{{ ucwords(str_replace('_', ' ', $src)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($letter['addressed_to'] as $src)
                                        <li>{{ ucwords(str_replace('_', ' ', $src)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
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
                    @if ($letter['subject'] != $oldData['subject'])
                        <tr>
                            <td><strong>Perihal:</strong></td>
                            <td>{{ $oldData['subject'] }}</td>
                            <td>{{ $letter['subject'] }}</td>
                        </tr>
                    @endif
                    @if ($letter['attachment'] != $oldData['attachment'])
                        <tr>
                            <td><strong>Lampiran:</strong></td>
                            <td>{{ ucwords(str_replace('_', ' ', $oldData['attachment'])) }}</td>
                            <td>{{ ucwords(str_replace('_', ' ', $letter['attachment'])) }}</td>
                        </tr>
                    @endif
                    @if ($letter['forwarded_disposition'] != $oldData['forwarded_disposition'])
                        <tr>
                            <td><strong>Diteruskan/Disposisi:</strong></td>
                            <td>
                                <ul>
                                    @foreach ($oldData['forwarded_disposition'] as $src)
                                        <li>{{ ucwords(str_replace('_', ' ', $src)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                <ul>
                                    @foreach ($letter['forwarded_disposition'] as $src)
                                        <li>{{ ucwords(str_replace('_', ' ', $src)) }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endif
                    @if ($letter['file_path'] != $oldData['file_path'])
                        <tr>
                            <td><strong>File:</strong></td>
                            <td>
                                {{ $oldData['file_path'] != null ? 'Ada' : 'Tidak Ada' }}
                            </td>
                            <td>{{ $letter['file_path'] != null ? 'Ada' : 'Tidak Ada' }}</td>
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
