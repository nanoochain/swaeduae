<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" @if(App::isLocale('ar')) dir="rtl" @endif>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel | SawaedUAE')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        :root {
            --primary: #246bfd;
            --secondary: #f7f8fa;
            --surface: #fff;
            --sidebar-bg: #1e293b;
            --sidebar-color: #fff;
            --danger: #e11d48;
        }
        [data-theme="dark"] {
            --primary: #7dd3fc;
            --secondary: #1e293b;
            --surface: #0f172a;
            --sidebar-bg: #0a0a23;
            --sidebar-color: #dbeafe;
            --danger: #f87171;
        }
        html, body {
            background: var(--secondary) !important;
            font-family: 'Cairo', 'Tajawal', Arial, sans-serif;
            color: #222;
            transition: background 0.2s;
        }
        [data-theme="dark"] html, [data-theme="dark"] body {
            color: #dbeafe;
        }
        .dashboard-card {
            border-radius: 1.25rem;
            background: var(--surface);
            box-shadow: 0 2px 12px #0002;
            border: none;
            transition: background 0.2s;
        }
        aside {
            background: var(--sidebar-bg);
            color: var(--sidebar-color);
            min-height: 100vh;
        }
        aside .nav-link {
            color: var(--sidebar-color);
            border-radius: 10px;
        }
        aside .nav-link.active, aside .nav-link:hover {
            background: var(--primary);
            color: #fff;
        }
        .admin-main { margin-left: 250px; min-height: 100vh; transition: margin .2s; }
        .sidebar-toggle { display: none; }
        .brand { color: var(--primary); font-weight: 700; }
        .dark-toggle {
            border: 1px solid #8882; background: none; color: var(--primary);
            border-radius: 12px; padding: 4px 14px; margin-right: 1rem;
        }
        [data-theme="dark"] .brand { color: var(--primary); }
        @media (max-width: 991px) {
            aside { display: none !important; }
            .admin-main { margin-left: 0; }
            .sidebar-toggle { display: block; }
        }
    </style>
    @yield('head')
</head>
<body>
    @include('admin.partials.sidebar')
    <main class="admin-main">
        <nav class="navbar navbar-light bg-white border-bottom">
            <div class="container-fluid">
                <button class="btn btn-outline-primary sidebar-toggle d-lg-none" type="button" onclick="document.querySelector('aside').classList.toggle('d-none');">
                    <i class="bi bi-list"></i>
                </button>
                <button class="dark-toggle" onclick="window.toggleTheme()">
                    <i class="bi bi-moon"></i> <span id="themeModeLabel">Dark Mode</span>
                </button>
                <span class="navbar-text ms-auto me-2">{{ auth()->user()->name ?? 'Admin' }}</span>
                <a href="{{ route('logout') }}" class="btn btn-sm btn-outline-danger">{{ __('Logout') }}</a>
            </div>
        </nav>
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </main>
    <script>
    window.toggleTheme = function() {
        var theme = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        document.getElementById('themeModeLabel').innerText = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
    };
    (function() {
        var theme = localStorage.getItem('theme') || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
        document.documentElement.setAttribute('data-theme', theme);
        if(document.getElementById('themeModeLabel')) {
            document.getElementById('themeModeLabel').innerText = theme === 'dark' ? 'Light Mode' : 'Dark Mode';
        }
    })();
    </script>
    @yield('scripts')
</body>
</html>
<div class="ms-2">
    <form method="POST" action="{{ route('lang.switch') }}">
        @csrf
        <select name="lang" onchange="this.form.submit()" class="form-select form-select-sm" style="width:auto;display:inline-block;">
            <option value="en" @if(App::getLocale()=='en') selected @endif>EN</option>
            <option value="ar" @if(App::getLocale()=='ar') selected @endif>AR</option>
        </select>
    </form>
</div>
