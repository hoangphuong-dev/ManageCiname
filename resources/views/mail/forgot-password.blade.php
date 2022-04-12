@component('mail::message')
# Thông báo quên mật khẩu

Nếu bạn quên mật khẩu đăng nhập.
Vui lòng ấn vào link dưới để đổi mật khẩu .

<a href="{{$url}}"> {{ $url }}</a>



{{ config('app.name') }} xin chân thành cảm ơn !<br>
@endcomponent