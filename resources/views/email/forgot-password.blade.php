<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .email-container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #EE7214;
            font-size: 24px;
        }

        p {
            line-height: 1.6;
            color: #555;
        }

        a {
            display: inline-block;
            background-color: #EE7214;
            color: #ffffff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin-top: 10px;
        }

        a:hover {
            background-color: #D96510;
        }

        .note {
            color: #D96510;
            font-weight: bold;
            margin-top: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Hello {{ $user->name }},</h1>

        <p>Click the button below to change your password:</p>
        
        <p>
            <a href="{{ route('account.resetPassword', ['token' => $token]) }}">Click Here to Reset Password</a>
        </p>

        <p class="note"><strong>Note:</strong> This link will expire in 1 minute. Please use it before it expires.</p>

        <p>Thanks,<br>QuestCareer</p>

        <div class="footer">
            <p>If you did not request this password reset, please ignore this email.</p>
        </div>
    </div>
</body>

</html>
