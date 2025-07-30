<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Domain Expiry Reminder</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; padding: 20px;">
    <h2 style="color: #d9534f;">⚠️ Domain Expiry Alert</h2>

    <p>Hello,</p>

    <p>Your domain <strong>{{ $domain }}</strong> is set to expire on <strong>{{ $expiry }}</strong>.</p>
    
    <p><strong>{{ $daysLeft }} day{{ $daysLeft == 1 ? '' : 's' }}</strong> left until expiration.</p>

    <p>Please renew it before it expires to avoid service disruption.</p>

    <hr style="margin-top: 30px; margin-bottom: 20px;">
    <small>This is an automated message from your Domain Tracker system.</small>
</body>
</html>
