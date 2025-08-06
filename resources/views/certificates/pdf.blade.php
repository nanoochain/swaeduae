<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Certificate</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; text-align: center; background: #fdf5e6; }
        .cert { border: 10px solid #2b7a78; border-radius: 24px; padding: 45px; margin: 40px auto; width: 80%; background: #fff; }
        .qr { position: absolute; right: 70px; top: 70px; }
    </style>
</head>
<body>
    <div class="cert">
        <h1 style="font-size:48px; color:#2b7a78; margin-bottom: 8px;">Sawaed UAE</h1>
        <div style="font-size:22px; margin:18px 0;">Certificate of Volunteer Service</div>
        <div style="margin:24px 0 36px;">This is to certify that <strong>{{ $certificate->user->name }}</strong> has contributed <strong>{{ $certificate->hours }}</strong> hours as <b>{{ $certificate->title }}</b>.<br>{{ $certificate->description }}</div>
        <div style="margin-bottom:24px;">Date: {{ $certificate->issue_date }}</div>
        <div>Certificate #: <b>{{ $certificate->code }}</b></div>
        <img src="data:image/png;base64,{{ $qr }}" alt="QR Code" class="qr" width="120">
        <div style="margin-top:38px;font-size:15px;color:#888;">Scan to verify | Digital signature: __________________</div>
    </div>
</body>
</html>
