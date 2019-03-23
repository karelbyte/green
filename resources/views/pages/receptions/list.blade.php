@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de recepciones.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Recepciones</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div v-if="views.new" v-cloak>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-border panel-inverse" style="margin-bottom: 0">
                <div class="panel-heading">
                    <h3 class="panel-title">@{{title}}</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-3">
                            <span class="txtblack">Tipo de recepción <span class="require">*</span></span>
                            <multiselect style="z-index:2"  v-model="type"
                                         :options="types"
                                         label="name"
                                         track-by="id"
                                         placeholder=""
                            ></multiselect> <!--:multiple="true" -->
                        </div>
                        <div class="col-lg-2">
                            <span class="txtblack">Codigo <span class="require">*</span></span>
                            <input v-focus class="form-control" type="text" v-model="item.code">
                        </div>
                        <div class="col-lg-2">
                            <span class="txtblack">Fecha <span class="require">*</span></span>
                            <input class="form-control" type="date" v-model="item.moment">
                        </div>

                        <div class="col-lg-12 m-t-20">
                            <span class="txtblack">Nota </span>
                            <input class="form-control" type="text" v-model.number="item.note">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" >
        <div v-if="type !==''" class="col-lg-12">
            <div class="panel panel-border panel-inverse">
                <div class="panel-heading"  style="border-top: 1px solid #ccc !important; border-radius: 0">
                    <h3 class="panel-title">LISTADO DE @{{ type.name }}</h3>
                    <button class="btn btn-brown waves-effect btn-sm m-t-10" @click="showAddLine()">Añadir</button>
                </div>
                <div class="panel-body">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="cel_fix">Codigo</th>
                            <th class="cel_fix">Descripcion</th>
                            <th class="cel_fix">Cantidad</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="det in details" :key="det.element.id">
                            <td class="cel_fix">@{{det.element.code}}</td>
                            <td class="cel_fix">@{{det.element.name}}</td>
                            <td class="cel_fix">@{{det.cant}}</td>
                            <td>
                                <button class="btn btn-danger  waves-effect btn-sm" @click="deleteItem(det.element.code)"><i class="fa fa-eraser"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="m-t-10">
        <button v-if="pass()" class="btn btn-success waves-effect btn-sm" @click="save()">Guardar</button>
        <button class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
    </div>

</div>
<div v-if="views.list" v-cloak>
    <div class="row m-b-10">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 m-b-5">
           <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nueva</button>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <!--  <find :filters="filters_list" filter="value" v-on:getfilter="getlist" holder="buscar material"></find> -->
            @component('com.find')@endcomponent
        </div>
    </div>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading">
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix"><order labels="TIPO" :options="orders_list" field="receptions.type"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix"><order labels="Fecha" :options="orders_list" field="receptions.moment"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix"><order labels="Codigo" :options="orders_list" field="receptions.code"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix">Recepcionador</th>
                <th class="cel_fix">ESTADO</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="entity in lists" :key="entity.id" :class="[entity.status_id === '1' ? 'noaplic' : 'aplic']">
                <td class="cel_fix">@{{entity.type.name}}</td>
                <td class="cel_fix">@{{dateEs(entity.moment)}}</td>
                <td class="cel_fix">@{{entity.code}}</td>
                <td class="cel_fix">@{{entity.user.name}}</td>
                <td class="cel_fix">@{{entity.status.name}}</td>
                <td>
                 <button v-if="parseInt(entity.status_id) === 1" class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                 <button v-if="parseInt(entity.status_id) === 1" class="btn btn-info  waves-effect btn-sm" @click="showaplic(entity)">Aplicar</button>
                 <button v-if="parseInt(entity.status_id) === 1" class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)"><i class="fa fa-eraser"></i></button>
                 <button v-if="parseInt(entity.status_id) === 2" class="btn btn-info  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-pdf-o"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="panel-footer" style="padding: 2px 0 0 10px">
            <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
        </div>
    </div>
</div>

<div id="newline" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
    <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">AÑADIR @{{ type.name }}</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group col-lg-12">
                                <label for="">Código</label>
                                <multiselect style="z-index:3"  v-model="ItemForAdd.element"
                                             :options="elements"
                                             label="code"
                                             track-by="id"
                                             placeholder=""
                                ></multiselect>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="">Descripción</label>
                                <multiselect style="z-index:2"  v-model="ItemForAdd.element"
                                             :options="elements"
                                             label="name"
                                             track-by="id"
                                             placeholder=""
                                ></multiselect>
                            </div>
                            <div class="form-group col-lg-12">
                                <label for="">Cantidad</label>
                                <input v-numeric-only v-model.number="ItemForAdd.cant" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button :disabled="spin" v-if="passItemForAdd()" class="btn btn-success btn-sm" @click="addItem()">Aplicar</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="aplicar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Aplicar cantidades</h3>
                    </div>
                    <div class="panel-body">
                        <p>Se aplicara la recepción al inventario. Desea proceder?</p>
                    </div>
                    <div class="panel-footer text-right">
                        <button :disabled="spin" @click="aplic()" class="btn btn-danger waves-effect btn-sm">SI</button>
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">No</a>
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
    <script src="{{asset('appjs/multiselect.min.js')}}"></script>
    <script src="{{asset('appjs/components/paginator.js')}}"></script>
    <script src="{{asset('appjs/components/order.js')}}"></script>
    <script src="{{asset('appjs/receptions.js')}}"></script>
@endsection
