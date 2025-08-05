<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'SwaedUAE')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
</head>
<body>
    <nav class="navbar">
        <a href="{{ url('/') }}">Home</a>
        <a href="{{ url('/about') }}">About</a>
        <a href="{{ url('/contact') }}">Contact</a>
        <a href="{{ url('/faq') }}">FAQ</a>
        @auth
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" style="background:none;border:none;color:#fff;cursor:pointer;">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Register</a>
        @endauth
    </nav>

    <div class="container">
        @yield('content')
    </div>

    <footer>
        &copy; {{ date('Y') }} SwaedUAE. All rights reserved.
    </footer>

    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
