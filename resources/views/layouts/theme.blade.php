<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(App::isLocale('ar')) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'SawaedUAE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <style>
        body { background: #f6f8fa; font-family: 'Cairo', 'Tajawal', Arial, sans-serif; }
        .navbar { box-shadow: 0 2px 8px rgba(0,0,0,0.02);}
        .brand { color: #007bff; font-weight: 600;}
        .dashboard-card { border-radius: 1.25rem; box-shadow: 0 2px 12px #0001; }
        .avatar { width:64px; height:64px; border-radius:50%; object-fit:cover;}
    </style>
    @yield('head')
</head>
<body>
    @include('partials.header')
    <main class="py-4 min-vh-100">
        @yield('content')
    </main>
    @include('partials.footer')
    @yield('scripts')
</body>
</html>
