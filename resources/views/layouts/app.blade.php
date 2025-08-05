<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Sawaed UAE')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
</head>
<body class="bg-gray-50 text-gray-800 font-sans leading-normal min-h-screen flex flex-col">

<nav class="bg-white border-b shadow p-4 flex justify-between items-center">
    <a href="{{ url('/') }}" class="font-bold text-xl text-blue-900">Sawaed UAE</a>
    <div class="space-x-4">
        <a href="{{ route('home') }}" class="hover:underline">Home</a>
        <a href="{{ route('events.index') }}" class="hover:underline">Events</a>
        <a href="{{ route('volunteer.opportunities') }}" class="hover:underline">Opportunities</a>
        <a href="{{ route('news.index') }}" class="hover:underline">News</a>
        @guest
            <a href="{{ route('login') }}" class="hover:underline">Login</a>
            <a href="{{ route('register') }}" class="hover:underline">Sign Up</a>
        @else
            <a href="{{ route('profile.show') }}" class="hover:underline">Profile</a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="hover:underline">Logout</button>
            </form>
        @endguest
    </div>
</nav>

<main class="flex-grow container mx-auto p-4">
    @yield('content')
</main>

<footer class="bg-blue-900 text-white text-center p-4">
    &copy; 2025 Sawaed Emirates Volunteer Society. All rights reserved.
</footer>

</body>
</html>
