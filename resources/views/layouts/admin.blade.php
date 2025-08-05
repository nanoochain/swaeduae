<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin | SwaedUAE</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('components.admin-navbar')
    <main>@yield('content')</main>
</body>
</html>
