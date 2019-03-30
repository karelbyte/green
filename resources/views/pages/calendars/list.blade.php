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
    </style>
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

    ></vue-cal>
</div>
@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('appjs/vue-cal.min.js')}}"></script>
    <script src="{{asset('appjs/multiselect.min.js')}}"></script>
    <script src="{{asset('appjs/calendars.js')}}"></script>
@endsection
