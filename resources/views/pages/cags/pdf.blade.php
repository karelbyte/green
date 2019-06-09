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
        body {
            padding-top: 100px;
        }

        header {
            padding: 10px 0;
            margin-bottom: 10px;
            border-bottom: 1px solid #AAAAAA;
        }

        #details {
            margin-bottom: 50px;
        }

        #client {
            padding-left: 6px;
            border-left: 6px solid #125c27;
        }

        #client .to {
            color: #777777;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
        }
        #invoice {
            text-align: right;
        }

        #invoice h1 {
            color: #125c27;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0  0 5px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #777777;
        }
        /* */
        table {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 10px;
        }

        table th,
        table td {
            padding: 5px;
            background: #EEEEEE;
            text-align: center;
            border-bottom: 1px solid #FFFFFF;
        }

        table th {
            white-space: nowrap;
            font-weight: normal;
        }

        table td {
            text-align: right;
        }

        table td h3{
            color: rgba(89, 219, 35, 0.34);
            font-size: 1.1em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #FFFFFF;
            font-size: 1.1em;
            background: #555555;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #DDDDDD;
        }

        table .qty {
        }

        table .total {
            background: rgba(62, 159, 100, 0.49);
            color: black;
        }

        table td.unit,
        table td.qty,
        table td.total {
            font-size: 1.1em;
        }

        table tbody tr:last-child td {
            border: none;
        }


        table tfoot td {
            padding: 10px 10px;
            background: #FFFFFF;
            border-bottom: none;
            font-size: 1.2em;
            white-space: nowrap;
            border-top: 1px solid #AAAAAA;
        }

        table tfoot tr:first-child td {
            border-top: none;
        }

        table tfoot tr:last-child td {
            color: #1130b2;
            font-size: 1.4em;
            border-top: 1px solid #57B223;

        }

        table tfoot tr td:first-child {
            border-top: 1px solid #AAAAAA;
        }

        #thanks{
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices{
            padding-left: 6px;
            border-left: 6px solid #0087C3;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        footer {
            color: #777777;
            width: 100%;
            height: 30px;
            position: absolute;
            bottom: 0;
            padding: 8px 0;
            text-align: center;
        }
        .unit {
            text-align: center;
        }
    </style>
</head>
<body>

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
    <div style="width: 33%;">
        CONTACTO: <b>{{$data['contact']['name']}}</b>
    </div>
    <div style="width: 33%;">
        MOTIVO: <b>{{$motive}}</b>

    </div>
    <div style="width: 32%;">
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
@if ($quote !== null )
    <div style="margin: 20px 0 20px 0; text-align: center">
        <h4>{{$quote['descrip']}}</h4>
    </div>
    <table border="0" cellspacing="0" cellpadding="0">
        <tr>
            <th class="no">#</th>
            <th class="desc">DESCRIPCION</th>
            <th class="unit">UNIDAD MEDIDA</th>
            <th class="unit">CANTIDAD</th>
            <th class="unit">PRECIO</th>
            <th class="unit">IMPORTE</th>
        </tr>

        <tbody>
        @php
            $total = 0;
        @endphp
        @foreach ($quote['details'] as $index => $det)
            <tr>
                <td class="no">{{$index+1}}</td>
                <td class="desc">{{$det->descrip}}</td>
                <td class="unit">{{$det->measure->name}}</td>
                <td class="unit">{{$det->cant}}</td>
                <td class="unit">{{$det->price}}</td>
                <td class="total">{{number_format($det->price * $det->cant, 2, '.', '')}}</td>
                @php
                    $total += $det->price * $det->cant
                @endphp
            </tr>
        @endforeach
        @if ($quote['have_iva'] === 1)
            <tr>
                <td></td>
                <td colspan="2"></td>
                <td colspan="2">BASE IMPONIBLE</td>
                <td class="unit">{{number_format($total, 2, '.', '')}}</td>
            </tr>

            <tr>
                @php
                    $iva = $total * 0.16
                @endphp
                <td></td>
                <td colspan="2"></td>
                <td colspan="2">SUBTOTAL IVA</td>
                <td  class="unit">{{number_format($iva, 2, '.', '')}}</td>
            </tr>
        @endif
        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="2">IMPORTE TOTAL</td>
            @if ($quote['have_iva'] === 1)
                <td  class="total">{{number_format($total + $iva, 2, '.', '')}}</td>
            @else
                <td  class="total">{{number_format($total, 2, '.', '')}}</td>
            @endif
        </tr>
        </tbody>
    </table>
@endif
@if ($sale !== null &&  (int) $sale['status_id'] !== 3)
    <div style="margin: 20px 0 20px 0; text-align: center">
        <h4>NOTA DE VENTA</h4>
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
                <td class="total">{{ number_format($det['cant'] * $det['price'], 2, '.', '')}}$</td>
            </tr>
        @endforeach
        @if ($sale['have_iva'] === 1)
            <tr>
                <td></td>
                <td></td>
                <td colspan="2">BASE IMPONIBLE</td>
                <td class="unit">{{number_format($sale->total(), 2, '.', '')}}</td>
            </tr>

            <tr>
                @php
                    $iva = $sale->total() * 0.16
                @endphp
                <td></td>
                <td></td>
                <td colspan="2">SUBTOTAL IVA</td>
                <td  class="unit">{{number_format($iva, 2, '.', '')}}</td>
            </tr>
        @endif
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total</td>
            <td class="total"><b> {{$sale->total() +  $iva }}$</b></td>
        </tr>
        </tbody>
    </table>
    <div style="margin: 20px 0 20px 0; text-align: center">
        <h4>MATERIALES</h4>
    </div>
    <table>
        <thead>
        <tr>
            <th style="text-align: left">Descripción</th>
            <th style="text-align: left">Unidad de Medida</th>
            <th style="text-align: left">Cantidad</th>
        </tr>
        </thead>
        <tbody>
            @foreach($sale['delivered'] as $del)
                <tr>
                    <td style="text-align: left">{{$del['element']['name']}}</td>
                    <td style="text-align: left">{{$del['element']['measure']['name']}}</td>
                    <td style="text-align: left">{{$del['cant']}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif
</body>
</html>
