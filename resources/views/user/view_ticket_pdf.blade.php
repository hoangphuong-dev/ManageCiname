<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Chi tiết vé đã đặt</title>
    <style>
        body {
            font-family: DejaVu Sans;
        }

        .ticket_pdf {
            width: 80%;
            background: #FCF6DC;
            margin: auto;
            margin-top: 50px;
            border-radius: 10px;
            padding: 30px;
        }

        .ticket_pdf h3 {
            text-align: center;
            font-size: 25px;
        }

        .ticket_pdf table td {
            padding: 15px;
            font-size: 18px;
        }

        .ticket_pdf table {
            border-top: 1px solid black;
        }
    </style>
</head>
@foreach($tickets as $ticket)

<body>
    <div class="ticket_pdf">
        <h3>Vé xem phim</h3>
        <table width="100%">
            <tr>
                <td width="30%">Người đặt :</td>
                <td width="70%">{{$ticket->bill->user->name}}</td>
            </tr>
            <tr>
                <td>Số điện thoại :</td>
                <td>{{$ticket->bill->user->phone}}</td>
            </tr>
            <tr>
                <td>Email :</td>
                <td>{{$ticket->bill->user->email}}</td>
            </tr>
            <tr>
                <td>Ngày đặt :</td>
                <td>{{ date_format(date_create($ticket->created_at), "H:i (d/m/Y)") }}</td>
            </tr>
            <tr>
                <td>Tên phim :</td>
                <td>{{$ticket->showtime->movie->name}}</td>
            </tr>

            <tr>
                <td>Phòng chiếu :</td>
                <td>{{$ticket->showtime->room->name}}</td>
            </tr>
            <tr>
                <td>Ghế xem :</td>
                <td>{{$ticket->seat->row_name .$ticket->seat->columns_number}} ({{$ticket->seat->seat_type->name}})</td>
            </tr>
            <tr>
                <td>Suất chiếu :</td>
                <td>{{ date_format(date_create($ticket->showtime->time_start), "H:i  (d/m/Y)") }}</td>
            </tr>
            <tr>
                <td>
                    @php
                    $code = ' Mã hoá đơn : '. $ticket->bill->id.
                    ' Ngày đặt :'. $ticket->created_at.
                    ' Người đặt : '.$ticket->bill->user->name.
                    ' Tên phim : '. $ticket->showtime->movie->name.
                    ' Phòng chiếu : '.$ticket->showtime->room->name.
                    ' Suất chiếu : '. $ticket->showtime->time_start.
                    ' Ghế xem : '. $ticket->seat->row_name .$ticket->seat->columns_number.
                    ' Tổng tiền : '. $ticket->bill->total_money;
                    @endphp
                    <img src="data:image/png;base64,
                    {!! base64_encode(QrCode::encoding('UTF-8')->size(100)->generate($code)) !!}">
                </td>
                <td align="right">Tổng tiền : {{number_format($ticket->bill->total_money)}} VNĐ</td>
            </tr>
        </table>
    </div>
</body>
@endforeach

</html>