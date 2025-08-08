<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SwaedUAE Admin Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Tailwind via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Icons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-20 bg-indigo-600 text-white flex flex-col items-center py-6 space-y-6">
        <a href="{{ route('admin.dashboard') }}"><i class="bx bx-bar-chart text-3xl"></i></a>
        <a href="#"><i class="bx bx-home text-3xl"></i></a>
        <a href="#"><i class="bx bx-calendar text-3xl"></i></a>
        <a href="#"><i class="bx bx-chat text-3xl"></i></a>
        <a href="#"><i class="bx bx-task text-3xl"></i></a>
        <a href="#"><i class="bx bx-user text-3xl"></i></a>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @yield('content')
    </main>
</div>

</body>
</html>
