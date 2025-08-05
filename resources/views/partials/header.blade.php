<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-3">
    <div class="container">
        <a class="navbar-brand fw-bold text-primary" href="{{ url('/') }}">
            <img src="/logo.svg" alt="SawaedUAE" style="height:36px;vertical-align:middle;"> SawaedUAE
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('public.events') }}">Events</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('partners') }}">Partners</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('stories') }}">Stories</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                <li class="nav-item ms-2"><a class="btn btn-primary btn-sm" href="{{ route('register') }}">Join Now</a></li>
            </ul>
        </div>
    </div>
</nav>
