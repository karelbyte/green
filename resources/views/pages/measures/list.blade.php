@extends('layouts.main')

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Unidades de Medida.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Medidas</a>
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
                <h3 class="panel-title">@{{title}}</h3>
            </div>
            <div class="panel-body">
                <div class="row m-t-20">
                    <div class="col-lg-4">
                        <span class="txtblack">Nombre <span class="require">*</span></span>
                        <input v-focus class="form-control" type="text" v-model="item.name">
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
           @can('measures.create')
             <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nueva</button>
           @endcan
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <find :filters="filters_list" filter="value" v-on:getfilter="getlist" holder="buscar unidad"></find>
        </div>
    </div>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading">
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix">Nombre</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.name}}</td>
                <td>
                 <button class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                 @can('measures.delete')
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
@component('com.eliminar')@endcomponent
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/measures.js')}}"></script>
@endsection
