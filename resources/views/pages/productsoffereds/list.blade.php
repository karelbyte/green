@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de Productos .</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Productos</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<div v-if="views.needs" class="row" v-cloak>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">Necesidades del producto</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6  m-t-20">
                        <span class="txtblack">Productos o Herramienta<span class="require">*</span></span>
                        <multiselect style="z-index: 9"  v-model="need.element"
                                     :options="elements"
                                     label="name"
                                     track-by="id"
                                     placeholder=""
                        ></multiselect>
                    </div>
                    <div class="col-lg-3  m-t-20">
                        <span class="txtblack">Cantidad<span class="require">*</span></span>
                        <input v-focus class="form-control" type="text" v-model.number="need.cant">
                    </div>
                    <div v-if="need.element !== '' && need.cant > 0">
                            <div class="col-lg-3 m-t-40">
                                <button class="btn btn-default" @click="showAddNeed()">Añadir +</button>
                            </div>
                    </div>
                </div>

                <div v-if="item.details.length > 0" class="row m-t-20">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="cel_fix">Descripción</th>
                            <th class="cel_fix">Cantidad</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="need in needs" :key="need.id">
                            <td class="cel_fix">@{{need.element.name}}</td>
                            <td class="cel_fix">@{{need.cant}}</td>
                            <td>
                                <button class="btn btn-danger waves-effect btn-sm" @click="delNeed(need.id)"><i class="fa fa-eraser"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer footer_fix">
                <button  class="btn btn-success waves-effect btn-sm" @click="closeNeed()">Actualizar</button>
                <button class="btn btn-default waves-effect btn-sm" @click="closeNeed()">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<div v-if="views.new" class="row" v-cloak>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">@{{title}}</h3>
            </div>
            <div class="panel-body">
                <div class="row m-t-20">
                    <div class="col-lg-6">
                        <span class="txtblack">Descripción generica<span class="require">*</span></span>
                        <input v-focus class="form-control" type="text" v-model="item.name">
                    </div>
                </div>
                <div v-if="item.name !==''">
                    <div class="row m-t-20">
                        <div class="col-lg-6">
                            <button class="btn btn-default" @click="showAddDet()">Añadir +</button>
                        </div>
                    </div>
                    <hr>
                </div>

                <div v-if="item.details.length > 0" class="row m-t-20">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="cel_fix">Descripción</th>
                            <th class="cel_fix">Unidad Medida</th>
                            <th class="cel_fix">Termino</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="mouse" v-for="det in item.details" :key="det.id">
                            <td class="cel_fix">@{{det.name}}</td>
                            <td class="cel_fix">@{{det.measure.name}}</td>
                            <td class="cel_fix">@{{det.init}} a @{{ det.end }} dias</td>
                            <td>
                                <button class="btn btn-teal waves-effect btn-sm" @click="detEdit(det)"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-info waves-effect btn-sm" @click="needsShow(det.needs)">Detalles</button>
                                <button class="btn btn-danger waves-effect btn-sm" @click="delDetail(det.id)"><i class="fa fa-eraser"></i></button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
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
            @can('products.create')
              <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button>
            @endcan
           <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-pdf-o"></i> IMPRIMIR</button>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
          <find :filters="filters_list" filter="value" v-on:getfilter="getlist" holder="buscar producto"></find>
           <!-- @component('com.find')@endcomponent -->
        </div>
    </div>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading">
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix"><order labels="Descripción" :options="orders_list" field="products.name"  v-on:getfilter="getlist"></order></th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.name}}</td>
                <td>
                 <button class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                    @can('products.delete')
                      <button class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)"><i class="fa fa-eraser"></i></button>
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

<!-- RECOGIDA DE PRODUCTOS O SERVICIOS MOSTRADOS -->
<div id="add_det" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Productos</h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-9  m-t-20">
                                <span class="txtblack">Descripción <span class="require">*</span></span>
                                <input v-focus class="form-control" type="text" v-model="det.name">
                            </div>
                                <div class="col-lg-4 m-t-20">
                                    <span class="txtblack">Unidad de medida <span class="require">*</span></span>
                                    <multiselect style="z-index: 9"  v-model="det.measure"
                                                 :options="measures"
                                                 label="name"
                                                 track-by="id"
                                                 placeholder=""
                                    ></multiselect>
                                </div>

                            <div class="col-lg-12 m-t-20">
                               Cantidad de dias para la operación
                            </div>
                            <div class="col-lg-4">
                                    <span class="txtblack">Desde <span class="require">*</span></span>
                                    <input v-numeric-only class="form-control" type="text" v-model.number="det.init">
                             </div>
                            <div class="col-lg-4">
                                    <span class="txtblack">Hasta <span class="require">*</span></span>
                                    <input v-numeric-only class="form-control" type="text" v-model.number="det.end">
                             </div>

                        </div>
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passNew()" :disabled="spin" @click="addNew()" class="btn btn-danger waves-effect btn-sm">Añadir</button>
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
    <script src="{{asset('js/app/products_offereds.js')}}"></script>
@endsection
