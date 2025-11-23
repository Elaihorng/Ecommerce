<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify your email</title>
</head>
<body>
    <p>Hi {{ $fullName }},</p>

    <p>Thank you for registering. Please click the button below to verify your email address:</p>

    <p>
        <a href="{{ $verifyUrl }}" 
           style="display:inline-block;padding:10px 20px;background:#2563eb;color:#fff;text-decoration:none;border-radius:6px;">
            Verify Email
        </a>
    </p>

    <p>If you did not create this account, you can ignore this email.</p>

    <p>Thanks,</p>
    <p>{{ config('app.name') }}</p>
</body>
</html>
