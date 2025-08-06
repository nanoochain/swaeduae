<nav class="bg-white shadow mb-6">
    <div class="container mx-auto px-4 py-3 flex justify-between items-center">
        <a href="{{ url('/') }}" class="text-xl font-bold text-blue-800">Sawaed UAE</a>
        <ul class="flex space-x-6 font-semibold">
            <li><a href="{{ url('/') }}" class="hover:text-blue-600">Home</a></li>
            <li><a href="{{ route('events.index') }}" class="hover:text-blue-600">Events</a></li>
            <li><a href="{{ route('opportunities.index') }}" class="hover:text-blue-600">Opportunities</a></li>
            <li><a href="{{ route('news.index') }}" class="hover:text-blue-600">News</a></li>
            <li><a href="{{ route('login') }}" class="hover:text-blue-600">Login</a></li>
            <li><a href="{{ route('register') }}" class="hover:text-blue-600">Sign Up</a></li>
        </ul>
    </div>
</nav>
