<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Izveštaj</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style type="text/css">
        * {
            font-family: DejaVu Sans, sans-serif;;
        }

        table {
            font-size: x-small;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        .centered {
            text-align: center;
        }

        .small {
            font-size: x-small;
        }

        .gray {
            background-color: lightgray
        }

        .negative-margin {
            margin-top: -10px;
            margin-bottom: -40px;
        }

        .text {
            text-align: justify;
            font-size: small;
        }
    </style>
</head>
<body>
<!-- Header -->
<table width="100%" class="negative-margin">
    <tr>
        <td valign="top" align="left">
            <?php
            $svg = file_get_contents(public_path('/images/logo.svg'));
            $html = '<img src="data:image/svg+xml;base64,' . base64_encode($svg) . '" width="280" height="200">';
            echo $html;
            ?>
        </td>
        <td valign="top" align="right">
            <h3>{{config('app.name')}} D.O.O.</h3>
            <pre>
          Menadžer: {{$manager->name}}
          Savski nasip 7, Beograd 11000, Srbija
          PIB: 92382317
          067/ 010-010
        </pre>
        </td>
    </tr>
</table>
<!-- End header -->

<!--- Heading -->
<h3 class="centered">{{$period}} izveštaj za {{$date}}, sala {{$hall}}</h3>
<p class="centered small">Generisan: {{now()->format('d/m/Y H:i')}}</p>
<!--- End heading -->

<!-- Requests table heading -->
<table width="100%">
    <tr>
        <td><strong>Obrađenost zahteva</strong></td>
    </tr>
</table>
<!-- End heading -->

<!-- Request data -->
<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>#</th>
        <th>Status</th>
        <th>Broj zahteva</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <th scope="row">1</th>
        <td>Neobrađeni</td>
        <td align="right">{{$request_data['Na čekanju']}}</td>
    </tr>
    <tr>
        <th scope="row">2</th>
        <td>Prihvaćeni</td>
        <td align="right">{{$request_data['Prihvaćen']}}</td>
    </tr>
    <tr>
        <th scope="row">3</th>
        <td>Otkazani</td>
        <td align="right">{{$request_data['Otkazan']}}</td>
    </tr>
    <tr>
        <th scope="row">4</th>
        <td>Odbijeni</td>
        <td align="right">{{$request_data['Odbijen']}}</td>
    </tr>
    </tbody>

    <tfoot>
    <tr>
        <td colspan="1"></td>
        <td align="right">Ukupno zahteva</td>
        <td align="right" class="gray">{{array_sum($request_data)}}</td>
    </tr>
    </tfoot>
</table>
<!-- End request data -->
<br/>


<!-- General stats heading -->
<table width="100%">
    <tr>
        <td><strong>Statistika</strong></td>
    </tr>
</table>
<!-- End heading -->

<!-- Stats data-->
<table width="100%">
    <thead style="background-color: lightgray;">
    <tr>
        <th>Datum</th>
        <th>Rezervacije</th>
        <th>Otkazane rezervacije</th>
        <th>Rentiranja</th>
        <th>Prikazane reklame</th>
    </tr>
    </thead>
    <tbody>
    @foreach($dates as $date)
        <tr>
            <td>{{$date}}</td>
            <td align="right">{{$ticket_data[$date]['Ostvarene']}}</td>
            <td align="right">{{$ticket_data[$date]['Otkazane']}}</td>
            <td align="right">{{$booking_data[$date]}}</td>
            <td align="right">{{$advert_data[$date]}}</td>
        </tr>
    @endforeach
    <tfoot>
    <tr>
        <td align="left">Ukupno</td>
        <td align="right" class="gray">{{array_sum(array_column($ticket_data, 'Ostvarene'))}}</td>
        <td align="right" class="gray">{{array_sum(array_column($ticket_data, 'Otkazane'))}}</td>
        <td align="right" class="gray">{{array_sum($booking_data)}}</td>
        <td align="right" class="gray">{{array_sum($advert_data)}}</td>
    </tr>
    </tfoot>
    </tbody>
</table>
<!--End stats data-->

<!-- Text -->
<!--- Heading -->
<h3 class="centered">Tekst izveštaja</h3>
<!--- End heading -->

<p class="text">{{$text}}</p>
<!-- End text-->
</body>
</html>
