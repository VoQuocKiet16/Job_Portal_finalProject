<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Job Notification Email</title>
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
            font-size: 24px;
            color: #EE7214;
        }

        h2 {
            font-size: 20px;
            color: #333;
            border-bottom: 2px solid #EE7214;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        p {
            line-height: 1.6;
            color: #555;
        }

        .details {
            margin: 15px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 5px solid #EE7214;
            border-radius: 4px;
        }

        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 12px;
            color: #888;
        }

        a {
            color: #EE7214;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="email-container">
        <h1>Hello {{ $mailData['employer']->name }},</h1>

        <p>We have a new job application for the job you posted.</p>
        
        <div class="details">
            <h2>Job Details:</h2>
            <p><strong>Job Title:</strong> {{ $mailData['job']->title }}</p>
        </div>

        <div class="details">
            <h2>Applicant Details:</h2>
            <p><strong>Name:</strong> {{ $mailData['user']->name }}</p>
            <p><strong>Email:</strong> <a href="mailto:{{ $mailData['user']->email }}">{{ $mailData['user']->email }}</a></p>
            <p><strong>Mobile No:</strong> {{ $mailData['user']->mobile }}</p>
        </div>

        <p>If you want to view the full application, please log in to your employer account.</p>

        <div class="footer">
            <p>Thank you for using our platform!</p>
            <p><a href="{{ url('/') }}">Visit our website</a></p>
        </div>
    </div>
</body>

</html>
