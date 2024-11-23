<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
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
    <h2>{{ $title }}</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Posisi</th>
                <th>Alias</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($masters as $index => $master)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $master->employee->position }}</td>
                    <td>{{ $master->alias }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
