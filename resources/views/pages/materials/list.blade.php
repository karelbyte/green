@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de productos.</h4>
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
<div v-if="views.new" class="row" style="height: 85vh" v-cloak>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading">
                <h3 class="panel-title">@{{title}}</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-2  m-t-20">
                        <span class="txtblack">Codigo <span class="require">*</span></span>
                        <input v-focus class="form-control" type="text" v-model="item.code">
                    </div>
                    <div class="col-lg-8  m-t-20">
                        <span class="txtblack">Descripción <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.name">
                    </div>
                </div>
                <div class="row m-t-3">
                        <div class="col-lg-4 m-t-20">
                            <span class="txtblack">Unidad de medida <span class="require">*</span></span>
                            <multiselect style="z-index: 9"  v-model="value"
                                            :options="measures"
                                            label="name"
                                            track-by="id"
                                            placeholder=""
                            ></multiselect>
                        </div>
                </div>
                <div class="row m-t-5">
                    <div class="col-lg-3 m-t-20">
                        <span class="txtblack">Precio al publico<span class="require">*</span></span>
                        <input v-numeric-only class="form-control" type="text" v-model.number="item.price">
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
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading">
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix"><order labels="Codigo" :options="orders_list" field="materials.code"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix"><order labels="Descripción" :options="orders_list" field="materials.name"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix">Unidad de Medida</th>
                <th class="cel_fix">Precio al publico</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.code}}</td>
                <td class="cel_fix">@{{entity.name}}</td>
                <td class="cel_fix">@{{entity.measure.name}}</td>
                <td class="cel_fix">@{{entity.price}}</td>
                <td>
                 <button class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                 <button class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)"><i class="fa fa-eraser"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="panel-footer" style="padding: 2px 0 0 10px">
            <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
        </div>
    </div>
</div>
@component('com.eliminar')@endcomponent
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/materials.js')}}"></script>
@endsection

