<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Siclo de atencion global</title>
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
<div style="text-align: center; font-size: 18px; margin-bottom: 10px">
    <p>CICLO DE ATENCION GLOBAL</p>
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
<div style="font-size: 12px; border-bottom: 1px solid grey; margin-bottom: 10px">
   <b><span>CAG DATOS</span></b>
</div>
<div style="width: 100%; margin-bottom: 25px">
    <div style="width: 15%;">
        NO: <b>{{$data['id']}}</b>
    </div>
    <div style="width: 20%;">
       INICIO:  <b>{{Carbon\Carbon::parse($data['moment'])->format('d-m-Y')}}</b>
    </div>
    <div style="width: 25%;">
        ESTADO:  <b>{{$data['status']['name']}}</b>
    </div>
    <div style="width: 40%; text-align: right">
       ATENDIDO POR: <b>{{$data['attended']['name']}}</b>
    </div>
</div>
<div style="width: 100%; margin-bottom: 25px">
    <div style="width: 25%;">
        CONTACTO: <b>{{$data['contact']['name']}}</b>
    </div>
    <div style="width: 25%;">
        MOTIVO: <b>{{$data['motive_products']['name']}}</b>
    </div>
    <div style="width: 25%;">
        COMPROMISO: <b>{{$data['compromise']['name']}}</b>
    </div>
</div>
<div style="font-size: 12px; border-bottom: 1px solid grey; margin-bottom: 10px">
    <b><span>INFORMACION PROPORCIONADA</span></b>
</div>
 @foreach($data['info'] as $det)
    <div style="width: 100%; margin-bottom: 25px">
        <div style="width: 25%;">
            TIPO: <b>{{$det['info']['name']}}</b>
        </div>
        <div style="width: 25%;">
            CARACTERISTICA: <b>{{$det['info_det']['name']}}</b>
        </div>
        <div style="width: 25%;">
            ESPECIFICO: <b>{{$det['info_descrip']}}</b>
        </div>
    </div>
  @endforeach
<div style="width: 100%; margin-bottom: 25px">
    <b>NOTA:</b>  <br>
    <p>{{$data['note']}}</p>
</div>
@if ($data['landscaper'] !== null)
    <div style="font-size: 12px; border-bottom: 1px solid grey; margin-bottom: 10px">
        <b><span>VISITA A DOMICILIO</span></b>
    </div>
    <div style="width: 100%; margin-bottom: 15px">
        LOCACION: <b>{{$data['client']['address']}}</b>
    </div>
    <div style="width: 100%; margin-bottom: 25px">
        <div style="width: 20%;">
            FECHA: <b>{{Carbon\Carbon::parse($data['landscaper']['moment'])->format('d-m-Y')}}</b>
        </div>
        <div style="width: 20%;">
            HORA: <b>{{$data['landscaper']['timer']}}</b>
        </div>
        <div style="width: 20%;">
            ESTADO: @if($data['landscaper']['status_id'] === 0) <b>EN ESPERA</b> @else <b>VISITADO</b> @endif
        </div>
        <div style="width: 40%; text-align: right">
            PAISAJISTA: <b>{{$data['landscaper']['user']['name']}}</b>
        </div>
    </div>
@endif
@if ($sale !== null)
    <div style="font-size: 12px; border-bottom: 1px solid grey; margin-bottom: 10px">
        <b><span>NOTA DE VENTA</span></b>
    </div>
    <div style="width: 25%; margin-bottom: 15px">
        NUMERO: <b>{{$sale['id']}}</b>
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
    <table class="table table-hover">
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
@endif
</body>
</html>
