@component('mail::message')
# Thông báo cập nhật email

Cảm ơn bạn đã tin tưởng và sử dụng các dịch vụ xem phim của PHC
Chúng tôi vừa nhận được yêu cầu thay đổi email.

Nếu bạn thay đổi email , VUi lòng click vào link dưới để hoàn thiện việc thay đổi
<a href="{{ $url  }}">{{ $url  }}</a>



Thanks,<br>
{{ config('app.name') }}
@endcomponent