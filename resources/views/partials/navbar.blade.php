<header style="background: #fdf5e6; border-bottom:1px solid #eee; width:100%; position:sticky; top:0; z-index:40;">
    <div style="
        display:flex;
        flex-direction:{{ app()->getLocale() == 'ar' ? 'row-reverse' : 'row' }};
        align-items:center;
        justify-content:space-between;
        max-width:1200px;
        margin:0 auto;
        padding:18px 32px;
        min-height:60px;
        gap:20px;">
        <!-- Logo & Site Title -->
        <a href="{{ url('/') }}" style="display:flex;align-items:center;gap:10px;text-decoration:none;">
            <img src="/img/logo.svg" alt="{{ __('messages.site_title') }}" style="height:40px;width:40px;border-radius:8px;background:white;padding:4px;box-shadow:0 1px 4px #0001;">
            <span style="font-size:1.65rem;font-weight:bold;color:#0d3a26;white-space:nowrap;">
                {{ __('messages.site_title') }}
            </span>
        </a>
        <!-- Navbar Links -->
        <nav style="display:flex;gap:26px;font-size:1.16rem;font-weight:600;flex:1;justify-content:center;">
            <a href="{{ route('home') }}" style="color:#14795a;text-decoration:none;">{{ __('Home') }}</a>
            <a href="{{ route('opportunities.index') }}" style="color:#14795a;text-decoration:none;">{{ __('Opportunities') }}</a>
            <a href="{{ route('events.index') }}" style="color:#14795a;text-decoration:none;">{{ __('Events') }}</a>
            <a href="{{ url('/about') }}" style="color:#14795a;text-decoration:none;">{{ __('About') }}</a>
            <a href="{{ url('/faq') }}" style="color:#14795a;text-decoration:none;">{{ __('FAQ') }}</a>
            <a href="{{ url('/contact') }}" style="color:#14795a;text-decoration:none;">{{ __('Contact') }}</a>
        </nav>
        <!-- User/Auth & Lang Switch -->
        <div style="display:flex;align-items:center;gap:8px;">
            @auth
                <span style="font-size:.95rem;color:#222;">{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;margin:0;">
                    @csrf
                    <button type="submit" style="background:#14795a;color:#fff;font-size:.95rem;font-weight:600;border:none;padding:6px 18px;border-radius:6px;margin-left:8px;cursor:pointer;">{{ __('Logout') }}</button>
                </form>
            @else
                <a href="{{ route('login') }}" style="background:#14795a;color:#fff;font-size:.95rem;border-radius:6px;padding:6px 14px;margin-right:8px;text-decoration:none;">{{ __('Login') }}</a>
                <a href="{{ route('register') }}" style="background:#e6ffe6;color:#14795a;font-size:.95rem;border-radius:6px;padding:6px 14px;text-decoration:none;">{{ __('Register') }}</a>
            @endauth
            <!-- Language Switcher -->
            <form method="POST" action="{{ route('lang.switch', ['locale' => 'en']) }}" id="lang-en-form" style="display:none;">@csrf</form>
            <form method="POST" action="{{ route('lang.switch', ['locale' => 'ar']) }}" id="lang-ar-form" style="display:none;">@csrf</form>
            <select onchange="if(this.value) document.getElementById('lang-' + this.value + '-form').submit();"
                style="font-size:.96rem;border-radius:5px;padding:2px 6px;margin-left:6px;border:1px solid #ccc;background:#fff;">
                <option value="en" @if(app()->getLocale() == 'en') selected @endif>English</option>
                <option value="ar" @if(app()->getLocale() == 'ar') selected @endif>العربية</option>
            </select>
        </div>
    </div>
</header>
