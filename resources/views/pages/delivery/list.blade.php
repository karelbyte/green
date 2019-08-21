@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de pedidos .</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Pedidos</a>
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
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 hidden-xs">
            <div class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="cel_fix"><order labels="Cliente" :options="orders_list" field="clients.name"  v-on:getfilter="getlist"></order></th>
                        <th class="cel_fix">Servicio</th>
                        <th class="cel_fix">Fecha de entrega</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="mouse" v-for="entity in lists" :key="entity.id">
                        <td class="cel_fix">@{{entity.globals.client.name}}</td>
                        <td class="cel_fix">@{{entity.details[0].descrip}}</td>
                        <td class="cel_fix">@{{entity.deliverydate}}</td>
                        <td>
                            <button class="btn btn-teal waves-effect btn-sm" @click="viewpdf(entity.id)"><i class="fa fa-file-pdf-o"></i></button>
                        </td>
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
                                    Cliente: <span class="txtblack">@{{entity.globals.client.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Servicio: <span class="txtblack">@{{entity.details[0].descrip}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-teal waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-file-pdf-o"></i></button>
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
    <script src="{{asset('js/app/deliverys.js')}}"></script>
@endsection
