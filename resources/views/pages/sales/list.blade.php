@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de Notas de ventas.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Notas de venta</a>
                </li>
                <li>
                    <a href="#">Listado</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<input type="text" id="find" value="{{$find}}" hidden>

<!-- LISTADO DE COTIZACIONES -->
<div v-if="views.list" v-cloak>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 m-b-5">
           <!-- <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button> -->
          <!--  <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-pdf-o"></i> IMPRIMIR</button> -->
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
             @component('com.find')@endcomponent
        </div>
    </div>
    <hr>
    <div class="row">
        <div v-for="entity in lists" :key="entity.id" class="col-lg-4" style="height: 320px; margin-top: 30px !important; font-size: 12px">
            <div  class="panel panel-border panel-inverse">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-4 col-xs-12">
                            No:<span class="txtblack">@{{ entity.id }}</span>
                            CAG: <span class="txtblack">@{{entity.globals.id}}</span>
                        </div>
                        <div class="col-lg-8 col-xs-12 text-right" style="font-size: 11px">
                            <span class="txtblack">@{{ entity.globals.user.name }}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" :class="{'sales-pagado': entity.status_id === 2 || entity.status_id === 5 || entity.status_id === 7,
                    'sales-recibido': entity.status_id === 1 || entity.status_id === 4 || entity.status_id === 8 }">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            Fecha emisión: <span class="txtblack">@{{dateToEs(entity.moment)}}</span> <span class="txtblack">@{{entity.emit}}</span>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Cliente: <span class="txtblack">@{{entity.globals.client.name}}</span>
                        </div>
                    </div>
                    <div v-if="entity.details.length > 0" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            PRODUCTO: <span class="txtblack">@{{entity.details[0].descrip}}</span>
                        </div>
                    </div>
                    <hr>
                    <div v-if="entity.details.length > 0" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Moto: <span class="txtblack">@{{getTotalItem(entity)}}</span>
                        </div>
                    </div>
                    <div v-if="entity.details.length > 0" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Recibido: <span class="txtblack">@{{entity.advance}}</span>
                        </div>
                    </div>
                    <div v-if="entity.details.length > 0 && getTotalItem(entity) - entity.advance > 0" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Restan: <span class="txtblack" style="color:red">@{{(getTotalItem(entity) - entity.advance).toFixed(2)}}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button v-if="entity.status_id !== 7 && entity.status_id !== 2 && entity.status_id !== 5 && entity.status_id !== 10" class="btn btn-teal waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                            <button v-if="entity.status_id <= 3 && entity.details.length > 0" class="btn btn-primary waves-effect btn-sm" @click="showAplic(entity)">Aplicar</button>
                            <button v-if="entity.status_id >3 && entity.status_id < 7 " class="btn btn-success waves-effect btn-sm" @click="noteDeliverClient(entity.id)">FINALIZAR</button>
                            <button v-if="entity.details.length > 0" class="btn btn-info waves-effect btn-sm" @click="viewpdf(entity.id)"><i class="fa fa-file-pdf-o"></i></button>
                        </div>
                        <div class="col-lg-6 text-right" style="font-style: italic">
                            <span class="txtblack" :class="{'acept': entity.status_id === 7}">@{{entity.status.name  }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
    </div>
</div>

<!-- AÑADIENDO FICHEROS DE COTIZACION A DISTANCIA -->
<div v-if="views.newdetails" class="row" v-cloak>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Nota de venta: @{{item.id}}  a cliente @{{ item.globals.client.name }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-1">
                        <button v-if="item.status_id === 3" class="btn btn-brown btn-default" @click="showFormDet()" >Detalles +</button>
                    </div>
                    <div v-if="item.status_id === 3" class="col-lg-1 text-left">
                        <div class="checkbox checkbox-primary">
                            <input  type="checkbox" v-model="item.have_iva">
                            <label for="checkbox2" class="txtblack">
                                IVA
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div v-if="item.details.length > 0"  class="row m-t-10">
                    <div class="col-lg-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Unida de medida</th>
                                <th>Precio</th>
                                <th>Total</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="detail in item.details">
                                <td>@{{ detail.descrip }}</td>
                                <td>@{{ detail.cant }} </td>
                                <th>@{{ detail.measure.name }}</th>
                                <td>@{{ parseFloat(detail.price).toFixed(2) }} </td>
                                <td>@{{ (parseFloat(detail.price) * detail.cant).toFixed(2) }} </td>
                                <td>
                                    <button v-if="detail.type_item === 3 && item.status_id === 3 && item.origin === 1"
                                        class="btn btn-info btn-sm m-t-5" @click="showCalendar(detail)">
                                        <i class="fa fa-calendar"></i>
                                    </button>
                                    <button v-if="item.status_id === 3" class="btn btn-teal btn-sm m-t-5" @click="showFormDetEdit(detail)">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button v-if="item.status_id === 3" class="btn btn-danger btn-sm m-t-5" @click="deleteDet(detail.id)">
                                        <i class="fa fa-eraser"></i>
                                    </button>
                                </td>
                            </tr>

                            </tbody>
                            <tfoot>
                            <tr >
                                <td></td>
                                <td></td>
                                <td>DESCUENTO</td>
                                <td class="txtblack"><input type="text" v-model="item.discount" class="form-control"> </td>
                                <td>
                                </td>
                            </tr>
                            <tr v-if="item.have_iva === 1 || item.have_iva === true">
                                <td></td>
                                <td></td>
                                <td>IVA (16 %)</td>
                                <td class="txtblack">@{{getIva() }} </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>TOTAL</td>
                                <td class="txtblack">@{{getTotal() }} </td>
                                <td>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td></td>
                                <td style="text-align: right; margin-top: 15px">Pagado</td>
                                <td class="txtblack">
                                    <input v-numeric-only type="text" class="form-control" v-model.number="item.advance">
                                </td>
                                <td>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div v-if="item.strategy !== null" class="row">
                    <span>Estrategia de venta de la cotización.</span>
                    <p class="txtblack">@{{ item.strategy }}</p>
                </div>
            </div>
            <div class="panel-footer footer_fix">
                <button v-if="pass()" class="btn btn-success waves-effect btn-sm" @click="saveDetails()">Guardar</button>
                <button v-if="find == 0 || item.details.length > 0" class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div id="new_det" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Añadir detalle</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12 ">
                            <span class="txtblack">Tipo <span class="require">*</span></span>
                            <select class="form-control" v-model.number="detail.type_item">
                                <option value="1">Inventario</option>
                                <option value="2">Producto</option>
                                <option value="3">Servicio</option>
                            </select>
                        </div>
                        <div class="col-lg-12 m-t-20">
                            <span class="txtblack">@{{TypeShow}}<span class="require">*</span></span>
                            <multiselect style="z-index:2"  v-model="detail.item"
                                         :options="elements"
                                         label="name"
                                         track-by="id"
                                         placeholder=""
                                         @input="updateSelected"
                            ></multiselect>
                        </div>
                        <div class="col-lg-12 m-t-20">
                            <span class="txtblack">Descripción <span class="require">*</span></span>
                            <textarea  v-focus class="form-control" type="text" v-model="detail.descrip"> </textarea>
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack" style="margin-right: 60px">Cantidad <span class="require">*</span> </span>
                            <span v-if="detail.type_item === 1 &&  detail.item !== '' " style="color: #3d4852">Existencias: @{{ detail.item.cant}}</span>
                            <input v-numeric-only class="form-control" type="text" v-model.number="detail.cant">
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">Precio Unitario <span class="require">*</span></span>
                            <input v-numeric-only class="form-control" type="text" v-model.number="detail.price">
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passNewDet()" :disabled="spin" @click="saveNewDet()" class="btn btn-danger waves-effect btn-sm">Guardar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="calendar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Generador de Mantenimiento</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">Inicio <span class="require">*</span></span>
                            <input class="form-control" type="date" v-model="mat.start">
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">Frecuencia <span class="require">*</span></span>
                            <input v-numeric-only class="form-control" type="text" v-model.number="mat.timer">
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="mat.start !== '' && mat.timer > 0" class="btn btn-success  btn-sm" @click="setMant()">Agendar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@component('com.visor_pdf') @endcomponent

<div id="aplicCLientNote" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Aplicar nota de venta</h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Descripcion</th>
                                <th>Existencias </th>
                                <th>Pedido</th>
                                <th>Entregar</th>
                                <th>Restan</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="it in elementsAplicClient" >
                                <td >@{{ it.descrip }}</td>
                                <td :class="[it.avility ? 'acept' : 'noacept']">@{{ it.exis }} </td>
                                <td>@{{ it.cant }} </td>
                                <td>@{{ it.delivered }} </td>
                                <td :class="[it.avility ? 'acept' : 'noacept']">@{{ it.missing }} </td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <div v-if="isNotFull"  class="col-lg-3">
                                <span  class="txtblack">Fecha de entrega (alerta)</span>
                                <input v-focus class="form-control" type="date" v-model="item.deliverydate">
                            </div>
                            <div v-if="item.status_id !== 2" class="col-lg-3">
                                <span class="txtblack">Fecha de pocible pago (alerta)</span>
                                <input v-focus class="form-control" type="date" v-model="item.paimentdate">
                            </div>
                            <div class="col-lg-3">
                                <span class="txtblack">Enviar por correo<span class="require">*</span></span>
                                <select v-model="item.emailto" class="form-control">
                                    <option v-for="user in users" :value="user.email">@{{ user.name }}</option>
                                </select>
                            </div>
                            <div class="col-lg-2 m-t-20">
                                <div class="checkbox checkbox-primary">
                                    <input  type="checkbox" v-model="item.generate_pdf">
                                    <label for="checkbox2" class="txtblack">
                                        Imprimir
                                    </label>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" data-dismiss="modal" class="btn btn-success btn-sm" @click="confirmNote()">Confirmar</a>
                        <a href="#" data-dismiss="modal" class="btn btn-default  btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="redirect" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"
     data-backdrop="static" data-keyboard="false">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Atención</h3>
                    </div>
                    <div class="panel-body">
                        <p>@{{redirect.message}}</p>
                    </div>
                    <div class="panel-footer text-right">
                        <a :href="redirect.patch" class="btn btn-danger waves-effect btn-sm">IR A DOCUMENTO</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@component('com.eliminar')@endcomponent
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/sales.js')}}"></script>
@endsection

