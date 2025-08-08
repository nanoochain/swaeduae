<header class="bg-white border-b shadow-sm py-3 px-4 flex items-center justify-between">
    <div class="flex items-center gap-3">
        <a href="{{ url('/') }}">
            <img src="/img/logo.svg" alt="Sawaed UAE Logo" style="height:54px;max-width:180px;" class="rounded shadow">
        </a>
        <span class="font-extrabold text-2xl text-[#285a6a] tracking-tight">Sawaed UAE</span>
    </div>
    <nav class="flex gap-6 items-center">
        <a href="{{ url('/') }}" class="font-semibold hover:text-[#285a6a]">Home</a>
        <a href="{{ url('/opportunities') }}" class="font-semibold hover:text-[#285a6a]">Opportunities</a>
        <a href="{{ url('/events') }}" class="font-semibold hover:text-[#285a6a]">Events</a>
        <a href="{{ url('/about') }}" class="font-semibold hover:text-[#285a6a]">About</a>
        <a href="{{ url('/faq') }}" class="font-semibold hover:text-[#285a6a]">FAQ</a>
        <a href="{{ url('/contact') }}" class="font-semibold hover:text-[#285a6a]">Contact</a>
    </nav>
    <div class="flex gap-3 items-center">
        @auth
            <span class="text-sm text-gray-600">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-100 text-red-600 px-3 py-1 rounded font-semibold hover:bg-red-200">Logout</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bg-[#285a6a] text-white px-4 py-1 rounded font-semibold hover:bg-[#19333e]">Login</a>
        @endauth
        <a href="{{ url('/lang/ar') }}" class="text-[#285a6a] font-bold">العربية</a>
        <a href="{{ url('/lang/en') }}" class="text-[#285a6a] font-bold">English</a>
    </div>
</header>
