@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de mantenimientos a clientes.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Mantenimientos</a>
                </li>
                <li>
                    <a href="#">Listado</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div v-if="views.new" class="row" v-cloak>
    <div class="col-lg-10">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">@{{title}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-5  m-t-20">
                        <span class="txtblack">Cliente <span class="require">*</span></span>
                        <multiselect disabled style="z-index: 9"  v-model="item.client"
                                     :options="clients"
                                     label="name"
                                     track-by="id"
                                     placeholder=""
                        ></multiselect>
                    </div>
                    <div class="col-lg-5  m-t-20">
                        <span class="txtblack">Servicio <span class="require">*</span></span>
                        <multiselect disabled style="z-index: 9"  v-model="item.service"
                                     :options="services"
                                     label="name"
                                     track-by="id"
                                     placeholder=""
                        ></multiselect>
                    </div>
                    <div class="col-lg-5 m-t-20">
                        <span class="txtblack">Incio <span class="require">*</span></span>
                        <input disabled class="form-control" type="date" v-model="item.start">
                    </div>
                    <div class="col-lg-5 m-t-20">
                        <span class="txtblack">Frecuencia (dias)<span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.timer" >
                    </div>
                    <div class="col-lg-8 m-t-20">
                        <div class="checkbox checkbox-primary">
                            <input  type="checkbox" v-model="item.status_id">
                            <label for="checkbox2" class="txtblack">
                                Activo
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
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 m-b-5">
            @can('maintenance.create')
              <!--  <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button> -->
            @endcan
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            @component('com.find')@endcomponent
        </div>
    </div>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading">
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix"><order labels="Cliente" :options="orders_list" field="clients.name"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix">Servicio</th>
                <th class="cel_fix">Frecuencia (Dias)</th>
                <th class="cel_fix">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.client.name}}</td>
                <td class="cel_fix">@{{entity.service.name}}</td>
                <td class="cel_fix">@{{entity.timer}}</td>
                <td class="cel_fix">@{{entity.status.name}}</td>
                <td>
                    <button class="btn btn-teal waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                    <button class="btn btn-brown waves-effect btn-sm" @click="showdetails(entity)">Mantenimientos</button>
                    <button v-if="lists.length > 0" class="btn btn-info waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-pdf-o"></i></button>
                    @can('maintenance.delete')
                       <!-- <button class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)"><i class="fa fa-eraser"></i></button> -->
                    @endcan
                </td>
            </tr>
            </tbody>
        </table>
        <div class="panel-footer" style="padding: 2px 0 0 10px">
            <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
        </div>
    </div>
</div>

<div v-if="views.details" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading" style="padding-left: 10px">
            Mantenimientos de:  <span class="txtblack">@{{ item.client.name.toUpperCase() }}</span>
        </div>
        <hr>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix">Fecha</th>
                <th class="cel_fix">Hora</th>
                <th class="cel_fix">Precio</th>
                <th class="cel_fix">Nota de venta</th>
                <th >Documento</th>
                <th class="cel_fix">Aceptado</th>
                <th class="cel_fix">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="detail in details" :key="detail.id">
                <td class="cel_fix">@{{dateToEs(detail.moment)}}</td>
                <td class="cel_fix">@{{detail.visiting_time}}</td>
                <td class="cel_fix">@{{detail.price}}</td>
                <td class="cel_fix">@{{detail.sale_id}}</td>
                <td><a v-if="detail.status_id > 5 " :href="detail.url_commend" target="_blank">Recomendación</a></td>
                <td class="cel_fix">@{{detail.accepts.name}}</td>
                <td class="cel_fix">@{{detail.status.name}}</td>
                <td>
                    <button v-if="detail.status_id === 1" class="btn btn-primary  waves-effect btn-sm" @click="editDetail(detail)"><i class="fa fa-check-square"></i></button>
                    <button v-if="detail.status_id === 2" class="btn btn-primary  waves-effect btn-sm" @click="confirm(detail)">Ejecutar</button>
                    <button v-if="detail.status_id == 3" class="btn btn-success  waves-effect btn-sm" @click="retroInfo(detail)">Concluir</button>
                    <button v-if="detail.status_id == 4" class="btn btn-success  waves-effect btn-sm" @click="commend(detail)">Recomendaciones</button>
                    <button v-if="detail.status_id == 6" class="btn btn-brown  waves-effect btn-sm" @click="confirmCommend(detail)">Verificar</button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="panel-footer" style="padding: 2px 0 0 10px">
            <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
        </div>
        <div class="panel-footer" style="padding: 10px 10px 10px 10px">
            <button class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
        </div>
    </div>
</div>

<div id="editItem" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Detalles mantenimiento</h3>
                    </div>
                    <div class="panel-body">
                        <span class="txtblack">Fecha<span class="require">*</span></span>
                        <input type="date" class="form-control" v-model="detail.moment">
                        <br>
                        <span class="txtblack">Hora confirmada<span class="require">*</span></span>
                        <input type="time" class="form-control" v-model="detail.visiting_time">
                        <br>
                        <span class="txtblack">Precio<span class="require">*</span></span>
                        <input v-numeric-only type="text" class="form-control" v-model="detail.price">
                        <br>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passConfirm()" :disabled="spin"  class="btn btn-success waves-effect btn-sm" @click="saveDetail()">Confirmar</button>
                        <a href="#" class="btn btn-default  waves-effect btn-sm" @click="closeForm()">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="commend" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recomendaciones Asesor a cliente</h3>
                    </div>
                    <div class="panel-body">
                        <span class="txtblack m-t-20">Observaciones adicionales <span class="require">*</span></span>
                        <textarea type="text" class="form-control" v-model="detail.note_advisor"></textarea>
                        <br>
                        <span class="txtblack m-t-20">Adjuntar documento <span class="require">*</span></span>
                        <input id="file" type="file" accept=".doc,.docx,.pdf" @change="getfile($event)">
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passCommend()" :disabled="spin"  class="btn btn-brown -effect btn-sm" @click="sendCommend()">Enviar a cliente</button>
                        <a href="#" data-dismiss="modal"  class="btn btn-default  waves-effect btn-sm" >Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="confirmCommend" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"
     data-backdrop="static" data-keyboard="false">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-success">
                    <div class="panel-heading">
                        <h3 class="panel-title">Verificacion de recomendaciones</h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <div class="radio radio-primary checkbox-inline">
                                <input type="radio"  id="radio3" value="8" v-model.number="detail.accept">
                                <label for="radio3">
                                    Aceptado
                                </label>
                            </div>
                         </div>
                        <div class="col-lg-12">
                            <div class="radio radio-primary checkbox-inline">
                                <input type="radio" id="radio4" value="9" v-model.number="detail.accept">
                                <label for="radio4">
                                   No aceptado
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" class="btn btn-danger waves-effect btn-sm" @click="applyCommend()">Confirmar</a>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"
     data-backdrop="static" data-keyboard="false">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Atención</h3>
                    </div>
                    <div class="panel-body">
                        <p>Se cambiara el estado a en ejecución!</p>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" class="btn btn-danger waves-effect btn-sm" @click="aplic()">Confirmar</a>
                        <a  href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="retroInfo" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;"
     data-backdrop="static" data-keyboard="false">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Atención</h3>
                    </div>
                    <div class="panel-body">
                        <p>Dará por concluido el mantenimiento</p>
                        <br>
                        <span class="txtblack m-t-20">Observaciones Jardinero <span class="require">*</span></span>
                        <textarea type="text" class="form-control" v-model="detail.note_gardener"></textarea>
                        <br>
                        <span class="txtblack m-t-20">Observaciones Cliente <span class="require">*</span></span>
                        <textarea type="text" class="form-control" v-model="detail.note_client"></textarea>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" class="btn btn-danger waves-effect btn-sm" @click="saveInfo()">Confirmar</a>
                        <a  href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
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
    <script src="{{asset('js/app/maintenances.js')}}"></script>
@endsection
