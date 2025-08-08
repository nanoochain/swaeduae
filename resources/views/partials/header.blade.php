<header class="bg-white shadow p-4 flex justify-between items-center">
    <div class="logo text-xl font-bold text-blue-700">
        <a href="{{ route('home') }}">SawaedUAE</a>
    </div>

    <nav class="flex items-center space-x-6">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <a href="{{ route('opportunities.index') }}" class="hover:text-blue-600">Opportunities</a>
        <a href="{{ route('events.index') }}" class="hover:text-blue-600">Events</a>
        <a href="{{ route('news.index') }}" class="hover:text-blue-600">News</a>
        <a href="{{ route('about') }}" class="hover:text-blue-600">About</a>
        <a href="{{ route('contact') }}" class="hover:text-blue-600">Contact</a>

        @auth
        <div class="relative" x-data="{ open: false }">
            <!-- Notifications bell and dropdown (simplified for brevity) -->
            <button @click="open = !open" class="relative focus:outline-none">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 00-9.33-5.209M9 21h6" />
                </svg>
                <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-red-600 rounded-full" id="notification-count" style="display:none;">0</span>
            </button>
            <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-72 bg-white border rounded shadow-lg z-50">
                <div id="notification-list" class="max-h-64 overflow-y-auto">
                    <p class="p-4 text-gray-500">Loading notifications...</p>
                </div>
            </div>
        </div>

        <!-- Language switcher dropdown -->
        <div class="relative ml-4" x-data="{ langOpen: false }">
            <button @click="langOpen = !langOpen" class="px-3 py-1 border rounded text-gray-700 hover:bg-gray-100">
                {{ strtoupper(app()->getLocale()) }}
            </button>
            <div x-show="langOpen" @click.away="langOpen = false" class="absolute right-0 mt-2 w-24 bg-white border rounded shadow-lg z-50">
                <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 hover:bg-gray-100">English</a>
                <a href="{{ route('lang.switch', 'ar') }}" class="block px-4 py-2 hover:bg-gray-100">العربية</a>
            </div>
        </div>

        <!-- Logout button -->
        <div class="ml-4">
            @include('partials.logout')
        </div>
        @endauth

        @guest
        <a href="{{ route('login') }}" class="hover:text-blue-600">Login</a>
        @endguest
    </nav>
</header>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
