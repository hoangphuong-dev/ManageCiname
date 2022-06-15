@component('mail::message')
# Thông báo xác thực email
Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim của PHC <br>
Để tiếp tục quy trình đặt vé . Vui lòng click vào đường link bên dưới để tiếp tục

<div>
    <a style=" word-wrap: break-word;"
        href="{{route('order.authen-token', $token)}}">{{route('order.authen-token', $token)}}</a>
</div>


{{ config('app.name') }} xin chân thành cảm ơn !<br>
@endcomponent