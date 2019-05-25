<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <style>
        body {
            margin: 0;
            padding-right: 2px;
        }
        div {
            display: block;
            float: left;
            width: 100%;
            font-size: 12px;
        }
        .top {
            border: 1px solid black;
            background-color: #6ba168;
            border-radius: 3px;
            margin-top: 20px;
        }
        .logo {
            width: 15%;
            text-align: center;
            margin-top: 20px
        }
        .generals {
            width: 85%;
            text-align: left;
            margin-top: 15px;
            color: black;
        }
    </style>
</head>
<body>
<div class="top">
    <div class="logo">
        <img src="{{asset('images/gc/logo192.png')}}" alt="" width="96">
    </div>
    <div class="generals">
        <div style="width: 35%; text-align: left;">
            <div style="font-weight:bolder; font-size: 18px">{{$company->name}}</div>
            <div style="padding-bottom: 10px;">{{$company->address}}</div>
        </div>
        <div style="width: 35%; text-align: left;  padding-left: 15px;  border-left: 1px solid rgba(128,128,128,0.49)">
            <span style="font-weight: bolder">Email:</span>
            {{$company->email}} <br>
            <span style="font-weight: bolder">RFC:</span>
            {{$company->rfc}}
        </div>
        <div style="width: 20%; text-align: center; padding-left: 5px; border-left: 1px solid rgba(128,128,128,0.49)">
            <span style="font-weight: bolder">Teléfono:</span>
            {{$company->phone1}} <br>
            <span style="font-weight: bolder">WhastApp:</span>
            {{$company->phone2}}
        </div>
    </div>
</div>

</body>
</html>
