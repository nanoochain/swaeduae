<!DOCTYPE html>
<html lang="en" class="{{ session('theme', 'light') }}">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Swaed UAE')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    <script>
        function toggleTheme() {
            fetch('/toggle-theme', {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            }).then(res => res.json()).then(data => {
                document.documentElement.className = data.theme;
            });
        }
    </script>
</head>
<body>
    <button onclick="toggleTheme()" style="position:fixed;top:10px;right:10px;z-index:1000;">
        Toggle Dark/Light Mode
    </button>

    <main>
        @yield('content')
    </main>
</body>
</html>
