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
                            Tablero
                        </li>
                    </ol>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <!-- end row -->

        <div class="row text-center">

            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Ventas</p>
                        <h2 class="text-danger"><span data-plugin="counterup">3457</span></h2>
                        <p class="text-muted m-0"><b>Last:</b> 30.4k</p>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Clientes</p>
                        <h2 class="text-dark"><span data-plugin="counterup">295</span> </h2>
                        <p class="text-muted m-0"><b>Last:</b> 50</p>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Atendidos Mes Actual</p>
                        <h2 class="text-success"><span data-plugin="counterup">10</span></h2>
                        <p class="text-muted m-0"><b>Last:</b> 40.33k</p>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Contizaciones</p>
                        <h2 class="text-warning"><span data-plugin="counterup">652</span> </h2>
                        <p class="text-muted m-0"><b>Last:</b> 956</p>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Gastos</p>
                        <h2 class="text-primary"><span data-plugin="counterup">3245</span> </h2>
                        <p class="text-muted m-0"><b>Last:</b> 20k</p>
                    </div>
                </div>
            </div><!-- end col -->

            <div class="col-lg-2 col-md-4 col-sm-6">
                <div class="card-box widget-box-one">
                    <div class="wigdet-one-content">
                        <p class="m-0 text-uppercase font-600 font-secondary text-overflow">Utilidades</p>
                        <h2 class="text-danger"><span data-plugin="counterup">78541</span> </h2>
                        <p class="text-muted m-0"><b>Last:</b> 50k</p>
                    </div>
                </div>
            </div><!-- end col -->

        </div>
        <!-- end row -->

@endsection
