<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
</head>
<body>
    <p>Dear {{ $certificate->user->name }},</p>
    <p>Thank you for volunteering with us. Your certificate for <strong>{{ $certificate->event->title }}</strong> is attached.</p>
    <p>Best regards,<br>Sawaed UAE Team</p>
</body>
</html>
