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
<input type="text" id="find" value="{{$find}}" hidden>
<div v-if="views.list" v-cloak>
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12 m-b-5">

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
                        <th class="cel_fix"><order labels="CAG" :options="orders_list" field="clients.code"  v-on:getfilter="getlist"></order></th>
                        <th class="cel_fix"><order labels="Cliente" :options="orders_list" field="clients.name"  v-on:getfilter="getlist"></order></th>
                        <th class="cel_fix">Fecha</th>
                        <th class="cel_fix">Recomendaciones</th>
                        <th class="cel_fix">Estado</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="mouse" v-for="entity in lists" :key="entity.id">
                        <td class="cel_fix">@{{entity.global.id}}</td>
                        <td class="cel_fix">@{{entity.global.client.name}}</td>
                        <td class="cel_fix">@{{dateToEs(entity.moment)}}</td>
                        <td><a v-if="entity.status_id > 1 " :href="entity.url_doc" target="_blank">Documento</a></td>
                        <td class="cel_fix">@{{entity.status.name}}</td>
                        <td>
                            <button class="btn btn-teal waves-effect btn-sm" @click="commend(entity)"><i class="fa fa-send-o"></i></button>
                            <button v-if="entity.status_id === 2" class="btn btn-default waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-send-o"></i></button>
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
                                    CAG: <span class="txtblack">@{{entity.global.id}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Cliente: <span class="txtblack">@{{entity.global.client.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Facha: <span class="txtblack">@{{dateToEs(entity.moment)}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10" v-if="entity.status_id > 1 ">
                                <div class="col-lg-12 col-xs-12">
                                    Recomendaciones: <span class="txtblack">
                                        <a  :href="entity.url_doc" target="_blank">Documento</a>
                                    </span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Estado: <span class="txtblack">@{{entity.status.name}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-teal waves-effect btn-sm" @click="commend(entity)"><i class="fa fa-send-o"></i></button>
                    <button v-if="entity.status_id === 2" class="btn btn-default waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-send-o"></i></button>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="commend" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Recomendaciones Asesor a cliente</h3>
                    </div>
                    <div class="panel-body">
                        <span class="txtblack m-t-20">Adjuntar documento <span class="require">*</span></span>
                        <input id="file" type="file" accept=".doc,.docx,.pdf" @change="getfile($event)">
                    </div>
                    <div class="panel-footer text-right">
                        <button v-if="passCommend()" :disabled="spin"  class="btn btn-brown -effect btn-sm" @click="sendCommend()">Enviar a cliente</button>
                        <a href="#" data-dismiss="modal"  class="btn btn-default  waves-effect btn-sm" >Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/qualities.js')}}"></script>
@endsection
