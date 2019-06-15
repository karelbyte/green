@extends('layouts.main')

@section('style')
    <link href="{{asset('css/vue-multiselect.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('content')
@parent
<div class="row">
    <div class="col-xs-12">
        <div class="page-title-box">
            <h4 class="page-title">Reportes de cotizaciones</h4>
            <ol class="breadcrumb p-0 m-0">
                <li>
                    <a href="#">Gc</a>
                </li>
                <li>
                    <a href="#">Reportes</a>
                </li>
            </ol>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div class="row m-b-10">
        <div class="col-lg-3">
            <label>Usuario</label>
            <select class="form-control" v-model.number="filter.user_id" >
                <option value="0"></option>
                <option v-for="us in users" :value="us.id">@{{ us.name }}</option>
            </select>
        </div>
    <div class="form-group col-lg-2">
        <label>Fecha Inicial</label>
        <div class="input-group">
            <date-picker v-model="filter.star" :config="options" @change="checkDate()"></date-picker>
            <span class="input-group-addon"><i class="mdi mdi-clock"></i></span>
        </div>
    </div>
    <div class="form-group col-lg-2">
        <label>Final</label>
        <div class="input-group">
            <date-picker v-model="filter.end" :config="options" @change="checkDate()"></date-picker>
            <span class="input-group-addon"><i class="mdi mdi-clock"></i></span>
        </div>
    </div>
    <div class="col-lg-1 m-t-10">
        <div class="checkbox checkbox-primary">
            <input  type="checkbox" v-model="filter.all">
            <label for="checkbox2">
                Todas
            </label>
        </div>
    </div>
    <div class="col-lg-1 m-t-20">
        <button v-if="filter.user_id !== 0" class="btn btn-info btn-sm" @click="showInfoQuote">Aplicar</button>
    </div>
</div>
<hr>
<div class="row" v-cloak>
    <div class="col-lg-2 col-md-4 col-sm-6 txtblack">
        <div class="card-box widget-box-two widget-two-info">
            <i class="mdi mdi-coin widget-two-icon"></i>
            <div class="wigdet-two-content">
                <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Contizaciones </p>
                <h2 class="text-white"><span>@{{QuotesCant}}</span></h2>
            </div>
        </div>
    </div>
    <div class="col-lg-2 col-md-4 col-sm-6 txtblack">
        <div class="card-box widget-box-two widget-two-success">
            <i class="mdi mdi-note-plus-outline widget-two-icon"></i>
            <div class="wigdet-two-content">
                <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Monto Cotizado</p>
                <h2 class="text-white"><span>@{{ QuotesAmount }}</span></h2>
            </div>
        </div>
    </div>
</div>
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/reports.js')}}"></script>
@endsection
