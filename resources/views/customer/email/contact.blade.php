<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Email</title>
</head>
<body style="font-family: 'Helvetica Neue', sans-serif; font-size: 16px; ">
    <h1 class="fw-bold">You have received a contact email</h1>
    <p class="fw-medium">Name: {{ $mailData['name'] }}</p>
    <p class="fw-medium">Email: {{ $mailData['email'] }}</p>
    <p class="fw-medium">Subject: {{ $mailData['subject'] }}</p>
    <p>Message: </p>
    <p class="fw-medium"> {{ $mailData['message'] }}</p>

</body>
</html>
