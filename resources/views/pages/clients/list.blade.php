@extends('layouts.main')

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Listado de clientes.</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Clientes</a>
                </li>
                <li>
                    <a href="#">Listado</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div v-if="views.files" class="row" v-cloak>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">LISTADO DE CAGS DEL CLIENTE @{{ item.name }} </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="cel_fix">CAG</th>
                        <th class="cel_fix">Fecha</th>
                        <th class="cel_fix">Motivo</th>
                        <th class="cel_fix">Asesor</th>
                        <th class="cel_fix">Estado</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="mouse" v-for="ent in files.cags" :key="ent.id">
                        <td class="cel_fix">@{{ent.id}}</td>
                        <td class="cel_fix">@{{dateToEs(ent.moment)}}</td>
                        <td v-if="ent.type_motive === 1" class="cel_fix">@{{ent.motive_products.name}}</td>
                        <td  v-else class="cel_fix">@{{ent.motive_services.name}}</td>
                        <td class="cel_fix">@{{ent.user.name}}</td>
                        <td class="cel_fix">@{{ent.status.name}}</td>
                        <td>
                            <button class="btn btn-info waves-effect btn-sm" @click="showpdfCag(ent.id)"><i class="fa fa-file-pdf-o"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">LISTADO DE COTIZACIONES DEL CLIENTE @{{ item.name }} </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="cel_fix">COTIZACION</th>
                        <th class="cel_fix">Fecha</th>
                        <th class="cel_fix">Monto</th>
                        <th class="cel_fix">Asesor</th>
                        <th class="cel_fix">Estado</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="mouse" v-for="quo in files.quotes" :key="quo.id">
                        <td class="cel_fix">@{{quo.id}}</td>
                        <td class="cel_fix">@{{dateToEs(quo.moment)}}</td>
                        <td class="cel_fix">@{{  getTotalItem(quo) }}</td>
                        <td class="cel_fix">@{{quo.globals.user.name}}</td>
                        <td class="cel_fix">@{{quo.status.name}}</td>
                        <td>
                            <button class="btn btn-info waves-effect btn-sm" @click="viewpdfQuote(quo.id)"><i class="fa fa-file-pdf-o"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="panel panel-border panel-inverse">
            <div class="panel-heading" style="border-bottom: 2px solid rgba(123,137,139,0.16) !important;">
                <h3 class="panel-title">LISTADO DE NOTAS DE VENTA DEL CLIENTE @{{ item.name }} </h3>
            </div>
            <div class="panel-body">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="cel_fix">NOTA</th>
                        <th class="cel_fix">Fecha</th>
                        <th class="cel_fix">Monto</th>
                        <th class="cel_fix">Asesor</th>
                        <th class="cel_fix">Estado</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="mouse" v-for="sl in files.sales" :key="sl.id">
                        <td class="cel_fix">@{{sl.id}}</td>
                        <td class="cel_fix">@{{dateToEs(sl.moment)}}</td>
                        <td class="cel_fix">@{{getTotalItem(sl) }}</td>
                        <td class="cel_fix">@{{sl.globals.user.name}}</td>
                        <td class="cel_fix">@{{sl.status.name}}</td>
                        <td>
                            <button class="btn btn-info waves-effect btn-sm" @click="showpdfsale(sl.id)"><i class="fa fa-file-pdf-o"></i></button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-10">
        <button class="btn btn-default waves-effect btn-sm" @click="close()">Cerrar</button>
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
                    <div class="col-lg-5  m-t-20">
                        <span class="txtblack">Codigo <span class="require">*</span></span>
                        <input disabled  class="form-control" type="text" v-model="item.code">
                    </div>
                    <div class="col-lg-5  m-t-20">
                       <span class="txtblack">Nombre cliente <span class="require">*</span></span>
                       <input  v-focus class="form-control" type="text" v-model="item.name">
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
                    <div class="col-lg-12 m-t-20">
                        <h4 class="txtblack">DIRECCION </h4>
                    </div>
                    <div class="col-lg-8 m-t-20">
                        <span class="txtblack">Calle <span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.street">
                    </div>
                    <div class="col-lg-2 m-t-20">
                        <span class="txtblack">No<span class="require">*</span></span>
                        <input v-numeric-only class="form-control" type="text" v-model="item.home_number">
                    </div>
                    <div class="col-lg-4 m-t-20">
                        <span class="txtblack">Colonia<span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.colony">
                    </div>
                    <div class="col-lg-6 m-t-20">
                        <span class="txtblack">Referencia<span class="require">*</span></span>
                        <input class="form-control" type="text" v-model="item.referen">
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
           @can('clients.create')
           <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button>
           @endcan
           <button v-if="lists.length > 0" class="btn btn-primary  waves-effect btn-sm" @click="view(entity)"><i class="fa fa-file-pdf-o"></i> IMPRIMIR</button>
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
                        <th class="cel_fix"><order labels="Codigo" :options="orders_list" field="clients.code"  v-on:getfilter="getlist"></order></th>
                        <th class="cel_fix"><order labels="Descripción" :options="orders_list" field="clients.name"  v-on:getfilter="getlist"></order></th>
                        <th class="cel_fix">Contacto</th>
                        <th class="cel_fix">Email</th>
                        <th class="cel_fix">Registrado por</th>
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
                        <td class="cel_fix">@{{entity.user.name}}</td>
                        <td class="cel_fix">@{{entity.phone}}</td>
                        <td>
                            <button class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                            @can('clients.delete')
                                <button class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)"><i class="fa fa-eraser"></i></button>
                            @endcan
                            <button class="btn btn-info  waves-effect btn-sm" @click="filesGet(entity)">EXPEDIENTE</button>
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
                                    Codigo: <span class="txtblack">@{{entity.code}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Nombre: <span class="txtblack">@{{entity.name}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                    Dirección: <span class="txtblack">@{{entity.address}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                   Contacto: <span class="txtblack">@{{entity.contact}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                   Email: <span class="txtblack">@{{entity.email}}</span>
                                </div>
                            </div>
                            <div class="row m-t-10">
                                <div class="col-lg-12 col-xs-12">
                                   Telefono: <span class="txtblack">@{{entity.phone}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                            <button class="btn btn-teal  waves-effect btn-sm" @click="edit(entity)"><i class="fa fa-edit"></i></button>
                            @can('clients.delete')
                                <button class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)"><i class="fa fa-eraser"></i></button>
                            @endcan
                    <button class="btn btn-info  waves-effect btn-sm">EXPEDIENTE</button>
                </div>
            </div>
        </div>
    </div>

</div>
@component('com.visor_pdf') @endcomponent
@component('com.eliminar')@endcomponent
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/clients.js')}}"></script>
@endsection
