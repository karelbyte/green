<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nota de venta</title>
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
        body {
            @if($sale['status_id'] === 2 || $sale['status_id'] === 7 || $sale['status_id'] === 5) background-image: url("{{asset('images/gc/paid.png')}}"); @endif
            @if($sale['status_id'] === 1 || $sale['status_id'] === 4 || $sale['status_id'] === 8) background-image: url("{{asset('images/gc/advance.png')}}"); @endif
            background-position: top; /* Center the image */
            background-repeat: no-repeat; /* Do not repeat the image */
            background-size: auto;
            height: 11in;
        }
        div {
            display: block;
            float: left;
            width: 100%;
            font-size: 12px;
        }
        .top {
            border: 1px solid grey;
        }
        .logo {
            width: 15%;
            text-align: left;
            margin-top: 10px
        }
        .generals {
            width: 85%;
            text-align: left;
            margin-top: 15px
        }
    </style>
</head>
<body>
<!-- HEADER DEL DOC  DATOS DE LA EMPRESA-->
<div style="text-align: center; font-size: 18px; margin: 120px 0 10px 0">
    <p>NOTA DE VENTA</p>
</div>
<div style="font-size: 12px; border-bottom: 1px solid grey; margin-bottom: 10px">
    <b><span>CLIENTE</span></b>
</div>
<div style="width: 100%; margin-bottom: 25px">
    <div style="width: 25%;">
        CODIGO: <b>{{$data['client']['code']}}</b>
    </div>
    <div style="width: 30%;">
        NOMBRE: <b>{{$data['client']['name']}}</b>
    </div>
    <div style="width: 30%;">
        CONTACTO:  <b>{{$data['client']['contact']}}</b>
    </div>
</div>

<div style="width: 25%; margin-bottom: 15px">
    NOTA: <b>{{$sale['id']}}</b>
</div>
<div style="width: 25%;">
    FECHA: <b>{{Carbon\Carbon::parse($sale['moment'])->format('d-m-Y')}}</b>
</div>
<div style="width: 25%;">
    RECIBIDO: <b>{{number_format($sale['advance'], 2, '.', '')}}$</b>
</div>
<div style="width: 25%; text-align: right">
    ESTADO: <b>{{$sale['status']['name']}}</b>
</div>
<table class="table table-hover sales-pagado">
    <thead>
    <tr>
        <th>Descripción</th>
        <th>Unidad de Medida</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($sale['details'] as $det)
        <tr>
            <td>{{$det['descrip']}}</td>
            <td>{{$det['measure']['name']}}</td>
            <td>{{$det['cant']}}</td>
            <td>{{$det['price']}}$</td>
            <td>{{ number_format($det['cant'] * $det['price'], 2, '.', '')}}$</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td></td>
        <td></td>
        <td>Total</td>
        <td><b>{{$sale->total()}}$</b></td>
    </tr>
    </tbody>
</table>
</body>
</html>
