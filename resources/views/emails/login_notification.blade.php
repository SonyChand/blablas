<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>New User Registered</title>
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
    </style>
</head>

<body>
    <div class="container">
        <h1>Hello Admin,</h1>
        <p>We noticed a new user registered to your system.</p>

        <p><strong>Account Details:</strong></p>
        <ul>
            <li><strong>Email:</strong> {{ $user->email }}</li>
            <li><strong>Name:</strong> {{ $user->name }}</li>
            <li><strong>Registered at:</strong> {{ $user->created_at }}</li>
            <li><strong>IP Address:</strong> {{ request()->ip() }}</li>
            <li><strong>Location:</strong>
                @if ($location)
                    {{ $location->countryName }}, {{ $location->regionName }}
                @else
                    Unknown
                @endif
            </li>
        </ul>

        <p>Thanks,<br>
            {{ config('app.name', 'Sistem') }}</p>
    </div>
</body>

</html>
