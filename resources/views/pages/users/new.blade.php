@extends('layouts.main')

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
                    <a href="#">Añadir</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row" v-cloak >
    <div class="col-lg-10">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Añadir usuario</h3>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-4 m-t-20">
                       <span class="txtblack">Nombre <span class="require">*</span></span>
                       <input v-focus class="form-control" type="text" v-model="item.name">
                    </div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Email <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.email" placeholder="El email sera tu usuario">
                    </div>
                    <div class="col-lg-12 m-t-5"></div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Password <span class="require">*</span></span>
                        <input class="form-control" type="password" v-model="item.password">

                    </div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Re Password <span class="require">*</span></span>
                        <input class="form-control" type="password" v-model="repassword">
                    </div>
                    <div class="col-lg-12 m-t-5"></div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Cargo <span class="require">*</span></span>
                        <select class="form-control" v-model="item.position_id">
                            <option v-for="position in positions" :value="position.id">@{{ position.name }}</option>
                        </select>
                    </div>
                   <div class="col-lg-4 m-t-20">
                       <span class="txtblack">Asignar rol de acceso al sistema. <span class="require">*</span></span>
                       <select v-model="value" class="form-control">
                           <option v-for="rol in roles" :value="rol">@{{ rol.name }}</option>
                       </select>
                   </div>
                    <div class="col-lg-12 m-t-20">
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
            </div>
        </div>
    </div>
</div>
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/users_new.js')}}"></script>
@endsection
