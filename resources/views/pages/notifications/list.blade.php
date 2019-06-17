@extends('layouts.main')

@section('content')
@parent
<div v-if="not" class="row m-t-20" v-cloak>
    <div class="col-lg-12 text-center">
        <h3>NO HAY NOTIFICACIONES</h3>
    </div>
</div>

<div v-if="sale_note_not_delivered.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
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
                            <th >Referencia</th>
                            <th >Fecha</th>
                            <th >Hora</th>
                            <th >Paisajista</th>
                            <th ></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="land in landscapers" :key="land.id">
                            <td >@{{land.cglobal_id}}</td>
                            <td >@{{land.global.client.name}}</td>
                            <td >@{{land.global.client.street  + ' #' + land.global.client.home_number + ' ' + land.global.client.colony}}</td>
                            <td >@{{land.global.client.referen}}</td>
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
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>VISITAS A DOMICILIOS</h4>
            </div>
            <div v-for="land in landscapers" :key="land.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    CAG: <span class="txtblack">@{{land.cglobal_id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{land.global.client.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Dirección: <span class="txtblack">@{{land.global.client.street  + ' #' + land.global.client.home_number + ' ' + land.global.client.colony }}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Referencia: <span class="txtblack">@{{land.global.client.referen }}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                   Fecha: <span class="txtblack">@{{dateToEs(land.moment)}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Hora: <span class="txtblack">@{{land.timer}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Paisajista: <span class="txtblack">@{{land.user.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(land.global.quote.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
               </div>
           </div>
      </div>
</div>

<!-- VISITA CONCLUIDA EN FACE DE ELAVORACION DE COTIZACION -->
<div v-if="visit_home_end.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>VISITA A DOMICILIO CONCLUIDA SIN COTIZACION</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th >CAG</th>
                            <th >Cliente</th>
                            <th >Fecha</th>
                            <th >Usuario</th>
                            <th ></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="visit_home in visit_home_end" :key="visit_home.id">
                            <td >@{{visit_home.cglobal_id}}</td>
                            <td >@{{visit_home.globals.client.name}}</td>
                            <td >@{{dateToEs(visit_home.check_date)}}</td>
                            <td >@{{visit_home.globals.user.name}}</td>
                            <td ><a :href="gotoUrl(visit_home.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
      <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>VISITA A DOMICILIO CONCLUIDA SIN COTIZACION</h4>
            </div>
            <div v-for="visit_home in visit_home_end" :key="visit_home.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    CAG: <span class="txtblack">@{{visit_home.cglobal_id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{visit_home.globals.client.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha: <span class="txtblack">@{{dateToEs(visit_home.check_date)}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Paisajista: <span class="txtblack">@{{visit_home.globals.user.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(visit_home.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div v-if="quoteconfirm.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>VERIFICACION DE RECEPCION DE COTIZACION</h3>
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
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>VERIFICACION DE RECEPCION DE COTIZACION</h4>
            </div>
            <div v-for="con in quoteconfirm" :key="con.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Cotización: <span class="txtblack">@{{con.id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha: <span class="txtblack">@{{dateToEs(con.check_date)}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{con.globals.client.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Telefono: <span class="txtblack">@{{con.globals.client.phone}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Correo: <span class="txtblack">@{{con.globals.client.email}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(con.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div v-if="quotetracing.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
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
    <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>NOTAS DE VENTAS SIN APLICAR</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th >Nota</th>
                            <th >Fecha</th>
                            <th >Cliente</th>
                            <th >Usuario</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="sale in sale_note_not_close" :key="sale.id">
                            <td >@{{sale.id}}</td>
                            <td >@{{dateToEs(sale.moment)}}</td>
                            <td >@{{sale.globals.client.name}}</td>
                            <td >@{{sale.globals.user.name}}</td>
                            <td> <a :href="gotoUrl(sale.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>NOTAS DE VENTAS SIN APLICAR</h4>
            </div>
            <div v-for="sale in sale_note_not_close" :key="sale.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Nota: <span class="txtblack">@{{sale.id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Facha: <span class="txtblack">@{{dateToEs(sale.moment)}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Usuario: <span class="txtblack">@{{sale.globals.user.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(sale.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div v-if="quote_local_close.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
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

<div v-if="qualities_send_info.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
        <div class="panel-heading text-center">
            <h3>CLIENTES POR ENVIAR RECOMENDACIONES</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >CAG</th>
                    <th >Fecha</th>
                    <th >Cliente</th>
                    <th >Usuario</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="recomen in  qualities_send_info" :key="recomen.id">
                    <td >@{{recomen.cglobal_id}}</td>
                    <td >@{{dateToEs(recomen.moment)}}</td>
                    <td >@{{recomen.global.client.name}}</td>
                    <td >@{{recomen.global.user.name}}</td>
                    <td> <a :href="gotoUrl(recomen.id, 3)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div v-if="qualities_send_info_confirm.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
        <div class="panel-heading text-center">
            <h3>CLIENTES POR CONFIRMAR RECOMENDACIONES</h3>
        </div>
        <div class="panel-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th >CAG</th>
                    <th >Fecha</th>
                    <th >Cliente</th>
                    <th >Usuario</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr class="mouse" v-for="recomen_confirm in  qualities_send_info_confirm" :key="recomen_confirm.id">
                    <td >@{{recomen_confirm.cglobal_id}}</td>
                    <td >@{{dateToEs(recomen_confirm.info_send_date)}}</td>
                    <td >@{{recomen_confirm.global.client.name}}</td>
                    <td >@{{recomen_confirm.global.user.name}}</td>
                    <td> <a :href="gotoUrl(recomen_confirm.id, 3)" style="font-style: oblique">IR A DOCUMENTO</a></td>
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
