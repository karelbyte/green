@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de cotizaciones.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Cotizaciones</a>
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
<a href="https://web.whatsapp.com/" target="_blank" id="wass" hidden></a>
 <!-- AÑADIENDO FICHEROS DE COTIZACION A DOMICIOLIO -->
<div v-if="views.newfiles" class="row" v-cloak>
    <div class="col-lg-10">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Cotizacion: @{{item.id}}</h3>
            </div>
            <div class="panel-body">
                <div class="row m-t-20">
                    <div class="col-lg-12">
                        <button class="btn btn-default btn-default" @click="showCamera()" >Imagen o video +</button>
                        <button class="btn btn-default btn-default" @click="showNote()">Nota + </button>
                        <input type="file" id="file" capture=camera style="display: none" @change="saveFile($event)">
                    </div>

                </div>
                <hr>
                <div v-for="doc in item.docs" class="row m-t-10">
                    <div class="col-lg-6"><a :href="doc.url" target="_blank"> @{{ doc.name }} </a> </div>
                    <div class="col-lg-6">
                        <button class="btn btn-default btn-sm" @click="showVisor(doc)"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteFile(doc.id)"><i class="fa fa-eraser"></i></button>
                    </div>
                </div>
                <div v-for="not in item.notes" class="row m-t-10">
                    <div class="col-lg-8"><textarea disabled class="form-control">@{{ not.note }}</textarea> </div>
                    <div class="col-lg-2">
                        <button class="btn btn-danger btn-sm m-t-5" @click="deleteNote(not.id)"><i class="fa fa-eraser"></i></button>
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

<!-- AÑADIENDO FICHEROS DE COTIZACION A DISTANCIA -->
<div v-if="views.newdetails" class="row" v-cloak>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Cotizacion: @{{item.id}} a cliente @{{ item.globals.client.name }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-9">
                        <input type="text" class="form-control" v-model="item.descrip" placeholder="Titulo de la cotización">
                    </div>
                    <div class="col-lg-3">
                        <button class="btn btn-brown btn-default" @click="showFormDet()" >Detalles +</button>
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
                                  <th>Precio</th>
                                  <th>Total</th>
                                  <th></th>
                              </tr>
                            </thead>
                            <tbody>
                               <tr v-for="det in item.details">
                                   <td>@{{ det.descrip }}</td>
                                   <td>@{{ det.cant }} </td>
                                   <td>@{{ parseFloat(det.price).toFixed(2) }} </td>
                                   <td>@{{ (parseFloat(det.price) * det.cant).toFixed(2) }} </td>
                                   <td>
                                       <button class="btn btn-danger btn-sm m-t-5" @click="deleteDet(det.id)"><i class="fa fa-eraser"></i></button>
                                   </td>
                               </tr>

                            </tbody>
                            <tfoot>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>TOTAL</td>
                                <td class="txtblack">@{{getTotal() }} </td>
                                <td>
                                </td>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                     <!--  <textarea class="form-control" v-model="item.specifications" placeholder="Especificaciones"></textarea> -->

                        <quill-editor v-model="item.specifications" :options="editorOption"></quill-editor>
                    </div>

                </div>
            </div>
            <div class="panel-footer footer_fix">
                <button v-if="pass()" class="btn btn-success waves-effect btn-sm" @click="saveDetails()">Guardar</button>
                <button class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
            </div>
        </div>
    </div>
</div>
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
    <div class="row" style="height: 90vh">
        <div v-for="entity in lists" :key="entity.id" class="col-lg-4">
            <div  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-8 col-xs-12">
                            No:<span class="txtblack">@{{ entity.id }}</span>
                        </div>
                        <div class="col-lg-4 col-xs-12 text-right">
                            CAG: <span class="txtblack">@{{entity.globals.id}}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            Fecha emisión: <span class="txtblack">@{{dateToEs(entity.moment)}}</span>
                        </div>

                    </div>
                    <div class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Cliente: <span class="txtblack">@{{entity.globals.client.name}}</span>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Tipo: <span class="txtblack">@{{getType(entity.type_quote_id)}}</span>
                        </div>
                    </div>
                    <hr>
                    <div v-if="entity.details.length > 0" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Moto cotizado: <span class="txtblack">@{{getTotalItem(entity.details)}}</span>
                        </div>
                    </div>
                    <div v-if="entity.type_send_id > 0" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Enviada vía: <span class="txtblack">@{{entity.type_send.name}} <span style="color:#f59586"> (@{{entity.sends}})</span> </span>
                        </div>
                    </div>

                   <div v-if="entity.globals.landscaper !== null" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Fecha de visita: <span class="txtblack">@{{dateToEs(entity.globals.landscaper.moment)}} a las @{{entity.globals.landscaper.timer}}</span>
                        </div>
                        <div class="col-lg-12 col-xs-12 m-t-5">
                            Paisajista: <span class="txtblack">@{{entity.globals.landscaper.user.name}} </span>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="btn-group">
                                <button type="button" class="btn btn-custom dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span> </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" @click="edit(entity)"><i class="fa fa-edit m-r-5"></i>Crear</a></li>
                                    <li v-if="entity.type_quote_id == 1"><a href="#" @click="showFiles(entity)"> <i class="fa fa-file m-r-5"></i>Archivos</a></li>
                                    <li><a href="#" @click="viewpdf(entity.id)"><i class="fa fa-file-pdf-o m-r-5"></i>Imprimir</a></li>
                                    <li><a href="#" @click="ShowSendInfo(entity.id)"><i class="fa fa-send m-r-5"></i>Enviar a cliente</a></li>
                                    <li><a href="#"><i class="fa fa-search"></i> Verificacion</a></li>
                                </ul>
                            </div>
                          <!--  <button class="btn btn-teal waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                            <button v-if="entity.type_quote_id == 1" class="btn btn-default waves-effect btn-sm" @click="showFiles(entity)">Archivos</button>
                            <button v-if="entity.details.length > 0" class="btn btn-info waves-effect btn-sm" @click="viewpdf(entity.id)"><i class="fa fa-file-pdf-o"></i></button>
                            <button v-if="entity.details.length > 0" class="btn btn-default waves-effect btn-sm" @click="ShowSendInfo(entity.id)"><i class="fa fa-send"></i></button>
                            <button v-if="entity.details.length > 0" class="btn btn-default waves-effect btn-sm" @click="ShowSendInfo(entity.id)"><i class="fa fa-send"></i></button> -->
                        </div>
                        <div class="col-lg-8 text-right" style="font-style: italic">
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

<div id="repro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Visor</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                          <div class="col-lg-12">
                              <div v-if="doc.ext == 'jpg' || doc.ext == 'jpeg'"><img :src="doc.url" alt="" width="100%" height="300px" /></div>
                              <div v-if="doc.ext == 'mp3' || doc.ext == '3gpp'" > <audio :src="doc.url" controls ></audio></div>
                              <div v-if="doc.ext == 'mp4'"> <video :src="doc.url" controls width="100%" height="300px"></video></div>
                          </div>
                      </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="note" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Nota</h3>
                    </div>
                    <div class="panel-body">
                       <textarea v-focus class="form-control" v-model="note"></textarea>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" data-dismiss="modal" class="btn btn-success  waves-effect btn-sm" @click="saveNote()" >Guardar</a>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
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

<div id="pdf" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center modal-lg">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Visor</h3>
                    </div>
                    <div class="panel-body">
                        <iframe  id="iframe" :src="scrpdf" frameborder="0" width="100%" height="450px" allowfullscreen></iframe>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" data-dismiss="modal" class="btn btn-default  btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="sendinfo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Información a enviar </h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio9" value="1" v-model.number="item.type_send_id">
                                    <label for="radio9">
                                        Vía WhatsApp
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio10" value="2" v-model.number="item.type_send_id">
                                    <label for="radio10">
                                        Vía correo electrónico
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio11" value="3" v-model.number="item.type_send_id">
                                    <label for="radio11">
                                        Vía telefóno
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio12" value="4" v-model.number="item.type_send_id">
                                    <label for="radio12">
                                        Vía presencial
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passInfoSend()" :disabled="spin" class="btn btn-danger waves-effect btn-sm" @click="sendInfoClient()">Aplicar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
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
    <script src="{{asset('js/app/quotes.js')}}"></script>
@endsection
