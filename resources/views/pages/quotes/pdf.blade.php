<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cotizacion</title>
    <link href="{{asset('css/quill.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet">
    <style>
        div {
            display: block;
            float: left;
            width: 100%;
            font-size: 12px;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #115830;
            text-decoration: none;
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
        .new-page{
            page-break-after: always;
            page-break-inside: avoid;
        }
        .top {
            border: 1px solid black;
            background-color: #6ba168;
            border-radius: 3px;
            margin-top: 20px;
        }
        .logo {
            width: 15%;
            text-align: center;
            margin-top: 20px
        }
        .generals {
            width: 85%;
            text-align: left;
            margin-top: 15px;
            color: black;
        }
    </style>
</head>
<body>

<div class="top">
    <div class="logo">
        <img src="{{asset('images/gc/logo192.png')}}" alt="" width="96">
    </div>
    <div class="generals">
        <div style="width: 35%; text-align: left;">
            <div style="font-weight:bolder; font-size: 18px">{{$company->name}}</div>
            <div style="padding-bottom: 10px;">{{$company->address}}</div>
        </div>
        <div style="width: 35%; text-align: left;  padding-left: 15px;  border-left: 1px solid rgba(128,128,128,0.49)">
            <span style="font-weight: bolder">Email:</span>
            {{$company->email}} <br>
            <span style="font-weight: bolder">RFC:</span>
            {{$company->rfc}}
        </div>
        <div style="width: 20%; text-align: center; padding-left: 5px; border-left: 1px solid rgba(128,128,128,0.49)">
            <span style="font-weight: bolder">Teléfono:</span>
            {{$company->phone1}} <br>
            <span style="font-weight: bolder">WhastApp:</span>
            {{$company->phone2}}
        </div>
    </div>
</div>
@foreach($data as $key => $dat)
    @php
        $total = 0
    @endphp
    <div  class="new-page">
        @if ($key === 0)
        <div id="details" style="margin-top: 20px" class="clearfix">
            <div id="client" style="width: 50%">
                <div class="to">COTIZADO A:</div>
                <h2 class="name">{{$client->name}}</h2>
                <div class="address">{{$client->address}}</div>
                <div class="email">{{$client->email}}</div>
            </div>
            <div id="invoice" style="width: 50%">
                <h1>COTIZACION {{$quote['id']}}</h1>
                <div class="date">FECHA: {{Carbon\Carbon::parse($quote['moment'])->format('d-m-Y')}}</div>
            </div>
        </div>
        @endif
    <div style="margin: 10px 0 20px 0; text-align: center">
        <h4>{{$dat['descrip']}}</h4>
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
        @foreach ($dat['details'] as $index => $det)
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
        @if ((int)$dat['have_iva'] === 1)
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
            <td colspan="2">DESCUENTO</td>
            <td  class="unit">{{number_format($dat['discount'], 2, '.', '')}}</td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2"></td>
            <td colspan="2">IMPORTE TOTAL</td>
            @if ((int) $dat['have_iva'] === 1)
                <td  class="total">{{number_format($total + $iva - $dat['discount'] , 2, '.', '')}}</td>
            @else
                <td  class="total">{{number_format($total - $dat['discount'], 2, '.', '')}}</td>
            @endif
        </tr>
        </tbody>
    </table>
    <div>
        {!! $dat['specifications'] !!}
    </div>
    </div>
@endforeach
</body>
</html>
