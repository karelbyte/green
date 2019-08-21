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
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('board')"  type="checkbox" v-model="grants" value="board.notification">
                            <label for="checkbox2">
                               Notificaciones
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('board')" type="checkbox" v-model="grants" value="board.graphic">
                            <label for="checkbox2">
                                Graficas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Ciclo de Atención Global
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="cag" @change="chekset('cag')">
                            <label for="checkbox2">
                                CAG
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('cag')"  type="checkbox" v-model="grants" value="cag.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('cag')" type="checkbox" v-model="grants" value="cag.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                   Modulo Calendario
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="calendar" @change="chekset('calendar')">
                            <label for="checkbox2">
                                Calendario
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('calendar')"  type="checkbox" v-model="grants" value="calendar.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('calendar')" type="checkbox" v-model="grants" value="calendar.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('calendar')" type="checkbox" v-model="grants" value="calendar.others">
                            <label for="checkbox2">
                                Agendar a otros
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('calendar')" type="checkbox" v-model="grants" value="calendar.viewothers">
                            <label for="checkbox2">
                                Acceso a calendario de otros
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                   Modulo Cotizaciones
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="quote" @change="chekset('quote')">
                            <label for="checkbox2">
                                Cotizaciones
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('quote')"  type="checkbox" v-model="grants" value="quote.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('quote')" type="checkbox" v-model="grants" value="quote.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo Notas de venta
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="salenote" @change="chekset('salenote')">
                            <label for="checkbox2">
                                Nota de venta
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('salenote')"  type="checkbox" v-model="grants" value="salenote.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('salenote')" type="checkbox" v-model="grants" value="salenote.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo Pedidos
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="delivery" @change="chekset('delivery')">
                            <label for="checkbox2">
                                Lista de pedidos
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo Calidad
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="quality" @change="chekset('quality')">
                            <label for="checkbox2">
                                Calidad
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('quality')"  type="checkbox" v-model="grants" value="quality.confirm">
                            <label for="checkbox2">
                                Confirmar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('quality')" type="checkbox" v-model="grants" value="quality.senddoc">
                            <label for="checkbox2">
                                Enviar documentos
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo de mantenimiento
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="maintenance" @change="chekset('maintenance')">
                            <label for="checkbox2">
                                Mantenimientos
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('maintenance')"  type="checkbox" v-model="grants" value="maintenance.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('maintenance')" type="checkbox" v-model="grants" value="maintenance.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo de Informes
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="info" @change="chekset('info')">
                            <label for="checkbox2">
                                Informes generales
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo Clientes
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="clients" @change="chekset('clients')">
                            <label for="checkbox2">
                                Clientes
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('clients')"  type="checkbox" v-model="grants" value="clients.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('clients')" type="checkbox" v-model="grants" value="clients.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo Proveedores
                </div>
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="providers" @change="chekset('providers')">
                            <label for="checkbox2">
                                Proveedores
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('providers')"  type="checkbox" v-model="grants" value="providers.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('providers')" type="checkbox" v-model="grants" value="providers.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo Catalogos
                </div>
                <!-- PRODUCTOS DEL CALTALOGO-->
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="products" @change="chekset('products')">
                            <label for="checkbox2">
                                Productos
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('products')"  type="checkbox" v-model="grants" value="products.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('products')" type="checkbox" v-model="grants" value="products.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <!-- SERVICIOS DEL CATALOGO -->
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="services" @change="chekset('services')">
                            <label for="checkbox2">
                                Servicios
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('services')"  type="checkbox" v-model="grants" value="services.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('services')"  type="checkbox" v-model="grants" value="services.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <!-- ALMACEN-->
                <div class="row txtblack" style="padding-left: 10px">
                   Modulo Almacen
                </div>
                 <!-- Unidad de Medida -->
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="measures" @change="chekset('measures')">
                            <label for="checkbox2">
                                Unidades de Medida
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('measures')"  type="checkbox" v-model="grants" value="measures.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('measures')" type="checkbox" v-model="grants" value="measures.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <!-- PRODUCTOS -->
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="elements" @change="chekset('elements')">
                            <label for="checkbox2">
                                Productos
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('elements')"  type="checkbox" v-model="grants" value="elements.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('elements')" type="checkbox" v-model="grants" value="elements.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Herramientas -->
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="tools" @change="chekset('tools')">
                            <label for="checkbox2">
                                Herramientas
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('tools')"  type="checkbox" v-model="grants" value="tools.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('tools')" type="checkbox" v-model="grants" value="tools.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Recepciones-->
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="receptions" @change="chekset('receptions')">
                            <label for="checkbox2">
                                Recepciones
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('receptions')"  type="checkbox" v-model="grants" value="receptions.create">
                            <label for="checkbox2">
                                Crear/Modificar
                            </label>
                        </div>
                    </div>

                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('receptions')" type="checkbox" v-model="grants" value="receptions.delete">
                            <label for="checkbox2">
                                Eliminar
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input  :disabled="!grants.includes('receptions')" type="checkbox" v-model="grants" value="receptions.aplic">
                            <label for="checkbox2">
                                Aplicar
                            </label>
                        </div>
                    </div>
                </div>
                <!-- Inventario-->
                <div class="row roles">
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-success">
                            <input  type="checkbox" v-model="grants" value="inventoris" @change="chekset('inventoris')">
                            <label for="checkbox2">
                                Inventarios
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-2">
                        <div class="checkbox checkbox-primary">
                            <input :disabled="!grants.includes('inventoris')"  type="checkbox" v-model="grants" value="inventoris.print">
                            <label for="checkbox2">
                                Imprimir
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row txtblack" style="padding-left: 10px">
                    Modulo Usuarios
                </div>
                <!-- ROLES-->
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
                <!-- USUARIOS -->
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
           @can('rols.create')
            <button class="btn btn-custom btn-inverse  waves-effect btn-sm" @click="add()">Nuevo</button>
           @endcan
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <find :filters="filters_list" filter="value" v-on:getfilter="getlist" holder="buscar roles"></find>
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
                 @can('rols.delete')
                   <button v-if="entity.id !== 1" class="btn btn-danger  waves-effect btn-sm" @click="showdelete(entity)"><i class="fa fa-eraser"></i></button>
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
    <script src="{{asset('js/app/roles.js')}}"></script>
@endsection
