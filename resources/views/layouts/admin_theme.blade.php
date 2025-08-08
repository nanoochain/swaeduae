<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Admin Dashboard - {{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.3.2/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('head')
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow p-6 hidden md:block">
        <h2 class="text-xl font-bold mb-8">{{ __('Admin Panel') }}</h2>
        <nav class="space-y-2 text-gray-700">
            <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-green-100 font-semibold">Dashboard</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-green-100">Users</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-green-100">Events</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-green-100">Volunteers</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-green-100">Certificates</a>
            <a href="#" class="block py-2 px-4 rounded hover:bg-green-100">Settings</a>
        </nav>
    </aside>

    <!-- Main content -->
    <div class="flex-1 flex flex-col">
        <header class="bg-white shadow p-4 flex justify-between items-center">
            <h1 class="text-2xl font-bold">{{ __('Admin Dashboard') }}</h1>
            <div class="flex items-center gap-4">
                <span>{{ Auth::user()->name ?? 'Guest' }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                </form>
            </div>
        </header>

        <main class="p-6 overflow-auto flex-1 bg-gray-50">
            @yield('content')
        </main>
    </div>

    @yield('footer')
</body>
</html>
