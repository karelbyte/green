@extends('layouts.main')

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de proveedores.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Proveedores</a>
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
                <div class="row ">
                    <div class="col-lg-5 m-t-20">
                        <span class="txtblack">Codigo <span class="require">*</span></span>
                        <input v-focus class="form-control" type="text" v-model="item.code">
                    </div>
                    <div class="col-lg-5 m-t-20">
                       <span class="txtblack">Nombre Proveedor <span class="require">*</span></span>
                       <input  class="form-control" type="text" v-model="item.name">
                    </div>
                    <div class="col-lg-5 m-t-20">
                        <span class="txtblack">Contacto <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.contact">
                    </div>
                    <div class="col-lg-5 m-t-20">
                        <span class="txtblack">Email <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.email" >
                    </div>
                    <div class="col-lg-5 m-t-20">
                        <span  class="txtblack">Telefono local <span class="require">*</span></span>
                        <input v-numeric-only class="form-control" type="text" v-model="item.phone" >
                    </div>
                    <div class="col-lg-5 m-t-20">
                        <span  class="txtblack">Celular <span class="require">*</span></span>
                        <input v-numeric-only class="form-control" type="text" v-model="item.movil">
                    </div>
                    <div class="col-lg-8 m-t-20">
                        <span class="txtblack">Dirección <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.address">
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
           @can('providers.create')
           <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button>
           @endcan
           <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-pdf-o"></i> IMPRIMIR</button>
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
                <th class="cel_fix"><order labels="Codigo" :options="orders_list" field="providers.code"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix"><order labels="Descripción" :options="orders_list" field="providers.name"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix">Contacto</th>
                <th class="cel_fix">Email</th>
                <th class="cel_fix">Telefono</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.code}}</td>
                <td class="cel_fix">@{{entity.name}}</td>
                <td class="cel_fix">@{{entity.contact}}</td>
                <td class="cel_fix">@{{entity.email}}</td>
                <td class="cel_fix">@{{entity.phone}}</td>
                <td>
                 <button class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                 @can('providers.delete')
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
    <script src="{{asset('js/app/providers.js')}}"></script>
@endsection
