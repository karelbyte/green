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
   RECEPCION DE {{$data['types']['name']}}
</div>
<div>
    Fecha: {{$data['moment']}}
</div>
<div>
    Codigo: {{$data['code']}}
</div>
<table class="table table-hover">
    <thead>
    <tr>
        <th class="cel_fix">Codigo</th>
        <th class="cel_fix">Descripción</th>
        <th class="cel_fix">Cantidad</th>
    </tr>
    </thead>
    <tbody>
    @foreach($data['details'] as $entity)
        <tr>
            <td class="cel_fix">{{$entity['element']['code']}}</td>
            <td class="cel_fix">{{$entity['element']['name']}}</td>
            <td class="cel_fix">{{$entity['cant']}}</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>

</html>
