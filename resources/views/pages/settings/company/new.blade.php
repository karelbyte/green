@extends('layouts.main')
@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Generales de la empresa.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Empresa</a>
                </li>
                <li>
                    <a href="#">Generales</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row" v-cloak>
    <div class="col-lg-10">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Datos de la empresa</h3>
            </div>
            <div class="panel-body">
                <div class="row m-t-20">
                    <div class="col-lg-4">
                       <span class="txtblack">Nombre <span class="require">*</span></span>
                       <input v-focus class="form-control" type="text" v-model="item.name">
                    </div>
                    <div class="col-lg-5">
                        <span class="txtblack">Dirección <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.address">
                    </div>
                    <div class="col-lg-5 m-t-10">
                        <span class="txtblack">Email <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.email">
                    </div>
                    <div class="col-lg-4 m-t-10">
                        <span class="txtblack">RFC <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.rfc">
                    </div>
                    <div class="col-lg-4 m-t-10">
                        <span class="txtblack">www</span>
                        <input class="form-control" type="text" v-model="item.www">
                    </div>
                    <div class="col-lg-2 m-t-10">
                        <span class="txtblack">Telefono 1</span>
                        <input v-numeric-only class="form-control" type="text" v-model="item.phone1">
                    </div>

                    <div class="col-lg-2 m-t-10">
                        <span class="txtblack">WhastApp</span>
                        <input v-numeric-only class="form-control" type="text" v-model="item.phone2">
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
    <script src="{{asset('appjs/company.js')}}"></script>
@endsection
