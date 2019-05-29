<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GreenCenter CRM">
    <meta name="author" content="desarrollos@elpuertodigital.com">
    <link rel="shortcut icon" href="{{asset('icon.ico')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>GreenCenter CRM</title>
    <link rel="stylesheet" href="{{asset('/plugins/morris/morris.css')}}">
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/core.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/components.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/elements.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/menu.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/responsive.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/plugins/switchery/switchery.min.css')}}" rel="stylesheet" type="text/css">
    <script src="{{asset('/js/modernizr.min.js')}}"></script>
    @yield('style')
</head>

<body class="fixed-left">
<input type="text" id="user_id_auth" value="{{auth()->user()->id}}" hidden="">
<div id="wrapper">
    <div class="topbar" >
        <div class="topbar-left">
            <a href="{{route('inicio')}}" class="logo"><span>Green<span> Center</span></span><i class="fa fa-envira"></i></a>
        </div>
        <div class="navbar navbar-default" role="navigation">
            <div class="container">
                <ul class="nav navbar-nav navbar-left">
                    <li>
                        <button class="button-menu-mobile open-left waves-effect waves-light">
                            <i class="mdi mdi-menu"></i>
                        </button>
                    </li>
                </ul>

                <!-- Right(Notification) -->
                <ul class="nav navbar-nav navbar-right" id="notify" v-cloak>
                 <li v-if="quote_local_close > 0">
                        <a href="{{route('notifications')}}" class="right-menu-item">
                            <i class="mdi mdi-coin"></i>
                            <span class="badge up bg-danger">@{{ quote_local_close }}</span>
                        </a>
                 </li>
                    <li v-if="sale_note_not_close > 0">
                        <a href="{{route('notifications')}}" class="right-menu-item">
                            <i class="mdi mdi-note-plus-outline"></i>
                            <span class="badge up bg-danger">@{{ sale_note_not_close }}</span>
                        </a>
                    </li>
                 <li v-if="landscapers > 0" >
                        <a href="{{route('notifications')}}" class="right-menu-item">
                            <i class="fa fa-home"></i>
                            <span class="badge up bg-danger">@{{ landscapers }}</span>
                        </a>
                 </li>
                 <li v-if="quote_confirm > 0">
                        <a href="{{route('notifications')}}" class="right-menu-item">
                            <i class="ion-android-call "></i>
                            <span  class="badge up bg-danger">@{{ quote_confirm }}</span>
                        </a>
                 </li>
                 <li v-if="sale_note_not_delivered > 0">
                        <a href="{{route('notifications')}}" class="right-menu-item">
                            <i class="mdi mdi-truck-delivery"></i>
                            <span  class="badge up bg-danger">@{{ sale_note_not_delivered }}</span>
                        </a>
                  </li>

                    <li class="dropdown user-box">
                        <a href="" class="dropdown-toggle waves-effect waves-light user-link" data-toggle="dropdown" aria-expanded="true">
                            <img src="{{asset('images/users/profile.png')}}" alt="user-img" class="img-circle user-img">
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                            <li>
                                <h5> {{ Auth::user()->name }}</h5>
                            </li>
                            <li><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Perfil</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-settings m-r-5"></i> Ajustes</a></li>
                            <li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> Bloquear pantalla</a></li>
                            <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="ti-power-off m-r-5"></i> Salir
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div><!-- end container -->
        </div>
    </div>
    <div class="left side-menu">
        <div class="sidebar-inner slimscrollleft">
            <div id="sidebar-menu">
                <ul>
                    @can('board')
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span> TABLERO</span><span class="menu-arrow"></span> </a>
                        <ul class="list-unstyled">
                            @can('board.notification')
                              <li><a href="{{route('notifications')}}">Notificaciones</a></li>
                            @endcan
                            @can('board.graphic')
                              <li><a href="{{route('inicio')}}">Estadisticas</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endcan
                    @can('cag')
                    <li>
                        <a href="{{route('cags')}}" class="waves-effect"><i class="mdi mdi-image-filter-tilt-shift "></i><span>CAG</span></a>
                    </li>
                    @endcan
                    @can('calendar')
                    <li>
                        <a href="{{route('calendars')}}" class="waves-effect"><i class="mdi mdi-calendar"></i><span>Calendario </span></a>
                    </li>
                    @endcan
                    @can('quote')
                    <li>
                        <a href="{{route('quotes')}}" class="waves-effect"><i class="mdi mdi-coin"></i><span>Cotizaciones </span></a>
                    </li>
                    @endcan
                    @can('salenote')
                    <li>
                        <a href="{{route('sales')}}" class="waves-effect"><i class="mdi mdi-note-plus-outline"></i><span>Notas de venta </span></a>
                    </li>
                    @endcan
                    @can('cag') <!-- CALIDAD DEL SERVICIO -->
                       <li>
                           <a href="{{route('quality')}}" class="waves-effect"><i class="mdi mdi-checkbox-multiple-marked-circle"></i><span>Calidad </span></a>
                      </li>
                    @endcan

                    @can('maintenance')
                    <li>
                        <a href="{{route('maintenance')}}" class="waves-effect"><i class="typcn typcn-weather-downpour "></i><span>Mantenimientos </span></a>
                    </li>
                    @endcan
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-paste "></i><span> Informes</span><span class="menu-arrow"></span> </a>
                         <ul class="list-unstyled">
                            <li><a href="{{route('info')}}">Cotizaciones</a></li>
                         </ul>
                    </li>
                    @can('clients')
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-card-details"></i> <span>Clientes</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            @can('client.create')
                            <li><a href="{{route('clients.new')}}">Nuevo cliente</a></li>
                            @endcan
                            <li><a href="{{route('clients')}}">Listados</a></li>
                        </ul>
                    </li>
                    @endcan
                    @can('providers')
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="typcn typcn-th-list-outline"></i> <span>Proveedores</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            @can('providers.create')
                            <li><a href="{{route('providers.new')}}">Nuevo proveedor</a></li>
                            @endcan
                            <li><a href="{{route('providers')}}">Listado</a></li>
                        </ul>
                    </li>
                    @endcan
                    @if(auth()->user()->can('products') || auth()->user()->can('services') )
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-briefcase"></i><span>Catalogos</span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    @can('products')
                                    <li><a href="{{route('productsoffereds')}}">Productos</a></li>
                                    @endcan
                                    @can('services')
                                    <li><a href="{{route('servicesoffereds')}}">Servicios</a></li>
                                    @endcan
                                </ul>
                            </li>
                    @endif
                    @if(auth()->user()->can('measures') || auth()->user()->can('elements')
                     || auth()->user()->can('tools') || auth()->user()->can('elements')
                     || auth()->user()->can('receptions') || auth()->user()->can('inventoris'))
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class=" mdi mdi-store"></i><span>Almacen</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            @can('measures')
                               <li><a href="{{route('measures')}}">Unidades de Medida</a></li>
                            @endcan
                            @can('elements')
                               <li><a href="{{route('products')}}">Productos</a></li>
                            @endcan
                            @can('tools')
                               <li><a href="{{route('tools')}}">Herramientas</a></li>
                            @endcan
                            @can('receptions')
                               <li><a href="{{route('receptions')}}">Recepciones</a></li>
                            @endcan
                            @can('inventoris')
                               <li><a href="{{route('inventoris')}}">Inventarios</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endif
                    @if(auth()->user()->can('user') || auth()->user()->can('rols') )
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple"></i><span>Usuarios</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            @can('rols')
                             <li><a href="{{route('roles')}}">Roles</a></li>
                            @endcan
                            @can('user.create')
                            <li><a href="{{route('users.new')}}">Nuevo usuario</a></li>
                            @endcan
                            @can('user')
                            <li><a href="{{route('users')}}">Listado</a></li>
                            @endcan
                        </ul>
                    </li>
                    @endif
                    @if (auth()->user()->position_id == 1 )
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="fa fa-cog"></i><span>Ajustes</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('company')}}">Generales de la empresa</a></li>
                        </ul>
                    </li>
                    @endif

                </ul>
            </div>

            <div class="clearfix"></div>

            <div class="help-box">
                <h5 class="text-muted m-t-0">Ayuda ?</h5>
                <p class=""><span class="text-dark"><b>Email:</b></span> <br/>desarrollos@elpuertodigital.com</p>
                <p class="m-b-0"><span class="text-dark"><b>Call:</b></span> <br/> (+52) 755 127 2444</p>
            </div>
        </div>

    </div>

    <!-- ============================================================== -->
    <!-- VISOR DE PAGINAS -->
    <!-- ============================================================== -->
    <div class="content-page" style="padding-bottom: 150px">
        <div class="content">
            <div class="container" id="app">
                @yield('content')
            </div>
        </div>
    </div>
</div>

<script>
    var resizefunc = [];
</script>

<!-- PLANTILLA -->
<script src="{{asset('/js/jquery.min.js')}}"></script>
<script src="{{asset('/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/js/detect.js')}}"></script>
<script src="{{asset('/js/fastclick.js')}}"></script>
<script src="{{asset('/js/jquery.blockUI.js')}}"></script>
<script src="{{asset('/js/waves.js')}}"></script>
<script src="{{asset('/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('/js/jquery.scrollTo.min.js')}}"></script>
<script src="{{asset('/plugins/switchery/switchery.min.js')}}"></script>
<script src="{{asset('/plugins/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('/plugins/counterup/jquery.counterup.min.js')}}"></script>
<!--<script src="{{asset('/plugins/morris/morris.min.js')}}"></script> -->
<script src="{{asset('/plugins/raphael/raphael-min.js')}}"></script>
<!--<script src="{{asset('/pages/jquery.dashboard.js')}}"></script> -->
<script src="{{asset('/js/jquery.core.js')}}"></script>
<script src="{{asset('/js/jquery.app.js')}}"></script>

<!-- SISTEMA -->

<script src="{{asset('/js/app/manifest.js')}}"></script>
<script src="{{asset('/js/app/vendor.js')}}"></script>
<script src="{{asset('/js/app/app.js')}}"></script>

@yield('script')
</body>
</html>
