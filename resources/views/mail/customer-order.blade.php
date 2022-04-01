<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Vé</title>
</head>

<body>
    <h1>Thông báo đặt vé thành công</h1>
    <div class="ticket_pdf">
        <h3>Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim của PHC
            Chúng tôi gửi tới bạn thông tin vé bạn vừa đặt.</h3>
    </div>
    @if($check_password != null)
    Mật khẩu đăng nhập lần đầu :
    <span style="font-weight: bold; color: red;">{{ $check_password }} </span> <br>
    Vui lòng đổi mật khẩu sau khi đăng nhập .
    @endif

    {{ config('app.name') }} xin chân thành cảm ơn !<br>
</body>

</html>