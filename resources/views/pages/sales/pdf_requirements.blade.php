<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Requerimientos para entrega</title>
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <style>
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
<div class="top">
    <div class="logo">
        <img src="{{asset('images/gc/logo192.png')}}" alt="" width="96">
    </div>
    <div  class="generals">
        <div style="width: 30%; text-align: left;">
            <div style="font-weight:bolder;">{{$company->name}}</div>
            <div style="padding-bottom: 10px;">{{$company->address}}</div>
        </div>
        <div style="width: 21%; text-align: left;  padding-left: 15px;  border-left: 1px solid grey">
            <span style="font-weight: bolder">Email</span>
            {{$company->email}} <br>
            <span style="font-weight: bolder">RFC:</span>
            {{$company->rfc}}
        </div>
        <div style="width: 15%; text-align: center; padding-left: 5px; border-left: 1px solid grey">
            <span style="font-weight: bolder">Teléfono:</span>
            {{$company->phone1}} <br>
            <span style="font-weight: bolder">WhastApp:</span>
            {{$company->phone2}}
        </div>
    </div>
</div>
<div style="text-align: center; font-size: 18px; margin: 10px 0 10px 0">
    <p>REQUERIMIENTOS NOTA DE VENTA</p>
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

<table class="table table-hover sales-pagado">
    <thead>
    <tr>
        <th>Descripción</th>
        <th>Pedido</th>
        <th>Entregado</th>
        <th>Restan</th>
    </tr>
    </thead>
    <tbody>
    @foreach($details as $det)
        <tr>
            <td>{{$det['descrip']}}</td>
            <td>{{$det['cant']}}</td>
            <td>{{$det['delivered']}}</td>
            <td>{{$det['missing']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
