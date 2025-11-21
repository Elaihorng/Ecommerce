<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>License Created</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px;">
        <h2 style="color: #2d89ef;">🎉 License Created Successfully</h2>
        <p>Hello {{ $user->name }},</p>
        <p>Your driver’s license has been successfully created.</p>
        <p><strong>License Number:</strong> {{ $license->license_number }}</p>
        <p><strong>License Type:</strong> {{ $license->license_type }}</p>
        <p><strong>Issued Date:</strong> {{ $license->created_at->format('d M Y') }}</p>

        <p>Thank you for using our service.</p>
        <br>
        <p>Best regards,<br>Driver’s License Center</p>
    </div>
</body>
</html>
