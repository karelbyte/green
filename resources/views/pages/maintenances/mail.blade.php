<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>GreenCenter - Recomendaciones</title>
    <style>
        div {
            display: block;
            float: left;
            width: 100%;
            font-size: 12px;
        }
    </style>
</head>
<body>
<div style="width:55px; text-align: center; margin-top: 25px">
    <img src="{{$message->embed(public_path() . '/images/gc/logo192.png')}}" alt="">
</div>

<div>
    <p>Estimado: <strong>{{$data['client']['name']}}</strong> nos complace hacerle llegar algunas recomendaciones,
    referentes a su ultimo mantenimiento.</p>

    <p>Se ha generado un documento con los detalles, pude verlo en el archivo adjunto.</p>

</div>
<div style="width: 150px; text-align: center; margin-top: 35px">
    <span style="font-size: 10px; letter-spacing: 2px; color: grey">{{$data['company']->name}} </span><br>
    <span style="font-size: 10px; letter-spacing: 2px; color: grey">{{$data['company']->address}} </span><br>
    email: <span style="font-size: 10px; letter-spacing: 2px; color: grey">{{$data['company']->email}} </span><br>
    tel: <span style="font-size: 10px; letter-spacing: 2px; color: grey">{{$data['company']->phone1}} </span><br>
    whatsapp:<span style="font-size: 10px; letter-spacing: 2px; color: grey">{{$data['company']->phone2}} </span>
</div>

</body>
</html>
