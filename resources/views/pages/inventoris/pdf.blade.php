<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GreenCenter CRM">
    <meta name="author" content="desarrollos@elpuertodigital.com">
    <link rel="shortcut icon" href="{{asset('icon.ico')}}">
    <title>GreenCenter CRM Inventario</title>
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />

</head>

<body>
<div>
   <h5>{{$company->name}}</h5>
</div>
<div>
    <h4>INVENTARIO DE @if($type == 1) PRODUCTOS @else HERRAMIENTAS @endif</h4>
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th class="cel_fix">Codigo</th>
        <th class="cel_fix">Descripción</th>
        @if($type == 1)
            <th class="cel_fix">Unidad de Medida</th>
            <th class="cel_fix">Precio al publico</th>
        @endif
        <th class="cel_fix">Existencias</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data as $entity)
        <tr>
            <td class="cel_fix">{{$entity->code}}</td>
            <td class="cel_fix">{{$entity->name}}</td>
            @if($type == 1)
                <td class="cel_fix">{{$entity->um}}</td>
                <td class="cel_fix">{{$entity->price}}</td>
            @endif
            <td class="cel_fix">{{$entity->cant}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>

</html>
