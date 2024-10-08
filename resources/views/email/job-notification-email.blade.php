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

        .details {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-left: 5px solid #EE7214;
            border-radius: 4px;
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
            <p>Thanks,<br>QuestCareer</p>
            <p><a href="{{ url('/') }}">Visit our website</a></p>
        </div>
    </div>
</body>

</html>
