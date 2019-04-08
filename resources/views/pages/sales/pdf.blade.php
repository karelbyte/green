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
        .th {
            padding: 10px 10px 10px 10px;
        }
        .th_r{
            padding: 10px 10px 10px 10px; text-align: right
        }
        .td {
           padding: 5px 5px 5px 10px; border-bottom: 1px solid rgba(169,169,169,0.29)
        }
        td_r {
            padding: 5px 5px 5px 10px; border-bottom: 1px solid rgba(169,169,169,0.29);text-align: right
        }
    </style>
</head>
<body>
@php
    $total = 0
@endphp
   <p class="ql-align-center">
       <span style="color: black; font-size: 16px">{!! $data['descrip'] !!}</span>
   </p>

<div style="width: 100%; text-align: left; margin-top: 25px; border: 2px solid grey;">
    <table style="width: 100%">
        <thead>
        <tr style="font-weight: bold; background-color: rgba(201,201,201,0.28); font-size: 11px;">
            <th class="th">Descripción</th>
            <th class="th">Cantidad</th>
            <th class="th">Precio Unitario</th>
            <th class="th">Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data['details'] as $det)
            <tr style="font-size: 10px;">
                <td class="td">{{$det->descrip}}</td>
                <td class="td">{{$det->cant}}</td>
                <td class="td">{{$det->price}}</td>
                <td class="td">{{number_format($det->price * $det->cant, 2, '.', '')}}</td>
                @php
                    $total += $det->price * $det->cant
                @endphp
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
   <div style="width: 100%">
       <div style="width: 60%"></div>
       <div style="width: 40%">
           <table  style="width: 100%;">
               <thead>
               <tr style="font-weight: bold; background-color: rgba(201,201,201,0.28); font-size: 11px;">
                   <th style="padding: 10px 10px 10px 10px;">Base Imponible</th>
                   <th style="padding: 10px 10px 10px 10px;">Tipo IVA</th>
                   <th style="padding: 10px 10px 10px 10px;">IVA</th>
               </tr>
               </thead>
               <tbody>
               <tr style="font-size: 10px;">
                   <td style="padding: 5px 5px 5px 10px; border-bottom: 1px solid rgba(169,169,169,0.29);">{{number_format($total, 2, '.', '')}}</td>
                   <td style="padding: 5px 5px 5px 10px; border-bottom: 1px solid rgba(169,169,169,0.29);">16%</td>
                   @php
                       $iva = $total * 0.16
                   @endphp
                   <td style="padding: 5px 5px 5px 10px; border-bottom: 1px solid rgba(169,169,169,0.29);">{{$iva}}</td>
               </tr>
               </tbody>
           </table>
       </div>
   </div>
<div style="margin-top: 15px; width: 100%">
    <div style="width: 30%;">

    </div>
    <div style="width: 23%;">
    </div>
    <div style="width: 35%; font-weight: bold;  padding: 10px 10px 10px 10px; background-color: rgba(201,201,201,0.28); border: 2px solid grey; float: right ">
        <div style="width: 50%; text-align: left"><span>Total:</span></div>
        <div style="width: 50%; text-align: right">{{number_format($total + $iva, 2, '.', '')}}</div>
    </div>
</div>
  <div>
      {!! $data['specifications'] !!}
  </div>
</body>
</html>
