@component('mail::message')
# Thông báo phim nổi bật trong tuần

<p>Phim {{$movie}} đạt tỉ lệ vé bán ra cao nhất trong tuần qua</p>

( {{$start}} - {{$end}}) <br>

Bạn có muốn lên lịch chiếu tiếp theo cho phim này ? <br>

Nếu muốn tạo mới xuất chiếu . Vui lòng click vào đường link bên dưới

<a href="{{route('admin.cinemas.show')}}">{{route("admin.cinemas.show")}}</a>

{{ config('app.name') }} xin chân thành cảm ơn !<br>
@endcomponent