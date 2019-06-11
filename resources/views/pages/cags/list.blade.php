@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Ciclo de atención global</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Ciclos</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div v-if="views.new" class="row" v-cloak>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                        <h3 class="panel-title">@{{title}}</h3>
                    </div>
                    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12 text-right">
                        <span>Atendido por: <span class="txtblack">{{strtoupper(auth()->user()->name)}}</span></span>  <span class="m-l-15 m-t-20 txtblack">No. @{{ item.id }}</span>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2">
                        <button class="btn m-t-20" @click="showNewClient()">Nuevo Cliente</button>
                    </div>
                </div>
                <hr>
                <div  class="row">
                    <div class="col-lg-2 m-t-20">
                        <span class="txtblack">Fecha <span class="require">*</span></span>
                        <input class="form-control" type="date" v-model="item.moment">
                    </div>
                    <div class="col-lg-3 m-t-20">
                        <span class="txtblack">Tipo de contacto <span class="require">*</span></span>
                        <select class="form-control" v-model="item.type_contact_id">
                            <option v-for="typecontact in type_contacts" :value="typecontact.id">@{{ typecontact.name }}</option>
                        </select>

                    </div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Cliente <span class="require">*</span></span>
                        <multiselect style="z-index:10"  v-model="item.client"
                                     :options="clients"
                                     label="name"
                                     track-by="id"
                                     placeholder="">
                        </multiselect>
                    </div>
                    <div class="col-lg-2 m-t-20">
                        <div class="checkbox checkbox-primary">
                            <input  type="checkbox" v-model="item.repeater">
                            <label for="checkbox2" class="txtblack">
                                Recurrente
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Tipo de motivo <span class="require">*</span></span>
                        <select v-model.number="item.type_motive" class="form-control">
                            <option value="1">Producto</option>
                            <option value="2">Servicio</option>
                        </select>
                    </div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Motivo <span class="require">*</span></span>
                        <select v-model.number="item.type_motive_id" class="form-control">
                            <option v-for="typemotive in ArrayTypeMotives" :value="typemotive.id">@{{ typemotive.name }}</option>
                        </select>
                    </div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Tiempo estimado (Dias)<span class="require">*</span></span>
                        <input v-numeric-only class="form-control" type="text" v-model.number="item.required_time">
                    </div>

                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-3">
                        <button class="btn btn-default" @click="showInfo()" >Información <i class="fa fa-plus"></i></button>
                    </div>
                </div>
                <div v-if="item.info.length > 0" class="row">
                    <div class="col-lg-12">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th>Tipo</th>
                                <th>Caracteristica</th>
                                <th>Especificamente</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr class="mouse" v-for="infodet in item.info" >
                                <td class="cel_fix">@{{infodet.info.name}}</td>
                                <td class="cel_fix">@{{infodet.info_det.name}}</td>
                                <td class="cel_fix">@{{infodet.info_descrip}}</td>
                                <td class="cel_fix">
                                    <button class="btn btn-danger btn-sm" @click="deleteInfo(infodet.id)"><i class="fa fa-eraser"></i></button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr v-if="item.info.length <= 0" >
                <div class="row">
                    <div class="col-lg-12">
                        <span class="txtblack">Observaciones <span class="require">*</span></span>
                        <textarea class="form-control" v-model="item.note"></textarea>
                    </div>
               </div>
                <div class="row m-t-20">
                    <div class="col-lg-2">
                        <div class="radio radio-primary checkbox-inline">
                            <input type="radio"  id="radio1" value="1" v-model.number="item.type_compromise_id">
                            <label for="radio1">
                                Nota de venta
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="radio radio-primary checkbox-inline">
                        <input type="radio"  id="radio03" value="2" v-model.number="item.type_compromise_id">
                        <label for="radio03">
                             Cotización a distancia
                        </label>
                    </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="radio radio-primary checkbox-inline">
                            <input type="radio"  id="radio3" value="3" v-model.number="item.type_compromise_id" @click="showVisit()">
                            <label for="radio3">
                                Cotización a domicilio
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="radio radio-primary checkbox-inline">
                            <input type="radio" id="radio4" value="4" v-model.number="item.type_compromise_id" @click="showSendInfo()">
                            <label for="radio4">
                                Envio de información
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel-footer footer_fix">
                <button v-if="pass()" class="btn btn-success waves-effect btn-sm" @click="save()">Guardar</button>
                <button class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<div v-if="views.list" v-cloak>
    <div class="row m-b-10">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 m-b-5">
           <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <!--  <find :filters="filters_list" filter="value" v-on:getfilter="getlist" holder="buscar material"></find> -->
            @component('com.find')@endcomponent
        </div>
    </div>
    <hr>
    <div v-if="lists.length === 0 && filters_list.value !== ''" class="row text-center">NO EXISTEN DATOS PARA: <span class="txtblack">@{{ filters_list.value.toUpperCase() }}</span> </div>
    <div class="row">
        <div v-for="entity in lists" :key="entity.id" class="col-lg-4 col-md-6 col-sm-6 ">
            <div  class="panel panel-border panel-inverse m-t-5" style="font-size: 12px;">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-3 col-xs-12">
                            No:<span class="txtblack">@{{ entity.id }}</span>
                        </div>
                        <div class="col-lg-9 col-xs-12 text-right" style="font-size: 11px">
                            <span class="txtblack">@{{ entity.attended.name }}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body" style="height: 230px">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha emisión: <span class="txtblack">@{{dateToEs(entity.moment)}}</span> <span class="txtblack">@{{entity.emit}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{entity.client.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Motivo: <span class="txtblack">@{{getMotive(entity)}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Tiempo estimado (dias): <span class="txtblack">@{{entity.required_time}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Contacto por: <span class="txtblack">@{{entity.contact.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Compromiso: <span class="txtblack">@{{entity.compromise.name}}</span>
                                </div>
                            </div>
                            <div v-if="entity.type_compromise_id !== 3" class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha de ejecucion: <span class="txtblack">@{{dateToEs(entity.moment)}}</span>
                                </div>
                            </div>
                            <div v-if="entity.landscaper && entity.landscaper.moment" class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Fecha de ejecucion: <span class="txtblack">@{{dateToEs(entity.landscaper.moment)}}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-center m-t-10">
                            <knob-control
                                :min="0"
                                :max="16"
                                :value-display-function="toWord"
                                v-model="entity.traser"
                                :primary-color="colors(parseInt(entity.traser))"
                            ></knob-control>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-lg-4">
                            <button v-if="parseInt(entity.status_id) === 1" class="btn btn-teal waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                            <button v-if="parseInt(entity.status_id) === 1" class="btn btn-danger waves-effect btn-sm" @click="showdelete(trait(entity))"><i class="fa fa-eraser"></i></button>
                            <button class="btn btn-info waves-effect btn-sm" @click="showpdf(entity.id)"><i class="fa fa-file-pdf-o"></i></button>
                        </div>
                        <div class="col-lg-8 text-right" style="font-style: italic; font-size: 11px">
                            <span class="txtblack">@{{entity.status.name  }}</span>
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

<!-- MODAL DE VISTA A DOMICILIO -->
<div id="visita" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Programar visita de paisajista</h3>
                    </div>
                    <div class="panel-body">
                        <span class="txtblack">Fecha<span class="require">*</span></span>
                        <input type="date" class="form-control" v-model="item.landscaper.moment">
                        <br>
                        <span class="txtblack">Hora<span class="require">*</span></span>
                        <input type="time" class="form-control" v-model="item.landscaper.timer">
                        <br>
                        <span class="txtblack m-t-10">Paisajista<span class="require">*</span></span>
                        <select class="form-control" v-model="item.landscaper.user_uid">
                            <option v-for="scapers in landscapers" :value="scapers.uid">@{{ scapers.name }}</option>
                        </select>
                        <br>
                        <span class="txtblack m-t-10">Nota<span class="require">*</span></span>
                        <textarea type="text" class="form-control" v-model="item.landscaper.note"></textarea>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passScaper()" :disabled="spin" data-dismiss="modal" class="btn btn-danger waves-effect btn-sm">Guardar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ENVIO DE INFORMACION AL CLIENTE -->
<div id="sendinfo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Información a enviar al cliente</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <span class="txtblack">Fecha <span class="require">*</span></span>
                                <input class="form-control" type="date" v-model="item.documents.moment">
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio9" value="1" v-model.number="item.documents.type_info_id">
                                    <label for="radio9">
                                        Enviar catalogos
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio10" value="2" v-model.number="item.documents.type_info_id">
                                    <label for="radio10">
                                       Enviar recomendaciones
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio11" value="3" v-model.number="item.documents.type_info_id">
                                    <label for="radio11">
                                        Enviar información general
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio12" value="4" v-model.number="item.documents.type_info_id">
                                    <label for="radio12">
                                        El cliente nos enviara la información
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passInfoSend()" :disabled="spin"  data-dismiss="modal" class="btn btn-danger waves-effect btn-sm">Guardar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
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
                       <!-- <a v-if="this.item.type_compromise_id == " href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- RECOGIDA DE PRODUCTOS O SERVICIOS MOSTRADOS -->
<div id="info" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Producto o servicios mostrados</h3>
                    </div>
                    <div class="panel-body">
                        <span class="txtblack">Tipo<span class="require">*</span></span>
                        <select class="form-control" v-model="info">
                            <option v-for="info in type_infos" :value="info">@{{ info.name }}</option>
                        </select>
                        <br>
                        <span class="txtblack">Caracteristica<span class="require">*</span></span>
                        <select class="form-control" v-model="info_det">
                            <option v-for="inf in info.detail" :value="inf">@{{ inf.name }}</option>
                        </select>
                        <br>
                        <span class="txtblack m-t-10">Especificamente<span class="require">*</span></span>
                        <input type="text" class="form-control" v-model="info_descrip">
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passInfo()" :disabled="spin" @click="saveNewInfo()" class="btn btn-danger waves-effect btn-sm">Guardar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- NUEVO CLIENTE -->
<div id="client_new" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Añadir cliente</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">Codigo <span class="require">*</span></span>
                            <input disabled  class="form-control" type="text" v-model="client.code">
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">Nombre cliente <span class="require">*</span></span>
                            <input v-focus class="form-control" type="text" v-model="client.name">
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">Contacto <span class="require">*</span></span>
                            <input class="form-control" type="text" v-model="client.contact">
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">Email <span class="require">*</span></span>
                            <input class="form-control" type="text" v-model="client.email" >
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span  class="txtblack">Telefono local <span class="require">*</span></span>
                            <input v-numeric-only class="form-control" type="text" v-model="client.phone" >
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span  class="txtblack">Celular <span class="require">*</span></span>
                            <input v-numeric-only class="form-control" type="text" v-model="client.movil">
                        </div>
                        <div class="col-lg-12 m-t-20">
                            <span class="txtblack">Dirección <span class="require">*</span></span>
                            <input class="form-control" type="text" v-model="client.address">
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passClient()" :disabled="spin" @click="saveNewClient()" class="btn btn-danger waves-effect btn-sm">Guardar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@component('com.visor_pdf') @endcomponent
@component('com.eliminar')@endcomponent
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/cags.js')}}"></script>
@endsection
