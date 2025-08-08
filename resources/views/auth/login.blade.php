<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>تسجيل الدخول | سواعد الإمارات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { background: #fcf6e8; font-family: 'Tajawal', Arial, sans-serif; margin:0; }
        .auth-container {
            max-width: 380px; margin: 60px auto; background: #fff;
            border-radius: 18px; box-shadow: 0 4px 24px #0001; padding: 40px 30px;
        }
        .auth-title { font-size: 2rem; font-weight: bold; color: #11653c; margin-bottom: 24px; text-align: center; }
        .form-group { margin-bottom: 18px; }
        label { display: block; margin-bottom: 6px; color: #333; font-weight: 500; }
        input[type="email"], input[type="password"] {
            width: 100%; padding: 11px 10px; border-radius: 7px;
            border: 1px solid #eee; background: #faf9f6; font-size: 1rem;
        }
        input[type="checkbox"] { margin-left: 7px; }
        .login-btn {
            width: 100%; padding: 12px; border: none; border-radius: 8px;
            background: #218838; color: #fff; font-weight: bold; font-size: 1.08rem;
            cursor: pointer; transition: background 0.15s;
        }
        .login-btn:hover { background: #11653c; }
        .other-links { margin-top: 16px; text-align: center; }
        .other-links a { color: #218838; margin: 0 5px; text-decoration: underline; font-size: 1rem; }
        .error-message { color: #b91d1d; text-align: center; margin-bottom: 10px; }
        @media (max-width: 600px) {
            .auth-container { padding: 24px 10px; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-title">تسجيل الدخول</div>
        @if (session('error'))
            <div class="error-message">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" required autofocus autocomplete="email" value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>
            <div class="form-group" style="display: flex; align-items: center;">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember" style="margin-bottom: 0;">تذكرني</label>
            </div>
            <button class="login-btn" type="submit">تسجيل الدخول</button>
        </form>
        <div class="other-links">
            <a href="{{ route('register') }}">مستخدم جديد؟ سجل الآن</a> |
            <a href="{{ route('password.request') }}">نسيت كلمة المرور؟</a>
        </div>
    </div>
</body>
</html>
