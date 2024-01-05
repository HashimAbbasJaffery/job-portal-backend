<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complete Account</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; color: #333;">

    <div style="max-width: 600px; margin: 20px auto; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);">
        <h2 style="color: #007bff;">Complete Your TechZeme Account</h2>
        <p>Hello {{ $mailData["name"] }},</p>
        <p>Thank you for choosing the TechZeme. Click the link below to complete your profile. and start contributing :D</p>
        
        <p>
            <a href="{{ route("check_uuid", [
                "uuid" => $mailData["uuid"]
            ]) }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 5px;">Verify Email</a>
        </p>

        <p>If you did not create an account, you can safely ignore this email.</p>
        <p>Best regards,<br>Your Website Team</p>
    </div>

</body>

</html>
