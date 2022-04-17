@component('mail::message')

Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim của PHC
Chúng tôi vừa nhận được yêu cầu thay đổi email.


Tài khoản : {{ $user->name }} <br>


Email : {{ $user->email }}

Đã thay đổi địa chỉ email thành : <span style="font-weight: bold; color: red;">{{ $email }} </span>

Nếu bạn thay đổi thông tin . Vui lòng truy cập hộp thư email({{ $email }}) , để xác thực địa chỉ email.

{{ config('app.name') }} xin chân thành cảm ơn !<br>
@endcomponent