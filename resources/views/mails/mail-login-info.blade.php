<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Mail</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .box {
            width: 80%;
            background: white;
            margin: 0 auto;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            border-radius: 6px;
            padding: 50px;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .text-left {
            text-align: left;
        }

        .horizontal-line {
            width: 100%;
            height: 1px;
            background: #8080803d;
        }

        .button-change-pass {
            background: #a5c242;
            padding: 20px;
            display: block;
            width: 200px;
            text-align: center;
            border-radius: 50px;
            color: white;
            font-weight: bold;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <br>
    <br>
    <div class="flex items-center justify-center">
        <img src="{{asset('/images/logo.svg')}}" alt="">
    </div>
    <br>
    <br>
    <div class="box">
        <h1 class="text-left">Your login information</h1>
        <br>
        <div class="horizontal-line"></div>
        <br>
        <p>
            Email: {{$user->email}}
        </p>
        <p>
            Password: {{$passwordRaw}}
        </p>

        <br>
        <p>
            If you are want to change the password, Please tap the button below to choose new password.
        </p>
        <a href="{{route('change-password.get')}}" class="button-change-pass">Change Password</a>
    </div>
</body>

</html>