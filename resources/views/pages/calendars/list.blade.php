@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('css/vue-cal.min.css')}}" rel="stylesheet">
    <style>
        .vuecal--month-view .vuecal__no-event {display: none;}
        .vuecal--short-events .vuecal__event-title {
            text-align: center !important;
        }
        .vuecal__event.lunch .vuecal__event-time {display: none;align-items: center;}
        .vuecal__event.domicilio {
            background: #002a80;
            cursor: pointer;
            color:white;
        }
        .vuecal__event.info {
            background: #5d561b;
            cursor: pointer;
            color:white;
        }
        .vuecal__event.mant {
            background: #26a172;
            cursor: pointer;
            color:white;
        }
        .vuecal__event.user {
            background: #7d2448;
            cursor: pointer;
            color:white;
        }
    </style>
@endsection
@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row m-t-20" v-cloak >
    <vue-cal
        :time="false"
        style="height: 95vh"
        locale="es"
        default-view="month"
        class="vuecal--green-theme"
        :events="datas"
        events-on-month-view="short"
        class="vuecal--full-height-delete"
        :show-all-day-events="['short', true, false][true]"
        @cell-click="clickDay($event)"
        :on-event-click="onEventClick"
        @view-change="logEvents($event)"
    ></vue-cal>
</div>

<div id="schedule" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <div class="panel panel-border panel-teal">
                <div class="panel-heading">
                    <h3 class="panel-title">AÑADIR UN EVENTO</h3>
                </div>
                <div class="panel-body">
                    <div class="m-b-5">
                        PROPIETARIO: <span style="color: black">{{ \Auth::user()->name }}</span>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Inicio</label>
                            <div class="input-group">
                                <date-picker v-model="item.start" :config="options"></date-picker>
                                <span class="input-group-addon"><i class="mdi mdi-clock"></i></span>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Final</label>
                            <div class="input-group">
                                <date-picker v-model="item.end" :config="options"></date-picker>
                                <span class="input-group-addon"><i class="mdi mdi-clock"></i></span>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="checkbox checkbox-primary">
                                <input  type="checkbox" v-model="item.allDay" @change="setdays()">
                                <label for="checkbox2">
                                    Todo el dia
                                </label>
                            </div>
                        </div>
                        @can('calendar.others')
                            <div class="col-lg-9">
                                <label>Para usuario</label>
                                <select class="form-control" v-model="item.for_user_id" >
                                    <option value="0"></option>
                                    <option v-for="us in users" :value="us.id">@{{ us.name }}</option>
                                </select>
                            </div>
                        @endcan
                        <div class="form-group col-lg-12">
                            <label>Titulo *</label>
                            <input class="form-control" v-model="item.title">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Descripcion</label>
                            <textarea  class="form-control" v-model="item.contentFull"> </textarea>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            @can('calendar.create')
                            <button :class="spin" @click="addEvent()" class="btn btn-success btn-sm">Aplicar</button>
                            @endcan
                            <a href="#" data-dismiss="modal" class="btn btn-default  btn-sm">Cerrar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="scheduleedit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="custom-width-modalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content p-0 b-0">
            <div class="panel panel-border panel-teal">
                <div class="panel-heading">
                    <h3 class="panel-title">ACTUALIZAR UN EVENTO</h3>
                </div>
                <div class="panel-body">
                    <div class="m-b-5">
                        PROPIETARIO: <span style="color: black">@{{ item.user.name }}</span>
                    </div>
                    <div class="row">
                        <div class="form-group col-lg-6">
                            <label>Inicio</label>
                            <div class="input-group">
                                <date-picker :disabled="item.cglobal_id > 0" v-model="item.start" :config="options"></date-picker>
                                <span class="input-group-addon"><i class="mdi mdi-clock"></i></span>
                            </div><!-- input-group -->
                        </div>
                        <div class="form-group col-lg-6">
                            <label>Final</label>
                            <div class="input-group">
                                <date-picker :disabled="item.cglobal_id > 0" v-model="item.end" :config="options"></date-picker>
                                <span class="input-group-addon"><i class="mdi mdi-clock"></i></span>
                            </div><!-- input-group -->
                        </div>
                        <div class="col-lg-3" v-if="item.cglobal_id === 0" >
                            <div class="checkbox checkbox-primary">
                                <input  type="checkbox" v-model="item.allDay">
                                <label for="checkbox2">
                                    Todo el dia
                                </label>
                            </div>
                        </div>
                        @can('calendar.others')
                            <div class="col-lg-9" v-if="item.cglobal_id === 0">
                                <label>Para usuario</label>
                                <select class="form-control" v-model="item.for_user_id" >
                                    <option value="0"></option>
                                    <option v-for="us in users" :value="us.id">@{{ us.name }}</option>
                                </select>
                            </div>
                        @endcan
                        <div class="form-group col-lg-12">
                            <label>Titulo *</label>
                            <input :disabled="item.cglobal_id > 0" class="form-control" v-model="item.title">
                        </div>
                        <div class="form-group col-lg-12">
                            <label>Descripcion</label>
                            <textarea :disabled="item.cglobal_id > 0" class="form-control" v-model="item.contentFull"> </textarea>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-lg-12 text-right">
                            @can('calendar.create')
                              <button class="btn btn-success btn-sm" @click="addEvent()">Aplicar</button>
                            @endcan
                             @can('calendar.delete')
                              <button v-if="item.cglobal_id === 0" class="btn btn-danger btn-sm"  @click="deleteEvent()">ELIMINAR</button>
                            @endcan
                            <a href="#" data-dismiss="modal" class="btn btn-default  btn-sm">Cerrar</a>
                        </div>
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
    <script src="{{asset('js/app/calendars.js')}}"></script>
@endsection
