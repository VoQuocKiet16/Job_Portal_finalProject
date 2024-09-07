<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Hello {{ $user->name }}</h1>
    <p>Click below to change your password.</p>
    <p><a href="{{ route('account.resetPassword', ['token' => $token]) }}">Click Here</a></p>
    
    <p><strong>Note:</strong> This link will expire in 1 minute. Please use the link before it expires.</p>
    
    <p>Thanks</p>
</body>
</html>