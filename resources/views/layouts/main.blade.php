<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GreenCenter CRM">
    <meta name="author" content="desarrollos@elpuertodigital.com">
    <link rel="shortcut icon" href="{{asset('icon.ico')}}">
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
<div id="preloader">
    <div id="status">
        <div class="spinner">
            <div class="spinner-wrapper">
                <div class="rotator">
                    <div class="inner-spin"></div>
                    <div class="inner-spin"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="wrapper">
    <div class="topbar">
        <div class="topbar-left">
            <a href="index.html" class="logo"><span>Green<span> Center</span></span><i class="fa fa-envira"></i></a>
            <!-- Image logo -->
            <!--<a href="index.html" class="logo">-->
            <!--<span>-->
            <!--<img src="/images/logo.png" alt="" height="30">-->
            <!--</span>-->
            <!--<i>-->
            <!--<img src="/images/logo_sm.png" alt="" height="28">-->
            <!--</i>-->
            <!--</a>-->
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
                <ul class="nav navbar-nav navbar-right">
                  <!--<li>
                        <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                            <i class="mdi mdi-bell"></i>
                            <span class="badge up bg-primary">4</span>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                            <li>
                                <h5>Notificaciones</h5>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-info">
                                        <i class="mdi mdi-account"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">New Signup</span>
                                        <span class="time">5 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-danger">
                                        <i class="mdi mdi-comment"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">New Message received</span>
                                        <span class="time">1 day ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="icon bg-warning">
                                        <i class="mdi mdi-settings"></i>
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Settings</span>
                                        <span class="time">1 day ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="all-msgs text-center">
                                <p class="m-0"><a href="#">See all Notification</a></p>
                            </li>
                        </ul>
                    </li> -->

                   <!-- <li>
                        <a href="#" class="right-menu-item dropdown-toggle" data-toggle="dropdown">
                            <i class="mdi mdi-email"></i>
                            <span class="badge up bg-danger">8</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right dropdown-lg user-list notify-list">
                            <li>
                                <h5>Messages</h5>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="avatar">
                                        <img src="/images/users/avatar-2.jpg" alt="">
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Patricia Beach</span>
                                        <span class="desc">There are new settings available</span>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="avatar">
                                        <img src="/images/users/avatar-3.jpg" alt="">
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Connie Lucas</span>
                                        <span class="desc">There are new settings available</span>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="user-list-item">
                                    <div class="avatar">
                                        <img src="/images/users/avatar-4.jpg" alt="">
                                    </div>
                                    <div class="user-desc">
                                        <span class="name">Margaret Becker</span>
                                        <span class="desc">There are new settings available</span>
                                        <span class="time">2 hours ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="all-msgs text-center">
                                <p class="m-0"><a href="#">See all Messages</a></p>
                            </li>
                        </ul>
                    </li> -->

                    <li class="dropdown user-box">
                        <a href="" class="dropdown-toggle waves-effect waves-light user-link" data-toggle="dropdown" aria-expanded="true">
                            <img src="/images/users/avatar-1.jpg" alt="user-img" class="img-circle user-img">
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
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-view-dashboard"></i><span> TABLERO</span><span class="menu-arrow"></span> </a>
                        <ul class="list-unstyled">
                            <li><a href="index.html">Notificaciones</a></li>
                            <li><a href="index.html">Graficas</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="calendar.html" class="waves-effect"><i class="mdi mdi-calendar"></i><span>Calendario </span></a>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-card-details"></i> <span>Clientes</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="ui-buttons.html">Lista</a></li>
                            <li><a href="ui-typography.html">Nuevo</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-coin"></i> <span>Cotizaciones</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="ui-buttons.html">Lista</a></li>
                            <li><a href="ui-typography.html">Nueva</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class=" typcn typcn-shopping-bag "></i> <span>Notas de venta</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="ui-buttons.html">Lista</a></li>
                            <li><a href="ui-typography.html">Nueva</a></li>
                        </ul>
                    </li>

                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-briefcase"></i><span>Catalogos</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="email-inbox.html">Productos</a></li>
                            <li><a href="email-read.html">Servicios</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class=" mdi mdi-store"></i><span>Almacen</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('measures')}}">Unidades de Medida</a></li>
                            <li><a href="{{route('materials')}}">Materiales</a></li>
                            <li><a href="{{route('tools')}}">Herramientas</a></li>
                            <li><a href="{{route('receptions')}}">Recepciones</a></li>
                            <li><a href="email-read.html">Inventarios</a></li>
                        </ul>
                    </li>
                    <li class="has_sub">
                        <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-account-multiple"></i><span>Usuarios</span> <span class="menu-arrow"></span></a>
                        <ul class="list-unstyled">
                            <li><a href="{{route('roles')}}">Roles</a></li>
                            <li><a href="{{route('users.new')}}">Nuevo usuario</a></li>
                            <li><a href="{{route('users')}}">Listado</a></li>
                        </ul>
                    </li>

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
    <div class="content-page">
        <!-- Start content -->
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
<script src="{{asset('/appjs/axios.min.js')}}"></script>
<script src="{{asset('/appjs/vue.min.js')}}"></script>
<script src="{{asset('/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('/appjs/tools.js')}}"></script>
<script src="{{asset('/appjs/core.js')}}"></script>

@yield('script')
</body>
</html>
