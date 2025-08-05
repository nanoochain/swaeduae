<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Volunteer Certificate - {{ $cert->certificate_number }}</title>
    <style>
        body { font-family: 'DejaVu Sans', sans-serif; background: #fff; }
        .cert-container { padding: 50px 30px; border: 4px solid #19b3ae; border-radius: 2em; text-align: center; }
        .cert-title { color: #19b3ae; font-size: 2em; font-weight: bold; }
        .cert-body { margin: 40px 0; font-size: 1.3em; }
        .cert-footer { font-size: 1.1em; margin-top: 50px; color: #888; }
        .qr { margin-top: 35px; }
    </style>
</head>
<body>
    <div class="cert-container">
        <div class="cert-title">Certificate of Volunteering</div>
        <div class="cert-body">
            This certifies that <strong>{{ $cert->user->name }}</strong><br>
            has completed <b>{{ $cert->opportunity->title ?? 'a volunteering opportunity' }}</b><br>
            and has contributed <b>{{ $cert->hours ?? 'N/A' }}</b> hours of service.<br>
            <br>
            <b>Date Issued:</b> {{ $cert->issued_at->format('d M Y') }}<br>
            <b>Certificate #:</b> {{ $cert->certificate_number }}
        </div>
        <div class="qr">
            <img src="data:image/png;base64,{{ $qr }}" alt="QR Code" width="120" height="120"><br>
            <small>Scan to verify</small>
        </div>
        <div class="cert-footer">
            Sawaed UAE &mdash; Empowering Volunteers Across the Emirates
        </div>
    </div>
</body>
</html>
