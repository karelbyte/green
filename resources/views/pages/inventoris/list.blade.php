@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">MAESTREO DE INVENTARIO.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Inventario</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div v-if="views.list" v-cloak>
    <div class="row m-b-10">
        <div class="col-lg-3 col-md-4 col-sm-5 col-xs-12 m-b-5">
            <multiselect style="z-index:999"  v-model="filters_list.type"
                         :options="types"
                         label="name"
                         track-by="id"
                         placeholder=""
            ></multiselect>

        </div>
        <div class="col-lg-5 col-md-4 col-sm-2 col-xs-12 m-t-5 m-b-5">
            @can('inventoris.print')
            <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="viewpdf()"><i class="fa fa-file-pdf-o"></i> IMPRIMIR</button>
            @endcan
         <!--   <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-excel "></i> XLS</button> -->
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 text-right">
            @component('com.find')@endcomponent
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="cel_fix"><order labels="Codigo" :options="orders_list" field="elements.code"  v-on:getfilter="getlist"></order></th>
                        <th class="cel_fix"><order labels="Descripción" :options="orders_list" field="elements.name"  v-on:getfilter="getlist"></order></th>
                        <th v-if="filters_list.type.id === 1" class="cel_fix">Unidad de Medida</th>
                        <th v-if="filters_list.type.id === 1" class="cel_fix">Precio al publico</th>
                        <th class="cel_fix">Existencias</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="mouse" v-for="entity in lists" :key="entity.id">
                        <td class="cel_fix">@{{entity.code}}</td>
                        <td class="cel_fix">@{{entity.name}}</td>
                        <td v-if="filters_list.type.id === 1" class="cel_fix">@{{entity.um}}</td>
                        <td v-if="filters_list.type.id === 1" class="cel_fix">@{{entity.price}}</td>
                        <td class="cel_fix">@{{entity.cant}}</td>
                    </tr>
                    </tbody>
                </table>
                <div class="panel-footer" style="padding: 2px 0 0 10px">
                    <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
                </div>
            </div>
        </div>
        <div class="hidden-lg hidden-md hidden-sm col-xs-12">
            <div v-for="entity in lists" :key="entity.id"  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8 col-sm-12">
                            <div class="row">
                                <div class="col-lg-12 col-xs-12">
                                    Codigo: <span class="txtblack">@{{entity.code}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Descripción: <span class="txtblack">@{{entity.name}}</span>
                                </div>
                            </div>
                            <div v-if="filters_list.type.id === 1" class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Unidad de medida: <span class="txtblack">@{{entity.um}}</span>
                                </div>
                            </div>
                            <div v-if="filters_list.type.id === 1" class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Precio: <span class="txtblack">@{{entity.price}}</span>
                                </div>
                            </div>
                            <div  class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Existencias: <span class="txtblack">@{{entity.cant}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button v-if="entity.email !== 'admin@gc.com'" class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)">
                        <i class="fa fa-edit"></i>
                    </button>
                    @can('user.delete')
                        <button v-if="entity.email !== 'admin@gc.com'" class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)">
                            <i class="fa fa-eraser"></i>
                        </button>
                    @endcan

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
                        <iframe  id="iframe" :src="scrpdf" frameborder="0" width="100%" height="450px"></iframe>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" data-dismiss="modal" class="btn btn-default  btn-sm">Cerrar</a>
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
    <script src="{{asset('js/app/inventoris.js')}}"></script>
@endsection
