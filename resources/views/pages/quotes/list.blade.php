@extends('layouts.main')

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de cotizaciones.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Cotizaciones</a>
                </li>
                <li>
                    <a href="#">Listado</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div v-if="views.newfiles" class="row" v-cloak>
    <div class="col-lg-10">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">Cotizacion: @{{item.id}}</h3>
            </div>
            <div class="panel-body">
                <div class="row m-t-20">
                    <div class="col-lg-12">
                        <button class="btn btn-default btn-default" @click="showCamera()" >Imagen o video +</button>
                        <button class="btn btn-default btn-default">Nota + </button>
                        <input type="file" id="file" capture=camera style="display: none" @change="saveFile($event)">
                    </div>

                </div>
                <hr>
                <div v-for="doc in item.docs" class="row m-t-10">
                    <div class="col-lg-6"><a :href="doc.url" target="_blank"> @{{ doc.name }} </a> </div>
                    <div class="col-lg-6">
                        <button class="btn btn-default btn-sm" @click="showVisor(doc)"><i class="fa fa-eye"></i></button>
                        <button class="btn btn-danger btn-sm" @click="deleteFile(doc.id)"><i class="fa fa-eraser"></i></button>
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
           <!-- <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button> -->
          <!--  <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-pdf-o"></i> IMPRIMIR</button> -->
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
             @component('com.find')@endcomponent
        </div>
    </div>
    <div class="row">
        <div v-for="entity in lists" :key="entity.id" class="col-lg-4">
            <div  class="panel panel-border panel-inverse m-t-5">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6 col-xs-12">
                            No:<span class="txtblack">@{{ entity.id }}</span>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 col-xs-12">
                            Fecha emisión: <span class="txtblack">@{{dateEs(entity.moment)}}</span>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Cliente: <span class="txtblack">@{{entity.globals.client.name}}</span>
                        </div>
                    </div>
                    <div class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Tipo: <span class="txtblack">@{{getType(entity.type_quote_id)}}</span>
                        </div>
                    </div>
                    <hr>
                    <div class="row m-t-10">
                        <div class="col-lg-12 col-xs-12">
                            Fecha de visita: <span class="txtblack">@{{dateEs(entity.globals.landscaper.moment)}} a las @{{entity.globals.landscaper.timer}}</span>
                        </div>
                        <div class="col-lg-12 col-xs-12 m-t-5">
                            Paisajista: <span class="txtblack">@{{entity.globals.landscaper.user.name}} </span>
                        </div>
                    </div>

                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-lg-6">
                            <button class="btn btn-teal waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                            <!--<button class="btn btn-danger waves-effect btn-sm" @click="showdelete(trait(entity))"><i class="fa fa-eraser"></i></button> -->
                            <button class="btn btn-default waves-effect btn-sm" @click="showFiles(entity)">Archivos</button>
                            <button class="btn btn-info waves-effect btn-sm" @click="showdView(entity)"><i class="fa fa-file-pdf-o"></i></button>
                        </div>
                        <div class="col-lg-6 text-right" style="font-style: italic">
                            <span class="txtblack">@{{entity.status.name  }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <paginator :tpage="pager_list.totalpage" :pager="pager_list" v-on:getresult="getlist"></paginator>
    </div>
</div>

<div id="repro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="vertical-alignment-helper">
        <div class="modal-dialog vertical-align-center">
            <div class="modal-content p-0 b-0">
                <div class="panel panel-border panel-brown">
                    <div class="panel-heading">
                        <h3 class="panel-title">Visor</h3>
                    </div>
                    <div class="panel-body">
                      <div class="row">
                          <div class="col-lg-12">
                              <div v-if="doc.ext == 'jpg' || doc.ext == 'jpeg'"><img :src="doc.url" alt="" width="100%" /></div>
                              <div v-if="doc.ext == 'mp3' || doc.ext == '3gpp'" > <audio :src="doc.url" controls ></audio></div>
                              <div v-if="doc.ext == 'mp4'"> <video :src="doc.url" controls width="100%"></video></div>
                          </div>
                      </div>
                    </div>
                    <div class="panel-footer text-right">
                        <a href="#" data-dismiss="modal" class="btn btn-default  waves-effect btn-sm">Cerrar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@component('com.eliminar')@endcomponent
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('appjs/components/paginator.js')}}"></script>
    <script src="{{asset('appjs/components/order.js')}}"></script>
    <script src="{{asset('appjs/quotes.js')}}"></script>
@endsection
