<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>إنشاء حساب جديد | سواعد الإمارات</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body { background: #fcf6e8; font-family: 'Tajawal', Arial, sans-serif; margin:0; }
        .auth-container {
            max-width: 420px; margin: 55px auto; background: #fff;
            border-radius: 18px; box-shadow: 0 4px 24px #0001; padding: 42px 30px;
        }
        .auth-title { font-size: 2rem; font-weight: bold; color: #218838; margin-bottom: 24px; text-align: center; }
        .form-group { margin-bottom: 16px; }
        label { display: block; margin-bottom: 5px; color: #333; font-weight: 500; }
        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%; padding: 11px 10px; border-radius: 7px;
            border: 1px solid #eee; background: #faf9f6; font-size: 1rem;
        }
        .register-btn {
            width: 100%; padding: 13px; border: none; border-radius: 8px;
            background: #218838; color: #fff; font-weight: bold; font-size: 1.08rem;
            cursor: pointer; transition: background 0.15s;
        }
        .register-btn:hover { background: #11653c; }
        .other-links { margin-top: 15px; text-align: center; }
        .other-links a { color: #218838; margin: 0 5px; text-decoration: underline; font-size: 1rem; }
        .error-message { color: #b91d1d; text-align: center; margin-bottom: 10px; }
        @media (max-width: 600px) {
            .auth-container { padding: 22px 7px; }
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-title">إنشاء حساب جديد</div>
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error) <div>{{ $error }}</div> @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">الاسم الكامل</label>
                <input id="name" type="text" name="name" required value="{{ old('name') }}">
            </div>
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input id="email" type="email" name="email" required value="{{ old('email') }}">
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">تأكيد كلمة المرور</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required>
            </div>
            <button class="register-btn" type="submit">تسجيل جديد</button>
        </form>
        <div class="other-links">
            <a href="{{ route('login') }}">هل لديك حساب؟ سجل الدخول</a>
        </div>
    </div>
</body>
</html>
