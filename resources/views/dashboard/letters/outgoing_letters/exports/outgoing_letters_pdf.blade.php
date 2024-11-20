<!DOCTYPE html>
<html>

<head>
    <title>Outgoing Letters</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
    </style>
</head>

<body>
    <h2>Outgoing Letters</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tipe Surat</th>
                <th>Nomor Surat</th>
                <th>Tanggal Surat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($letters as $index => $letter)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ ucwords(str_replace('_', ' ', $letter->letter_type)) }}</td>
                    <td>{{ $letter->letter_number }}</td>
                    <td>{{ $letter->letter_date }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
