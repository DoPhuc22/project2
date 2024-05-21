<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
</head>
<body style="font-family: 'Helvetica Neue', sans-serif; font-size: 16px; ">
<p>Hello, {{ $formData['customer']->first_name }} {{ $formData['customer']->last_name }}</p>
<h1 class="fw-bold">You have request to change password:</h1>
<p class="fw-medium">Please click the link given below to reset password.</p>
<a href="{{ route('customer.resetPassword', $formData['token']) }}">Click here</a>
<p>Thanks</p>

</body>
</html>

