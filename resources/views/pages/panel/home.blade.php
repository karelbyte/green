@extends('layouts.main')

@section('content')
        <div class="row">
            <div class="col-xs-12">
                <div class="page-title-box">
                    <h4 class="page-title">Información</h4>
                    <ol class="breadcrumb p-0 m-0">
                        <li>
                            <a href="#">Gc</a>
                        </li>
                        <li>
                            <a href="#">Tablero</a>
                        </li>
                        <li class="active">
                            Graficas
                        </li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->
       <!-- <div class="col-lg-2 col-md-4 col-sm-6">
            <div class="card-box widget-box-one">
                <div class="wigdet-one-content">
                    <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Total Clientes</p>
                    <h2 class="text-dark"><span>@{{ client_care_month }}</span> </h2>
                    <p class="text-muted m-0"><b>Last:</b> 50</p>
                </div>
            </div>
        </div> -->

        <div class="row text-left">

            <div class="col-lg-2 col-md-4 col-sm-6 txtblack">
                <div class="card-box widget-box-two widget-two-primary">
                    <i class="mdi mdi-image-filter-tilt-shift widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Atendidos @{{ getMonth() }}</p>
                        <h2 class="text-white"><span>@{{ client_care_month }}</span></h2>
                        <p class="m-0"><b>Anterior:</b> @{{ client_care_month_last }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 txtblack">
                <div class="card-box widget-box-two widget-two-info">
                    <i class="mdi mdi-coin widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Contizaciones @{{ getMonth() }}</p>
                        <h2 class="text-white"><span>@{{ quote_month }}</span></h2>
                        <p class="m-0"><b>Anterior:</b> @{{ quote_month_last }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 txtblack">
                <div class="card-box widget-box-two widget-two-success">
                    <i class="mdi mdi-note-plus-outline widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Ventas @{{getMonth()}}</p>
                        <h2 class="text-white"><span>@{{ sale_month }}</span></h2>
                        <p class="m-0"><b>Anterior:</b> @{{ sale_month_last }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 txtblack">
                <div class="card-box widget-box-two widget-two-warning">
                    <i class="typcn typcn-weather-downpour widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Mantenimientos @{{getMonth()}}</p>
                        <h2 class="text-white"><span>@{{ maintenance_month }}</span></h2>
                        <p class="m-0"><b>Anterior:</b> @{{ maintenance_month_last }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-4 col-sm-6 txtblack">
                <div class="card-box widget-box-two widget-two-purple">
                    <i class="mdi mdi-chart-line widget-two-icon"></i>
                    <div class="wigdet-two-content">
                        <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Moto ventas @{{getMonth()}}</p>
                        <h2 class="text-success"><span>@{{  amout_sale_month }} $</span></h2>
                        <p class="m-0"><b>Anterior:</b> @{{  amout_sale_month_last }} $</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="row" >
            <div class="col-lg-6">
                <div class="card-box">
                    <highcharts :options="pie" ref="bar"></highcharts>
                </div>

            </div>
            <div class="col-lg-6">
                <div class="card-box">
                    <highcharts :options="options" ref="bar"></highcharts>
                </div>
            </div>
        </div>
        @component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/hchart.js')}}"></script>
    <script src="{{asset('js/app/vue-hchart.js')}}"></script>
    <script src="{{asset('js/app/grafics.js')}}"></script>
@endsection
