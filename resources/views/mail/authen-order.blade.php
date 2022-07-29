@component('mail::message')
# Thông báo xác thực email
Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim của PHC <br>
Để tiếp tục quy trình đặt vé . Vui lòng click vào đường link bên dưới để tiếp tục

<div>
    <a style="text-align: center; background: lightgreen; color: black;" href="{{route('order.authen-token', $token)}}">
        Tiếp tục
    </a>
</div>


{{ config('app.name') }} xin chân thành cảm ơn !<br>
@endcomponent