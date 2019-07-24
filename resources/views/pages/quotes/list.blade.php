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
 <!-- AÑADIENDO FICHEROS DE COTIZACION A DOMICILIO -->
<div v-if="views.newfiles" class="row" v-cloak>
    <div class="col-lg-9">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Cotización a domicilio: @{{item.id}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12 m-t-20">
                        <span >CLIENTE:</span>
                        <span class="txtblack">@{{item.globals.client.name}}</span>
                    </div>
                    <div class="col-lg-12 m-t-20">
                        <span >DIRECCION:</span>
                        <span class="txtblack">@{{item.globals.client.street + ' ' + item.globals.client.home_number + ' '+item.globals.client.colony}}</span>
                        <p class="txtblack">@{{item.globals.client.referen}}</p>
                    </div>
                    <div class="col-lg-2  m-t-20">
                        <span class="txtblack">Fecha<span class="require">*</span></span>
                        <input type="date" class="form-control" v-model="item.globals.landscaper.moment">
                    </div>
                    <div class="col-lg-2  m-t-20">
                        <span class="txtblack">Hora<span class="require">*</span></span>
                        <input type="time" class="form-control" v-model="item.globals.landscaper.timer">
                    </div>
                    <div class="col-lg-10  m-t-20">
                        <span class="txtblack">Paisajista<span class="require">*</span></span>
                        <select class="form-control" v-model="item.globals.landscaper.user_uid">
                            <option v-for="scapers in landscapers" :value="scapers.uid">@{{ scapers.name }}</option>
                        </select>
                    </div>
                    <div class="col-lg-12  m-t-20">
                        <span class="txtblack">Nota<span class="require">*</span></span>
                        <textarea type="text" class="form-control" v-model="item.globals.landscaper.note"></textarea>
                    </div>
                </div>
                 <hr>
                 <div v-for="doc in item.docs" class="row m-t-10">
                     <div class="col-lg-6">
                         <a :href="doc.url" target="_blank">
                             <div v-if="doc.ext == 'jpg' || doc.ext == 'jpeg' || doc.ext == 'png'">
                                 <img :src="doc.url" class="img_fix"/>
                             </div>
                             <span v-else >@{{ doc.name }}</span>
                         </a>
                     </div>
                     <div class="col-lg-6 ">
                        <button class="btn btn-default btn-sm m-t-10" @click="showVisor(doc)"><i class="fa fa-eye"></i></button>
                         @can('quote.delete')
                        <button class="btn btn-danger btn-sm m-t-10" @click="deleteFile(doc.id)"><i class="fa fa-eraser"></i></button>
                         @endcan    
                     </div>
                 </div>
                 <div v-for="not in item.notes" class="row m-t-10">
                     <div class="col-lg-8"><textarea disabled class="form-control">@{{ not.note }}</textarea> </div>
                     <div class="col-lg-2">
                         <button class="btn btn-danger btn-sm m-t-5" @click="deleteNote(not.id)"><i class="fa fa-eraser"></i></button>
                     </div>
                 </div>
                <hr>
                <div class="row m-t-20">
                    <div class="col-lg-12  m-t-20">
                        <button class="m-t-20" @click="showNote()">Nota + </button>
                    </div>
                    <div class="col-lg-6  m-t-20">
                        <span class="txtblack">Documento PDF<span class="require">*</span></span>
                        <input type="file" id="file_pdf"  accept="application/pdf"  @change="saveFile($event)">
                    </div>
                    <div class="col-lg-6  m-t-20">
                        <span class="txtblack">Imagen directa<span class="require">*</span></span>
                        <input type="file" id="camera_img"  accept="image/*" capture="camera" @change="saveFile($event)">
                    </div>
                    <div class="col-lg-6 m-t-20">
                        <span class="txtblack">Imagen adjunta<span class="require">*</span></span>
                        <input type="file" id="camera_img"  multiple accept="image/*" @change="saveFileMultiple($event)">
                    </div>
                    <div class="col-lg-6  m-t-20">
                        <span class="txtblack">Video directo<span class="require">*</span></span>
                        <input type="file" id="camera_video"  accept="video/*" capture="camcorder" @change="saveFile($event)">
                    </div>
                    <div class="col-lg-6  m-t-20">
                        <span class="txtblack">Video adjunto<span class="require">*</span></span>
                        <input type="file" id="camera_video"  accept="video/*"  @change="saveFile($event)">
                    </div>
                    <div class="col-lg-12  m-t-20">
                        <span class="txtblack">Audio +<span class="require">*</span></span>
                        <input type="file" id="microphone" accept="audio/*"  @change="saveFile($event)">
                    </div>
                </div>
                 <div class="row m-t-20">
                     <div class="col-lg-12">
                         <div class="checkbox checkbox-primary">
                             <input  type="checkbox" v-model.number="item.globals.landscaper.status_id">
                             <label for="checkbox2" class="txtblack">
                                 VISITA CONCLUIDA
                             </label>
                         </div>
                     </div>

                 </div>
             </div>
             <div class="panel-footer footer_fix">
                 <div class="row">
                     <div class="col-lg-6 col-xs-12">
                         <button v-if="passVisit()" class="btn btn-success waves-effect btn-sm" @click="saveInfoVisint()">Guardar</button>
                         <button class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
                     </div>
                     <div class="col-lg-6 col-xs-12 text-right">
                         <span>Los datos tomados en la visita guardan automántico!</span>
                     </div>
                 </div>


             </div>
         </div>
     </div>
 </div>

 <!-- AÑADIENDO FICHEROS DE COTIZACION A DISTANCIA -->
<div v-if="views.newdetails" class="row" v-cloak>
    <div class="col-lg-12" v-if="!inCreation">
        <div class="row">
            <div class="col-lg-6">
                CLIENTE: <h4> @{{ item.globals.client.name  }}</h4>
            </div>
            <div class="col-lg-6">
                TIPO:  <h4>@{{getType(item.type_quote_id)}}</h4>
            </div>
        </div>
       <div class="row">
            <button class="btn btn-brown btn-default" @click="createQuote()" >CREAR COTIZACION</button>
        </div>
        <div class="row" style="margin-top: 10px">
            <div class="panel panel-border panel-inverse">
                <table v-if="item.heads.length > 0" class="table table-hover">
                    <thead>
                    <tr>
                        <th>TITULO</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="head in item.heads">
                        <td>@{{ head.descrip }}</td>
                        <td>
                            <button  class="btn btn-teal btn-sm m-t-5" @click="showHeadEdit(head)">
                                <i class="fa fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm m-t-5" @click="deleteQuote(head.id)"><i class="fa fa-eraser"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row" style="margin-top: 10px">
            <button class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
        </div>

    </div>
    <div class="col-lg-12" v-if="inCreation">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Cotizacion: @{{item.id}} a cliente @{{ item.globals.client.name }}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-9">
                        <input type="text" class="form-control" v-model="head.descrip" placeholder="Titulo de la cotización">
                    </div>
                    <div class="col-lg-1">
                        <button class="btn btn-brown btn-default" @click="showFormDet()" >Detalles +</button>
                    </div>
                    <div class="col-lg-1 text-left">
                        <div class="checkbox checkbox-primary">
                            <input  type="checkbox" v-model="head.have_iva">
                            <label for="checkbox2" class="txtblack">
                                IVA
                            </label>
                        </div>
                    </div>
                </div>
                <hr>
                <div  class="row m-t-10">
                    <div class="col-lg-12">
                        <table class="table table-hover">
                            <thead>
                              <tr>
                                  <th>Descripcion</th>
                                  <th>Cantidad</th>
                                  <th>Unidad de Medida</th>
                                  <th>Precio</th>
                                  <th>Total</th>
                                  <th></th>
                              </tr>
                            </thead>
                            <tbody>
                               <tr v-for="det in head.details">
                                   <td>@{{ det.descrip }}</td>
                                   <td>@{{ det.cant }} </td>
                                   <td>@{{ det.measure.name }} </td>
                                   <td>@{{ parseFloat(det.price).toFixed(2) }} </td>
                                   <td>@{{ (parseFloat(det.price) * det.cant).toFixed(2) }} </td>
                                   <td>
                                       <button  class="btn btn-teal btn-sm m-t-5" @click="showFormDetEdit(det)">
                                           <i class="fa fa-edit"></i>
                                       </button>
                                       <button class="btn btn-danger btn-sm m-t-5" @click="deleteDet(det.id)"><i class="fa fa-eraser"></i></button>
                                   </td>
                               </tr>

                            </tbody>
                      <tr >
                                <td></td>
                                <td></td>
                                <td>DESCUENTO</td>
                                <td class="txtblack"><input v-numeric-only type="text" v-model.number="head.discount" class="form-control"> </td>
                                <td>
                                </td>
                            </tr>
                            <tfoot>
                            <tr v-if="head.have_iva === 1 || head.have_iva === true">
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
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                       <quill-editor v-model="head.specifications" :options="editorOption"></quill-editor>
                    </div>
                </div>
            </div>
            <div class="panel-footer footer_fix">
                <button v-if="pass()" class="btn btn-success waves-effect btn-sm" @click="saveDetails()">Guardar</button>
                <button class="btn btn-default waves-effect btn-sm" @click="closeCreation()">Cerrar</button>
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
    <div class="row">
        <div v-for="entity in lists" :key="entity.id" class="col-lg-4" style="height: 360px">
            <div  class="panel panel-border panel-inverse m-t-5" style="font-size: 12px">
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
                <div class="panel-body">
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
                    <div class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Tipo: <span class="txtblack">@{{getType(entity.type_quote_id)}}</span>
                        </div>
                    </div>
                    <hr>
                 <!--  <div v-if="entity.details.length > 0" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Monto cotizado: <span class="txtblack">@{{getTotalItem(entity)}}</span>
                        </div>
                    </div> -->
                    <div v-if="entity.type_send_id > 0 && entity.type_send !== null " class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Enviada vía: <span class="txtblack">@{{entity.type_send.name}} <span style="color:#f59586"> (@{{entity.sends}})</span> </span>
                        </div>
                    </div>
                    <div v-if="entity.type_quote_id === 1" class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            <span>DIRECCION:</span>
                            <span class="txtblack">@{{entity.globals.client.street + ' ' + entity.globals.client.home_number + ' '+entity.globals.client.colony}}</span>

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
                            <div class="btn-group" v-if="entity.status_id !== 4 && entity.status_id !== 5">
                                <button type="button" class="btn btn-custom dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false">Acciones <span class="caret"></span> </button>
                                <ul class="dropdown-menu">
                                    <li><a href="#" @click="edit(entity)" id="edit334"><i class="fa fa-edit m-r-5"></i>Cotizar</a></li>
                                    <li v-if="entity.type_quote_id == 1"><a href="#" @click="showFiles(entity)"> <i class="fa fa-home m-r-5"></i>Visita</a></li>
                                    <li v-if="entity.heads.length > 0"><a href="#" @click="viewpdf(entity.id)"><i class="fa fa-file-pdf-o m-r-5"></i>Imprimir</a></li>
                                    <li v-if="entity.heads.length > 0"><a href="#" @click="ShowSendInfo(entity)"><i class="fa fa-send m-r-5"></i>Enviar a cliente</a></li>
                                    <li v-if="entity.status_id === 3 || entity.status_id === 7 ||  entity.status_id === 9"><a href="#" @click="ShowCheckInfo(entity)"><i class="fa fa-search"></i> Verificacion</a></li>
                                </ul>
                            </div>
                            <a v-if="entity.status_id == 4 || entity.status_id == 5" href="#" @click="viewpdf(entity.id)"><i class="fa fa-file-pdf-o m-r-5"></i>Imprimir</a>
                        </div>
                        <div class="col-lg-8 text-right" style="font-style: italic">
                            <span :class="{'acept': entity.status_id == 4, 'noacept': entity.status_id == 5}">@{{entity.status.name  }}</span>
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
                              <div v-if="doc.ext == 'jpg' || doc.ext == 'jpeg' || doc.ext == 'png'"><img :src="doc.url" alt="" width="100%" height="300px" /></div>
                              <div v-if="doc.ext == 'mp3' || doc.ext == '3gpp' || doc.ext == 'm4a'"> <audio :src="doc.url" controls ></audio></div>
                              <div v-if="doc.ext == 'mp4' || doc.ext == 'MOV' || doc.ext == 'mov'"> <video :src="doc.url" controls width="100%" height="300px"></video></div>
                              <div v-if="doc.ext == 'pdf' || doc.ext == 'PDF'"> <iframe :src="doc.url"  width="100%" height="300px"></iframe></div>
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
                          <!--  <span v-if="detail.type_item === 1 &&  detail.item !== '' " style="color: #3d4852">Existencias: @{{ detail.item.cant}}</span> -->
                            <input v-numeric-only class="form-control" type="text" v-model.number="detail.cant">
                        </div>
                        <div class="col-lg-6 m-t-20">
                            <span class="txtblack">@{{labelprice}} <span class="require">*</span></span>
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

<!-- VERIFICACION DE INFORMACION AL CLIENTE -->
<div id="check" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Verificación de recepción</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-7">
                                Via de verificación
                                <select class="form-control" v-model="item.type_check_id">
                                    <option value="1">Vía WhatsApp</option>
                                    <option value="2">Vía correo electrónico</option>
                                    <option value="3">Vía telefóno</option>
                                    <option value="4">Visita a cliente</option>
                                </select>
                            </div>
                            <div class="col-lg-6 m-t-20">
                                <span class="txtblack">Codigo confirmación <span class="require">*</span></span>
                                <input v-numeric-only class="form-control" type="text" v-model.number="confircode">
                            </div>
                            <div class="col-lg-12  m-t-20">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio30" value="1" v-model.number="item.clientemit">
                                    <label for="radio30">
                                        Aceptada
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-12  m-t-20">
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio31" value="2" v-model.number="item.clientemit">
                                    <label for="radio31">
                                        No Aceptada
                                    </label>
                                </div>
                            </div>
                            <div v-if="item.clientemit === 1" class="col-lg-12  m-t-20">
                                <table v-if="item.heads.length > 0" class="table table-hover">
                                    <thead>
                                    <tr>
                                        <th>TITULO</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="head in item.heads">
                                        <td style="font-size: 12px; margin-top: 10px">@{{ head.descrip }}</td>
                                        <td>
                                            <div class="checkbox checkbox-primary">
                                                <input  type="checkbox" v-model="headCheck" :value="head.id" >
                                                <label for="checkbox2" class="txtblack">
                                                    Añadir
                                                </label>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-if="item.clientemit === 2">
                               <div class="col-lg-12 m-t-20">
                                <span class="txtblack">Retroalimentación</span>
                                <textarea  v-focus class="form-control" type="text" v-model="item.feedback"> </textarea>
                                <div class="radio radio-primary checkbox-inline">
                                    <input type="radio" id="radio41" value="2" v-model.number="item.emit">
                                    <label for="radio41">
                                        No continuara
                                    </label>
                                </div>
                                <div v-if="item.status_id !== 9" class="radio radio-primary checkbox-inline m-t-10">
                                    <input type="radio" id="radio42" value="1" v-model.number="item.emit">
                                    <label for="radio42">
                                        Modificar
                                    </label>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passCheckSend()" :disabled="spin" class="btn btn-danger waves-effect btn-sm" @click="sendCheckClient()">Aplicar</button>
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
                        <!-- <a v-if="this.item.type_compromise_id == " href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a> -->
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
                            <div v-if="item.status_id === 8" class="col-lg-12 m-t-20">
                                <span class="txtblack">Estrategia de venta</span>
                                <textarea  v-focus class="form-control" type="text" v-model="item.strategy"> </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passInfoSend()" :disabled="sendM" class="btn btn-danger waves-effect btn-sm" @click="sendInfoClient()">Aplicar
                            <div v-if="sendM" class="lds-dual-ring"></div>
                        </button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<vue-progress-bar></vue-progress-bar>
@component('com.eliminar')@endcomponent
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/quotes.js')}}"></script>
@endsection
