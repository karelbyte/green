@extends('layouts.main')

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Recomendaciones y calidad.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Recomend. y calidad</a>
                </li>
                <li>
                    <a href="#">Listado</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div v-if="views.list" v-cloak>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 m-b-5">

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
                <th class="cel_fix"><order labels="CAG" :options="orders_list" field="clients.code"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix"><order labels="Cliente" :options="orders_list" field="clients.name"  v-on:getfilter="getlist"></order></th>
                <th class="cel_fix">Momento</th>
                <th class="cel_fix">DOCUMENTO</th>
                <th class="cel_fix">Estado</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr class="mouse" v-for="entity in lists" :key="entity.id">
                <td class="cel_fix">@{{entity.global.id}}</td>
                <td class="cel_fix">@{{entity.global.client.name}}</td>
                <td class="cel_fix">@{{dateToEs(entity.moment)}}</td>
                <td class="cel_fix">@{{entity.url_doc}}</td>
                <td class="cel_fix">@{{entity.status.name}}</td>
                <td>
                 <button class="btn btn-teal waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                 <button class="btn btn-default waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-send-o"></i></button>
                </td>
            </tr>
            </tbody>
        </table>
        <div class="panel-footer" style="padding: 2px 0 0 10px">
            <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
        </div>
    </div>
</div>
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/qualities.js')}}"></script>
@endsection
