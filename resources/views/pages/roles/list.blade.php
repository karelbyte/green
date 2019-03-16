@extends('layouts.main')

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Roles del sistema.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Usuarios</a>
                </li>
                <li>
                    <a href="#">Roles</a>
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
                <p class="m-b-10 txtblack">Los roles garantizan a que modulo, información o acciones tiene acceso un usuario en el crm.</p>
                <div class="form-group ">
                    <label for="inputName" class="control-label txtblack">Descripción del rol</label>
                    <input v-focus type="text" class="form-control" v-model="item.name">
                </div>
                <div class="row">
                    <div class="col-lg-3" style="color:black; letter-spacing: 5px">
                        Modulos
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="checkbox checkbox-purple">
                            <input  type="checkbox" v-model="all" @change="checkall()">
                            <label for="checkbox2">
                                TODOS LOS MODULOS Y SUS PERMISOS
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="board" @change="chekset('board')">
                            <label for="checkbox2">
                                TABLERO
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="rols" @change="chekset('rols')">
                            <label for="checkbox2">
                                Roles
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('rols')"  type="checkbox" v-model="grants" value="rols.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('rols')" type="checkbox" v-model="grants" value="rols.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="user" @change="chekset('user')">
                            <label for="checkbox2">
                                Usuarios
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('user')"  type="checkbox" v-model="grants" value="user.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('user')"  type="checkbox" v-model="grants" value="user.delete">
                            <label for="checkbox2">
                                Eliminar
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
            <find :filters="filters_list" filter="name" v-on:getfilter="getlist" holder="buscar roles"></find>
        </div>
    </div>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading">
        </div>
        <table class="table table-hover">
            <thead>
            <tr>
                <th class="cel_fix">Roles</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.name}}</td>
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
    <script src="{{asset('appjs/components/paginator.js')}}"></script>
    <script src="{{asset('appjs/components/find.js')}}"></script>
    <script src="{{asset('appjs/roles.js')}}"></script>
@endsection
