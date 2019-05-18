@extends('layouts.main')

@section('content')
@parent
<div v-if="not" class="row m-t-20" v-cloak>
    <div class="col-lg-12 text-center">
        <h3>NO HAY NOTIFICACIONES</h3>
    </div>
</div>

<div v-if="sale_note_not_delivered.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
            <h3>SERVICIOS O PRODUCTOS EN TERMINO DE ENTREGA</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >Nota</th>
                    <th >Fecha Emision</th>
                    <th >Fecha Entrega</th>
                    <th >Usuario</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="deli in sale_note_not_delivered" :key="deli.id">
                    <td >@{{deli.id}}</td>
                    <td >@{{dateToEs(deli.moment)}}</td>
                    <td >@{{dateToEs(deli.deliverydate)}}</td>
                    <td >@{{deli.globals.user.name}}</td>
                    <td> <a :href="gotoUrl(deli.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div v-if="landscapers.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
           <h3>VISITAS A DOMICILIOS</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >CAG</th>
                    <th >Cliente</th>
                    <th >Dirección</th>
                    <th >Fecha</th>
                    <th >Hora</th>
                    <th >Paisajista</th>
                    <th ></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="land in landscapers" :key="land.id">
                    <td >@{{land.id}}</td>
                    <td >@{{land.global.client.name}}</td>
                    <td >@{{land.global.client.address}}</td>
                    <td >@{{dateToEs(land.moment)}}</td>
                    <td >@{{land.timer}}</td>
                    <td >@{{land.user.name}}</td>
                    <td ><a :href="gotoUrl(land.global.quote.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
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
                    <th >Fecha</th>
                    <th >Cliente</th>
                    <th >Telefono</th>
                    <th >Correo</th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="con in quoteconfirm" :key="con.id">
                    <td >@{{con.id}}</td>
                    <td >@{{dateToEs(con.check_date)}}</td>
                    <td >@{{con.globals.client.name}}</td>
                    <td >@{{con.globals.client.phone}}</td>
                    <td >@{{con.globals.client.email}}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div v-if="quotetracing.length > 0" class="row m-t-20" v-cloak>
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
                    <th ></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="tra in quotetracing" :key="tra.id">
                    <td >@{{tra.id}}</td>
                    <td >@{{tra.globals.client.name}}</td>
                    <td >@{{tra.globals.client.phone}}</td>
                    <td >@{{tra.globals.client.email}}</td>
                    <td> <a :href="gotoUrl(tra.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div v-if="sale_note_not_payment.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
            <h3>NOTAS DE VENTAS EN GESTION DE CABRANZA</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >Nota</th>
                    <th >Fecha Emision</th>
                    <th >Fecha Cobro</th>
                    <th >Usuario</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="pay in sale_note_not_payment" :key="pay.id">
                    <td >@{{pay.id}}</td>
                    <td >@{{dateToEs(pay.moment)}}</td>
                    <td >@{{dateToEs(pay.paimentdate)}}</td>
                    <td >@{{pay.globals.user.name}}</td>
                    <td> <a :href="gotoUrl(pay.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div v-if="sale_note_not_close.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
            <h3>NOTAS DE VENTAS SIN APLICAR</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >Nota</th>
                    <th >Fecha</th>
                    <th >Usuario</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="sale in sale_note_not_close" :key="sale.id">
                    <td >@{{sale.id}}</td>
                    <td >@{{dateToEs(sale.moment)}}</td>
                    <td >@{{sale.globals.user.name}}</td>
                    <td> <a :href="gotoUrl(sale.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div v-if="quote_local_close.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
            <h3>COTIZACION A DISTANCIA SIN TERMINAR</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >Cotizacion</th>
                    <th >Fecha</th>
                    <th >Usuario</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="quote_local in quote_local_close" :key="quote_local.id">
                    <td >@{{quote_local.id}}</td>
                    <td >@{{dateToEs(quote_local.moment)}}</td>
                    <td >@{{quote_local.globals.user.name}}</td>
                    <td> <a :href="gotoUrl(quote_local.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
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
