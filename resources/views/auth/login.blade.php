<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="GreenCenter Crm">
    <meta name="author" content="Coderthemes">
    <link rel="shortcut icon" href="icon.ico">
    <title>GreenCenter CRM</title>
    <title>GreenCenter Crm</title>
    <link rel="stylesheet" type="text/css" href="{{asset('loging/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('loging/fontawesome-all.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('loging/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('loging/theme.css')}}">
</head>
<body>
<div class="form-body" class="container-fluid">
    <div class="website-logo">
        <a href="http://www.greencenter.mx">
            <div class="logo">
                <img class="logo-size" src="{{asset('images/gc/logo72.png')}}" alt="">
            </div>
        </a>
    </div>
    <div class="row">
        <div class="img-holder">
            <div class="bg"></div>
            <div class="info-holder">

            </div>
        </div>
        <div class="form-holder">
            <div class="form-content">
                <div class="form-items">
                    <h4>GreenCenter Crm</h4> <br>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <input id="email" type="email" class="mb-4 form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="admin@gc.com" placeholder="Usuario"  required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password"  value="gc12345*-" placeholder="Password " required>
                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                        @endif
                        <input type="checkbox" id="chk1" {{ old('remember') ? 'checked' : '' }}><label for="chk1">Recordarme</label>
                        <div class="form-button">
                            <button id="submit" type="submit" class="ibtn">Acceder</button>
                        </div>
                    </form>
                    @if ($errors->has('active'))
                        <div class="row mt-lg-2">
                            <div class="col-sm-12 text-center">
                                <p style="color:black">{!!  $errors->first('active') !!} </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="{{asset('loging/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('loging/popper.min.js')}}"></script>
<script type="text/javascript" src="{{asset('loging/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('loging/main.js')}}"></script>
</body>
</html>
