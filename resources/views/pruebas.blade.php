<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GreenCenter CRM">
    <meta name="author" content="desarrollos@elpuertodigital.com">
    <link rel="shortcut icon" href="{{asset('icon.ico')}}">
    <title>GreenCenter CRM</title>
    <link href="{{asset('/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/core.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/components.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/pages.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/elements.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/menu.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('/css/responsive.css')}}" rel="stylesheet" type="text/css" />


    <!-- Plugins css-->
    <link href="../plugins/bootstrap-select/css/bootstrap-select.min.css" rel="stylesheet" />

</head>

<body class="fixed-left">
<div id="wrapper">
    <div class="row m-t-50">
        <div class="col-sm-12">
            <div class="demo-box">
                <h4 class="m-t-0 header-title"><b>Bootstrap-select</b></h4>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="">
                        <p class="text-muted m-b-15 font-13">
                            Create your
                            <code>
                                &lt;select&gt;
                            </code>
                            with the
                            <code>
                                .selectpicker
                            </code>
                            class.
                        </p>
                        <select class="selectpicker" data-style="btn-custom">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            It also works with option groups:
                        </p>
                        <select class="selectpicker" data-style="btn-default">
                            <optgroup label="Picnic">
                                <option>Mustard</option>
                                <option>Ketchup</option>
                                <option>Relish</option>
                            </optgroup>
                            <optgroup label="Camping">
                                <option>Tent</option>
                                <option>Flashlight</option>
                                <option>Toilet Paper</option>
                            </optgroup>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            You can also show the tick icon on single <code>select</code> with the <code>show-tick</code> class:
                        </p>

                        <select class="selectpicker show-tick" data-style="btn-success">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            And with multiple selects:
                        </p>
                        <select class="selectpicker" multiple data-style="btn-default">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            You can limit the number of elements you are allowed to select via the
                            <code>
                                data-max-option
                            </code>
                            attribute. It also works for option groups.
                        </p>

                        <select class="selectpicker m-b-0" multiple data-max-options="2" data-style="btn-pink">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="demo-box">
                        <p class="text-muted m-b-15 font-13">
                            You can limit the number of elements you are allowed to select via the
                            <code>
                                data-max-option
                            </code>
                            attribute. It also works for option groups.
                        </p>

                        <select class="selectpicker" data-style="btn-default btn-rounded">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <br />
                        <br />
                        <select class="selectpicker" data-style="btn-primary btn-bordered">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <br />
                        <br />
                        <select class="selectpicker" data-style="btn-teal">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <br />
                        <br />
                        <select class="selectpicker" data-style="btn-warning">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <br />
                        <br />
                        <select class="selectpicker" data-style="btn-danger btn-bordered">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <br />
                        <br />
                        <select class="selectpicker" data-style="btn-purple">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            Add an icon to an option or optgroup with the <code>data-icon</code> attribute:
                        </p>
                        <select class="selectpicker m-b-0" data-style="btn-default">
                            <option data-icon="glyphicon-glass text-primary">Mustard</option>
                            <option data-icon="glyphicon-heart">Ketchup</option>
                            <option data-icon="glyphicon-film">Relish</option>
                            <option data-icon="glyphicon-home">Mayonnaise</option>
                            <option data-icon="glyphicon-print">Barbecue Sauce</option>
                        </select>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="demo-box">
                        <p class="text-muted m-b-15 font-13">
                            You can add a search input by passing <code>data-live-search="true"</code> attribute:
                        </p>

                        <select class="selectpicker" data-live-search="true"  data-style="btn-orange">
                            <option>Hot Dog, Fries and a Soda</option>
                            <option>Burger, Shake and a Smile</option>
                            <option>Sugar, Spice and all things nice</option>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            You can also use the <code>
                                title</code> attribute as an alternative to display when the option is
                            selected:
                        </p>

                        <select class="selectpicker" data-live-search="true" data-style="btn-default">
                            <option title="Combo 1">Hot Dog, Fries and a Soda</option>
                            <option title="Combo 2">Burger, Shake and a Smile</option>
                            <option title="Combo 3">Sugar, Spice and all things nice</option>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            Using the <code>data-selected-text-format</code> attribute on a <code>multiple select</code>
                            you can specify how the selection is displayed.
                        </p>

                        <select class="selectpicker" multiple data-selected-text-format="count" data-style="btn-default">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>

                        <br/>
                        <br/>
                        <select class="selectpicker" multiple data-selected-text-format="count > 3" data-style="btn-default">
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                            <option>Onions</option>
                        </select>

                        <p class="text-muted m-b-15 m-t-30 font-13">
                            Add the <code>disabled</code> attribute to the select to apply the <code>disabled</code> class.
                        </p>
                        <select class="selectpicker m-b-0" data-style="btn-teal" disabled>
                            <option>Mustard</option>
                            <option>Ketchup</option>
                            <option>Relish</option>
                        </select>


                    </div>
                </div>
            </div> <!-- end row -->

        </div> <!-- end col -->
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


<script src="../plugins/bootstrap-select/js/bootstrap-select.min.js"></script>



<!-- SISTEMA -->
<script src="{{asset('/appjs/axios.min.js')}}"></script>
<script src="{{asset('/appjs/vue.min.js')}}"></script>
<script src="{{asset('/plugins/toastr/toastr.min.js')}}"></script>
<script src="{{asset('/appjs/tools.js')}}"></script>
<script src="{{asset('/appjs/core.js')}}"></script>
<script>
    $(function () {
        $('select').selectpicker();
    });
    new Vue({
        el: '#wrapper'
    })
</script>

</body>
</html>
