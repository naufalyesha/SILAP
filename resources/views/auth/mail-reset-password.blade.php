<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body>
    <h4>Klik link di bawah untuk Reset Password!</h4>
    <br>
    <br>
    <a href="{{ route('validate-forgot-password', ['token' => $token]) }}" style="color: #1a73e8; text-decoration: underline;">Klik di sini!</a>
</body>
</html>
