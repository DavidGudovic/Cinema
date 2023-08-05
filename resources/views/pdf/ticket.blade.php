<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
        }
        .container {
            width: 602px;
            height: 200px;
            margin: 0 auto;
            border-radius: 4px;
            background-color: #4537de;
            box-shadow: 0 8px 16px rgba(35, 51, 64, 0.25);
        }
        .column-1 {
            float: left;
            width: 400px;
            height: 200px;
            border-right: 2px dashed #fff;
        }
        .column-2 {
            float: right;
            width: 200px;
            height: 200px;
        }
        .text-frame {
            padding: 40px;
            height: 120px;
        }
        .qr-holder {
            position: relative;
            width: 160px;
            height: 160px;
            margin: 20px;
            background-color: #fff;
            text-align: center;
            line-height: 30px;
            z-index: 1;
        }
        .qr-holder > img {
            margin-top: 20px;
        }
        .event {
            font-size: 24px;
            color: #fff;
            letter-spacing: 1px;
        }
        .date {
            font-size: 18px;
            line-height: 30px;
            color: #a8bbf8;
        }
        .name,
        .ticket-id {
            font-size: 16px;
            line-height: 22px;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="column-1">
            <div class="text-frame">
                <div class="event">{{$ticket->screening->movie->title}}</div>
                <div class="date">Početak: {{$ticket->screening->human_date}} {{$ticket->screening->human_time}}</div>
                <br />
                <div class="name">Sala: {{$ticket->screening->hall_id}}</div>
                <div class="ticket-id">{{$user->name}}</div>
            </div>
        </div>

        <div class="column-2">
            <div class="qr-holder">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(160)->generate($ticket->id)) !!} ">
            </div>
        </div>
    </div>
</body>
</html>


