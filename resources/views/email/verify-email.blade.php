<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Email Verification</title>
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
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #EE7214;
            font-size: 24px;
        }

        p {
            line-height: 1.6;
            color: #555;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            background-color: #EE7214;
            color: white;
            padding: 12px 24px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 20px;
        }

        .btn:hover {
            background-color: #D96510;
        }

        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Verify your email address to complete your registration</h1>

        <p>Hi {{ $mailData['name'] }},</p>
        <p>Welcome to CareerQuest!</p>
        <p>Please verify your email address so you can get full access to qualified freelancers eager to tackle your project.</p>

        @if($mailData['verified'])
            <p>Your email has already been verified.</p>
        @else
            <a href="{{ $mailData['verification_link'] }}" class="btn">Verify Email</a>
            <p>If you did not create an account, no further action is required.</p>
        @endif

        <p>Thanks for your time,<br>The CareerQuest Team</p>

        <div class="footer">
            <p>If you have any issues, feel free to contact us at support@careerquest.com.</p>
        </div>
    </div>
</body>

</html>
