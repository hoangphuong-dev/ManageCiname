@component('mail::message')

Xin chào {{ $user->name }}

Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim của PHC

@if($password == null)
Tài khoản của bạn đã chuyển sang chế độ nghỉ việc

Cảm ơn bạn đã đồng hành cùng PHC trong thời gian vừa qua .
@else($password != null)
Chúc mừng bạn đã trở thành nhân viên của rạp : {{ $cinema->name }}

Địa chỉ : {{ $cinema->address }}

Đây là mật khẩu đăng nhập của bạn :
<span style="font-weight: bold; color: red;">{{ $password }} </span>

Vui lòng truy cập
<a href="{{route('back.login.get')}}">{{route('back.login.get')}}</a>
để đăng nhập tài khoản

@endif

{{ config('app.name') }} xin chân thành cảm ơn !<br>
@endcomponent