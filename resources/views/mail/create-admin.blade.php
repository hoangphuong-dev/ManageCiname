<!DOCTYPE html>
<html lang="en">

<body>
    <div style="padding: 5px;">
        <img height="100px;" width="150px" src="{{asset('/images/logo.png')}}">
    </div>
    <div style="padding: 100px; padding-top: 0px;">
        <h1 style="text-align: center; padding-bottom: 30px;">Thông báo tạo tài khoản admin </h1>
        <p>PHC chúc mừng bạn đã trở thành admin. </p>
        <p>Mật khẩu đăng nhập lần đầu của bạn là : <span style="font-weight: bold;">{{$password}}</span></p>
        <p>Vui lòng đổi mật khẩu sau khi đăng nhập</p>
        <p>Nếu bạn đồng ý làm admin PHC , vui lòng ấn vào <a href="{{ $url }}">{{ $url }}</a> để hoàn tất đăng ký và đăng nhập tài khoản </p>
        <p>PHC chân thành cảm ơn !</p>
    </div>
</body>

</html>