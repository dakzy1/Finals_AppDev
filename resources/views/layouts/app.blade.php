<!DOCTYPE html>
<html>
<head>
    <title>FitZone</title>
    <link rel="shortcut icon" href="{{ asset('images/Appdev_logo.png') }}" type="image/x-icon">
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 30px;
        }
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #aaa;
        }
        th, td {
            padding: 10px;
        }
        a, button {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    @yield('header') <!-- Ensure the header section is yielded -->
    @yield('content')
</body>
</html>