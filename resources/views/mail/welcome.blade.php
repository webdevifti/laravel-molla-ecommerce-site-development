<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome </title>
    <style type="text/css">
        a{
            background-color: rgb(16, 156, 39);
            color: #fff;
            text-decoration: none;
            font-size: 18px;
            border-radius: 5px;
            padding: 10px 30px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <h1>Welcome to the your account</h1>
    <a href="http://127.0.0.1:8000/customer/verify/email?code={{ $mail_data['code'] }}">Verify Account</a>
</body>
</html>