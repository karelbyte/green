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
        <div class="col-lg-5 col-md-4 col-sm-2 col-xs-12 m-t-5">
            @can('inventoris.print')
            <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="viewpdf()"><i class="fa fa-file-pdf-o"></i> IMPRIMIR</button>
            @endcan
         <!--   <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-excel "></i> XLS</button> -->
        </div>
        <div class="col-lg-4 col-md-4 col-sm-5 col-xs-12 text-right">
            @component('com.find')@endcomponent
        </div>
    </div>
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
