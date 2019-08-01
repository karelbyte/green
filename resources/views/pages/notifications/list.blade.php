@extends('layouts.main')

@section('content')
@parent
<div v-if="not" class="row m-t-20" v-cloak>
    <div class="col-lg-12 text-center">
        <h3>NO HAY NOTIFICACIONES</h3>
    </div>
</div>
<!-- SERVICIOS O PRODUCTOS EN TERMINO DE ENTREGA RESPONSIVA -->
<div v-if="sale_note_not_delivered.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>SERVICIOS O PRODUCTOS EN TERMINO DE ENTREGA</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th >Nota</th>
                            <th >Cliente</th>
                            <th >PRODUCTO / SERVICIO</th>
                            <th >Fecha Emision</th>
                            <th >Fecha Entrega</th>
                            <th >Asesor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="deli in sale_note_not_delivered" :key="deli.id">
                            <td >@{{deli.id}}</td>
                            <td >@{{deli.client}}</td>
                            <td >@{{deli.motive}}</td>
                            <td >@{{deli.moment}}</td>
                            <td >@{{deli.deliverydate}}</td>
                            <td >@{{deli.user}}</td>
                            <td> <a :href="gotoUrl(deli.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>SERVICIOS O PRODUCTOS EN TERMINO DE ENTREGA</h4>
            </div>
            <div v-for="deli in sale_note_not_delivered" :key="deli.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Nota: <span class="txtblack">@{{deli.id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{deli.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    PRODUCTO O SERVICIO: <span class="txtblack">@{{deli.motive}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha Emision: <span class="txtblack">@{{deli.moment}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha de entrega: <span class="txtblack">@{{deli.deliverydate}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Paisajista: <span class="txtblack">@{{deli.user}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(deli.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- VISITAS A DOMICILIO  RESPONSIVA -->
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
                            <th >Producto / Servicio</th>
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
                            <td >@{{land.cag}}</td>
                            <td >@{{land.client}}</td>
                            <td >@{{land.motive}}</td>
                            <td >@{{land.address}}</td>
                            <td >@{{land.referen}}</td>
                            <td >@{{land.moment}}</td>
                            <td >@{{land.timer}}</td>
                            <td >@{{land.user}}</td>
                            <td ><a :href="gotoUrl(land.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
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
                                    CAG: <span class="txtblack">@{{land.cag}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{land.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Producto o Servicio: <span class="txtblack">@{{land.motive}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Dirección: <span class="txtblack">@{{land.address }}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Referencia: <span class="txtblack">@{{land.referen }}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                   Fecha: <span class="txtblack">@{{land.moment}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Hora: <span class="txtblack">@{{land.timer}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Paisajista: <span class="txtblack">@{{land.user}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(land.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a>
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
                            <th >PRODUCTO O SERVICIO</th>
                            <th >Fecha</th>
                            <th >Asesor</th>
                            <th ></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="visit_home in visit_home_end" :key="visit_home.id">
                            <td >@{{visit_home.cag}}</td>
                            <td >@{{visit_home.client}}</td>
                            <td >@{{visit_home.motive}}</td>
                            <td >@{{dateToEs(visit_home.check_date)}}</td>
                            <td >@{{visit_home.user}}</td>
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
                                    CAG: <span class="txtblack">@{{visit_home.cag}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{visit_home.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha: <span class="txtblack">@{{dateToEs(visit_home.check_date)}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Asesor: <span class="txtblack">@{{visit_home.user}}</span>
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
<!-- CONFIRMACION DE ENVIO DE CONTIZACION RESPONSIVO CON RESOURCE -->
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
                            <th >PRODUCTO O SERVICIO</th>
                            <th >Telefono</th>
                            <th >Correo</th>
                            <th >Asesor</th>
                            <th ></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="con in quoteconfirm" :key="con.id">
                            <td >@{{con.id}}</td>
                            <td >@{{con.check_date}}</td>
                            <td >@{{con.client}}</td>
                            <td >@{{con.motive}}</td>
                            <td >@{{con.phone}}</td>
                            <td >@{{con.email}}</td>
                            <td >@{{con.user}}</td>
                            <td>   <a :href="gotoUrl(con.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
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
                                    Fecha: <span class="txtblack">@{{con.check_date}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{con.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{con.motive}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Telefono: <span class="txtblack">@{{con.phone}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Correo: <span class="txtblack">@{{con.email}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Asesor: <span class="txtblack">@{{con.user}}</span>
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
<!-- SEGIMIENTO DE CLIOENTE CONTIZACION RESPONSIVO CON RESOURCE -->
<div v-if="quotetracing.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>CLIENTES EN SEGUIMIENTO PARA HOY</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th >Cotizacion</th>
                            <th >Fecha</th>
                            <th >Cliente</th>
                            <th >PRODUCTO O SERVICIO</th>
                            <th >Telefono</th>
                            <th >Correo</th>
                            <th >Asesor</th>
                            <th ></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="tra in quotetracing" :key="tra.id">
                            <td >@{{tra.id}}</td>
                            <td >@{{tra.moment}}</td>
                            <td >@{{tra.client}}</td>
                            <td >@{{tra.motive}}</td>
                            <td >@{{tra.phone}}</td>
                            <td >@{{tra.email}}</td>
                            <td >@{{tra.user}}</td>
                            <td> <a :href="gotoUrl(tra.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>CLIENTES EN SEGUIMIENTO PARA HOY</h4>
            </div>
            <div v-for="tras in quotetracing" :key="tras.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Cotización: <span class="txtblack">@{{tras.id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha: <span class="txtblack">@{{tras.check_date}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{tras.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Telefono: <span class="txtblack">@{{tras.motive}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Telefono: <span class="txtblack">@{{tras.phone}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Correo: <span class="txtblack">@{{tras.email}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(tras.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- NOTA DE VENTA EN GESTION DE COBRANZA RESPONSIVO CON RESOURCE -->
<div v-if="sale_note_not_payment.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>NOTAS DE VENTAS EN GESTION DE CABRANZA</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Nota</th>
                            <th>Fecha Emision</th>
                            <th>Cliente</th>
                            <th>Producto / Servicio</th>
                            <th>Fecha Cobro</th>
                            <th>Asesor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="pay in sale_note_not_payment" :key="pay.id">
                            <td >@{{pay.id}}</td>
                            <td >@{{pay.moment}}</td>
                            <td >@{{pay.client}}</td>
                            <td >@{{pay.motive}}</td>
                            <td >@{{pay.paimentdate}}</td>
                            <td >@{{pay.user}}</td>
                            <td> <a :href="gotoUrl(pay.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>NOTAS DE VENTAS EN GESTION DE CABRANZA</h4>
            </div>
            <div  v-for="pay in sale_note_not_payment" :key="pay.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Nota: <span class="txtblack">@{{pay.id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha: <span class="txtblack">@{{pay.moment}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{pay.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Producto / Servicio: <span class="txtblack">@{{pay.motive}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha de cobro: <span class="txtblack">@{{pay.paimentdate}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Asesor: <span class="txtblack">@{{pay.user}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(pay.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div v-if="sale_note_not_close.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>PEDIDOS PARA HABILITAR</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th >Nota</th>
                            <th >Fecha</th>
                            <th >Cliente</th>
                            <th >Producto / Servicio</th>
                            <th >Asesor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="sale in sale_note_not_close" :key="sale.id">
                            <td >@{{sale.id}}</td>
                            <td >@{{sale.moment}}</td>
                            <td >@{{sale.client}}</td>
                            <td >@{{sale.motive}}</td>
                            <td >@{{sale.user}}</td>
                            <td> <a :href="gotoUrl(sale.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>PEDIDOS PARA HABILITAR</h4>
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
                                    Facha: <span class="txtblack">@{{sale.moment}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Asesor: <span class="txtblack">@{{sale.user}}</span>
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
<!-- COTIZACION A DISTANCIA SIN TERMINAR CON RESPOSIVE Y RESOURCE -->
<div v-if="quote_local_close.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
                <div class="panel-heading text-center">
                    <h3>COTIZACION A DISTANCIA SIN TERMINAR</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th >Cotizacion</th>
                            <th >Cliente</th>
                            <th >Producto / Servicio</th>
                            <th >Fecha</th>
                            <th >Asesor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="quote_local in quote_local_close" :key="quote_local.id">
                            <td >@{{quote_local.id}}</td>
                            <td >@{{quote_local.client}}</td>
                            <td >@{{quote_local.motive}}</td>
                            <td >@{{quote_local.moment}}</td>
                            <td >@{{quote_local.user}}</td>
                            <td> <a :href="gotoUrl(quote_local.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>COTIZACION A DISTANCIA SIN TERMINAR</h4>
            </div>
            <div v-for="quote_local in quote_local_close" :key="quote_local.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Cotizacion: <span class="txtblack">@{{quote_local.id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Facha: <span class="txtblack">@{{quote_local.moment}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{quote_local.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{quote_local.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Asesor: <span class="txtblack">@{{quote_local.user}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(quote_local.id, 1)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- ENVIO DE RECOMENDACIONES  CON RESPOSIVE Y RESOURCE -->
<div v-if="qualities_send_info.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
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
                            <th >Producto / Servicio</th>
                            <th >Asesor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="recomen in  qualities_send_info" :key="recomen.id">
                            <td >@{{recomen.cag}}</td>
                            <td >@{{recomen.moment}}</td>
                            <td >@{{recomen.client}}</td>
                            <td >@{{recomen.motive}}</td>
                            <td >@{{recomen.user}}</td>
                            <td> <a :href="gotoUrl(recomen.id, 3)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>CLIENTES POR ENVIAR RECOMENDACIONES</h4>
            </div>
            <div v-for="recomen in  qualities_send_info"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    CAG: <span class="txtblack">@{{recomen.cag}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Facha: <span class="txtblack">@{{recomen.moment}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{recomen.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{recomen.motive}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Producto / Servicio: <span class="txtblack">@{{recomen.user}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(recomen.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<div v-if="qualities_send_info_confirm.length > 0" class="row m-t-20" v-cloak>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
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
                            <th >Producto / Servicio</th>
                            <th >Asesor</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="recomen_confirm in  qualities_send_info_confirm" :key="recomen_confirm.id">
                            <td >@{{recomen_confirm.cag}}</td>
                            <td >@{{recomen_confirm.moment}}</td>
                            <td >@{{recomen_confirm.client}}</td>
                            <td >@{{recomen_confirm.motive}}</td>
                            <td >@{{recomen_confirm.user}}</td>
                            <td> <a :href="gotoUrl(recomen_confirm.id, 3)" style="font-style: oblique">IR A DOCUMENTO</a></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div class="panel-heading text-center">
                <h4>CLIENTES POR CONFIRMAR RECOMENDACIONES</h4>
            </div>
            <div v-for="recomen_confirm in  qualities_send_info_confirm" :key="recomen_confirm.id" class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    CAG: <span class="txtblack">@{{recomen_confirm.cag}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Facha: <span class="txtblack">@{{recomen_confirm.moment}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{recomen_confirm.client}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Producto / Servicio: <span class="txtblack">@{{recomen_confirm.motive}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Asesor: <span class="txtblack">@{{recomen_confirm.user}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    <a :href="gotoUrl(recomen_confirm.id, 2)" style="font-style: oblique">IR A DOCUMENTO</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/notifications.js')}}"></script>
@endsection
