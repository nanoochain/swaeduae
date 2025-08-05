<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>شهادة التطوع</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; text-align: center; padding: 50px; }
        .border { border: 5px solid #333; padding: 40px; }
        .title { font-size: 32px; font-weight: bold; margin-bottom: 30px; }
        .subtitle { font-size: 20px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="border">
        <div class="title">شهادة شكر وتقدير</div>
        <p>تُمنح هذه الشهادة إلى:</p>
        <h2>{{ auth()->user()->name }}</h2>
        <p>وذلك لمشاركته في فعالية:</p>
        <h3>{{ $certificate->title }}</h3>
        <div class="subtitle">بتاريخ {{ $certificate->created_at->format('Y-m-d') }}</div>
        <p>نتمنى له دوام التوفيق والعطاء.</p>
        <br><br>
        <p>سواعد الإمارات للتطوع</p>
    </div>
</body>
</html>
