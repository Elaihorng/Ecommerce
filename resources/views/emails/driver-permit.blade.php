<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Driver Registration Confirmation</title>
</head>
<body style="font-family: Arial, sans-serif; background: #f8f8f8; padding: 30px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px;">
        <h2 style="color: #2563eb;">Driver Registration Successful 🎉</h2>
        <p>Hi <strong>{{ $fullName }}</strong>,</p>

        <p>Your driver registration has been successfully submitted.</p>

        <p><strong>Permit Number:</strong> <span style="color:#16a34a">{{ $permitNumber }}</span></p>

        <p>We’ll notify you once your booking or test is scheduled.</p>

        <br>
        <p style="font-size: 14px; color: #555;">Thanks for registering,<br>{{ config('app.name') }}</p>
    </div>
</body>
</html>
