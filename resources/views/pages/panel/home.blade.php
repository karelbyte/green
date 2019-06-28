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
        <div v-cloak>
            <div class="row text-left">
                <div class="col-lg-3 col-md-4 col-sm-6 txtblack">
                    <div class="card-box widget-box-two widget-two-primary">
                        <i class="mdi mdi-image-filter-tilt-shift widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Atendidos @{{ getMonth() }}</p>
                            <h2 class="text-white"><span>@{{ client_care_month }}</span></h2>
                            <p class="m-0"><b>Anterior:</b> @{{ client_care_month_last }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 txtblack">
                    <div class="card-box widget-box-two widget-two-info">
                        <i class="mdi mdi-coin widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Contizaciones @{{ getMonth() }}</p>
                            <h2 class="text-white"><span>@{{ quote_month }}</span></h2>
                            <p class="m-0"><b>Anterior:</b> @{{ quote_month_last }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 txtblack">
                    <div class="card-box widget-box-two widget-two-success">
                        <i class="mdi mdi-note-plus-outline widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Ventas @{{getMonth()}}</p>
                            <h2 class="text-white"><span>@{{ sale_month }}</span></h2>
                            <p class="m-0"><b>Anterior:</b> @{{ sale_month_last }}</p>
                        </div>
                    </div>
                </div>
             <!--   <div class="col-lg-3 col-md-4 col-sm-6 txtblack">
                    <div class="card-box widget-box-two widget-two-warning">
                        <i class="typcn typcn-weather-downpour widget-two-icon"></i>
                        <div class="wigdet-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">Mantenimientos @{{getMonth()}}</p>
                            <h2 class="text-white"><span>@{{ maintenance_month }}</span></h2>
                            <p class="m-0"><b>Anterior:</b> @{{ maintenance_month_last }}</p>
                        </div>
                    </div>
                </div> -->
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
                <div class="col-lg-3 col-md-4 col-sm-6 txtblack mouse">
                    <div class="card-box widget-box-two widget-two-success" @click="goCags(PAY_NOT_DELIVERI.data)">
                        <i class="mdi mdi-truck widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">PAGADO SIN ENTREGAR</p>
                            <h2 class="text-white"><span>@{{ PAY_NOT_DELIVERI.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 txtblack mouse">
                    <div class="card-box widget-box-two widget-two-success" @click="goCags(RECEIVED_NOT_DELIVERI.data)">
                        <i class="mdi mdi-truck widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">RECIBIDO SIN ENTREGAR</p>
                            <h2 class="text-white"><span>@{{ RECEIVED_NOT_DELIVERI.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 txtblack mouse">
                    <div class="card-box widget-box-two widget-two-warning" @click="goCags(RECEIVED_TRUE_DELIVERI.data)">
                        <i class="mdi mdi-truck widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">RECIBIDO ENTREGADA</p>
                            <h2 class="text-white"><span>@{{ RECEIVED_TRUE_DELIVERI.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-6 txtblack mouse">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(NOTPAY_TRUE_DELIVERI.data)">
                        <i class="mdi mdi-truck widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-600  text-overflow" title="Statistics">ENTREGADA SIN PAGO</p>
                            <h2 class="text-white"><span>@{{NOTPAY_TRUE_DELIVERI.cant }}</span></h2>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" >
                <div class="col-lg-6">
                    <div class="card-box">
                        <highcharts :options="pie" ref="pie"></highcharts>
                    </div>

                </div>
                <div class="col-lg-6">
                    <div class="card-box">
                        <highcharts :options="sale_for_month" ref="bar"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="home_visit_cant > 0">
                    <div class="card-box">
                        <highcharts :options="home_visit_month"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="VERIFICATION_RECEIPT_QUOTATION_CANT > 0">
                    <div class="card-box">
                        <highcharts :options="VERIFICATION_RECEIPT_QUOTATION"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="STRATEGY_SALE_CANT > 0">
                    <div class="card-box">
                        <highcharts :options="STRATEGY_SALE"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="STRATEGY_SALE_CONFIRM_CANT > 0">
                    <div class="card-box">
                        <highcharts :options="STRATEGY_SALE_CONFIRM"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="INQUOTE_CANT > 0">
                    <div class="card-box">
                        <highcharts :options="INQUOTE"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="CAG_ON_HOLD_CANT> 0">
                    <div class="card-box">
                        <highcharts :options="CAG_ON_HOLD"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="CAG_ON_RECOMEN_CANT> 0">
                    <div class="card-box">
                        <highcharts :options="CAG_ON_RECOMEN"></highcharts>
                    </div>
                </div>
                <div class="col-lg-6" v-if="CAG_ON_Q_CANT> 0">
                    <div class="card-box">
                        <highcharts :options="CAG_ON_Q"></highcharts>
                    </div>
                </div>
            </div>

            <div class="row text-center">
                <h2>CAG’S EXCEDIDOS DE TIEMPO</h2>
            </div>
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="VISIT_HOME.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(VISIT_HOME.data)">
                        <i class="fa fa-thumbs-o-down widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13  text-overflow" title="Statistics">VISITA A DOMICILIO</p>
                            <h2 class="text-white"><span>@{{VISIT_HOME.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="QUOTE_OUT.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(QUOTE_OUT.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13  text-overflow" title="Statistics">SIN COTIZACION</p>
                            <h2 class="text-white"><span>@{{QUOTE_OUT.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="QUOTE_OUT_CONFIRM.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(QUOTE_OUT_CONFIRM.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13 text-overflow" title="Statistics">CONFIR. COTIZACION</p>
                            <h2 class="text-white"><span>@{{ QUOTE_OUT_CONFIRM.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="QUOTE_OUT_TRACING.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(QUOTE_OUT_TRACING.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13 text-overflow" title="Statistics">SEGUIMIENTO. COTIZACION</p>
                            <h2 class="text-white"><span>@{{ QUOTE_OUT_TRACING.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="quote_out_strateg.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(quote_out_strateg.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13 text-overflow" title="Statistics">ESTRATEGIA DE VENTA</p>
                            <h2 class="text-white"><span>@{{ quote_out_strateg.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="quote_out_strateg_confirm.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags( quote_out_strateg_confirm.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13 text-overflow" title="Statistics">CONFIR. ESTRAT. VENTA</p>
                            <h2 class="text-white"><span>@{{ quote_out_strateg_confirm.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="sale_note_not_delivered.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(sale_note_not_delivered.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13 text-overflow" title="Statistics">PRODUCTO / SERVICIOS</p>
                            <h2 class="text-white"><span>@{{sale_note_not_delivered.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="qualities_send_info.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(qualities_send_info.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13 text-overflow" title="Statistics">ENVIO DE RECOMENDACIONES</p>
                            <h2 class="text-white"><span>@{{qualities_send_info.cant }}</span></h2>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6 txtblack mouse" v-if="qualities_send_info_confirm.cant > 0">
                    <div class="card-box widget-box-two widget-two-danger" @click="goCags(qualities_send_info_confirm.data)">
                        <i class="fa fa-thumbs-o-down  widget-two-icon"></i>
                        <div class="widget-two-content">
                            <p class="m-0 text-uppercase font-13 text-overflow" title="Statistics">CALIDAD/CONFIRMACION</p>
                            <h2 class="text-white"><span>@{{qualities_send_info_confirm.cant }}</span></h2>
                        </div>
                    </div>
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
