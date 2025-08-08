<nav class="bg-white shadow p-4 flex justify-between items-center">
    <a href="{{ route('home') }}" class="font-bold text-xl text-blue-600">Swaed UAE</a>
    <div>
        <a href="{{ route('home') }}" class="mr-4 {{ request()->routeIs('home') ? 'underline' : '' }}">{{ __('messages.home') }}</a>
        <a href="{{ route('opportunities.index') }}" class="mr-4 {{ request()->routeIs('opportunities.index') ? 'underline' : '' }}">Opportunities</a>
        <a href="{{ route('events.index') }}" class="mr-4 {{ request()->routeIs('events.index') ? 'underline' : '' }}">Events</a>
        <a href="{{ route('volunteer.dashboard') }}" class="mr-4 {{ request()->routeIs('volunteer.dashboard') ? 'underline' : '' }}">Dashboard</a>
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="text-red-600">Logout</a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>
</nav>
