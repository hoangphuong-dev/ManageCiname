@component('mail::message')
# Thông báo đặt vé thành công

Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim của PHC
Chúng tôi gửi tới bạn thông tin vé bạn vừa đặt.


@if($check_password != null)
Mật khẩu đăng nhập lần đầu :
<span style="font-weight: bold; color: red;">{{ $check_password }} </span> <br>
Vui lòng đổi mật khẩu sau khi đăng nhập .
@endif


{{ config('app.name') }} xin chân thành cảm ơn !<br>
@endcomponent