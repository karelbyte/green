@extends('layouts.main')

@section('content')
@parent
<div v-if="landscapers.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
           <h3>VISITAS A DOMICILIOS PARA HOY</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >CAG</th>
                    <th >Cliente</th>
                    <th >Dirección</th>
                    <th >Hora</th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="land in landscapers" :key="land.id">
                    <td >@{{land.id}}</td>
                    <td >@{{land.global.client.name}}</td>
                    <td >@{{land.global.client.address}}</td>
                    <td >@{{land.timer}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div v-if="quoteconfirm.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
            <h3>LLAMADAS DE CONFIRMACION PARA HOY</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >Cotizacion</th>
                    <th >Cliente</th>
                    <th >Telefono</th>
                    <th >Correo</th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="con in quoteconfirm" :key="con.id">
                    <td >@{{con.id}}</td>
                    <td >@{{con.globals.client.name}}</td>
                    <td >@{{con.globals.client.phone}}</td>
                    <td >@{{con.globals.client.email}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div v-if="quoteconfirm.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
            <h3>CLIENTES EN SEGUIMIENTO PARA HOY</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >Cotizacion</th>
                    <th >Cliente</th>
                    <th >Telefono</th>
                    <th >Correo</th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="tra in quotetracing" :key="tra.id">
                    <td >@{{tra.id}}</td>
                    <td >@{{tra.globals.client.name}}</td>
                    <td >@{{tra.globals.client.phone}}</td>
                    <td >@{{tra.globals.client.email}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/notifications.js')}}"></script>
@endsection
