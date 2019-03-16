@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Usuarios del sistema.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Usuarios</a>
                </li>
                <li>
                    <a href="#">Lista</a>
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
                    <div class="col-lg-12 m-t-10">
                        <span class="txtblack">Asignar rol de acceso al sistema. <span class="require">*</span></span>
                    </div>
                    <div class="col-lg-5 m-t-10">
                        <multiselect    v-model="value"
                                        :options="roles"
                                        label="name"
                                        track-by="name"
                                        placeholder=""
                        ></multiselect> <!--:multiple="true" -->
                    </div>
                </div>
                <div class="row m-t-20">
                    <div class="col-lg-4">
                       <span class="txtblack">Nombre <span class="require">*</span></span>
                       <input class="form-control" type="text" v-model="item.name">
                    </div>
                    <div class="col-lg-5">
                        <span class="txtblack">Email <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.email" placeholder="El email sera tu usuario">
                    </div>
                    <div class="col-lg-4 m-t-10">
                        <span class="txtblack">Password <span class="require">*</span></span>
                        <input class="form-control" type="password" v-model="item.password">

                    </div>
                    <div class="col-lg-4 m-t-10">
                        <span class="txtblack">Re Password <span class="require">*</span></span>
                        <input class="form-control" type="password" v-model="repassword">
                    </div>
                    <div class="col-lg-12 m-t-10">
                        <div class="checkbox checkbox-primary">
                            <input  type="checkbox" v-model="item.active_id">
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
           <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <find :filters="filters_list" filter="name" v-on:getfilter="getlist" holder="buscar usuario"></find>
        </div>
    </div>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading">
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix">Usuarios</th>
                <th class="cel_fix">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.name}}</td>
                <td class="cel_fix">@{{entity.status.name}}</td>
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
    <script src="{{asset('appjs/multiselect.min.js')}}"></script>
    <script src="{{asset('appjs/components/paginator.js')}}"></script>
    <script src="{{asset('appjs/components/find.js')}}"></script>
    <script src="{{asset('appjs/users.js')}}"></script>
@endsection
