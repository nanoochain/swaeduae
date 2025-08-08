<nav class="navbar navbar-expand-lg py-3">
  <div class="container">
    <a class="navbar-brand fw-bold" href="{{ route('home') }}">سواعد الإمارات</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div id="nav" class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="{{ route('events.index') }}">{{ __('messages.events') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('platform') }}">{{ __('messages.platform') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">{{ __('messages.faq') }}</a></li>
        <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">{{ __('messages.contact') }}</a></li>
      </ul>
      <div class="d-flex align-items-center gap-2">
        <div class="dropdown">
          <button class="btn btn-light lang-pill dropdown-toggle" data-bs-toggle="dropdown">
            {{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}
          </button>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{ route('lang.switch','ar') }}">العربية</a></li>
            <li><a class="dropdown-item" href="{{ route('lang.switch','en') }}">English</a></li>
          </ul>
        </div>
        @auth
          <a class="btn btn-outline-secondary" href="{{ route('volunteer.profile') }}">{{ __('messages.dashboard') }}</a>
          <form method="POST" action="{{ route('logout') }}" class="ms-1">@csrf
            <button class="btn btn-outline-danger">{{ __('messages.logout') }}</button>
          </form>
        @else
          <a class="btn btn-outline-primary" href="{{ route('login') }}">{{ __('messages.login') }}</a>
          <a class="btn btn-accent" href="{{ route('register') }}">{{ __('messages.register') }}</a>
        @endauth
      </div>
    </div>
  </div>
</nav>
