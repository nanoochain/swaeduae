<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ url('/') }}">
      <img src="{{ asset('logo.png') }}" alt="SwaedUAE" height="36" class="me-2" style="margin-top:-8px;">
      SwaedUAE
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">{{ __('Home') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/events') }}">{{ __('Events') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/partners') }}">{{ __('Partners') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">{{ __('About') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">{{ __('Contact') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ url('/faq') }}">{{ __('FAQ') }}</a></li>
      </ul>
      <ul class="navbar-nav mb-2 mb-lg-0">
        <li class="nav-item me-2">
          <a class="btn btn-sm btn-outline-secondary" href="{{ url('lang/ar') }}">العربية</a>
        </li>
        @guest
          <li class="nav-item">
            <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
          </li>
          <li class="nav-item">
            <a class="btn btn-primary" href="{{ route('register') }}">{{ __('Register') }}</a>
          </li>
        @else
          <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
          </li>
          <li class="nav-item dropdown">
            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              {{ Auth::user()->name }}
            </a>
            <ul class="dropdown-menu">
              <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
                </form>
              </li>
            </ul>
          </li>
        @endguest
      </ul>
    </div>
  </div>
</nav>
