@extends('layouts.main')

@section('content')
@parent
<div v-if="landscapers.length > 0" class="row m-t-20" v-cloak>
    <div class="panel panel-border panel-inverse m-t-5">
        <div class="panel-heading text-center">
           <h3>LISTADO DE MANTENIMIENTOS AGENDADOS</h3>
        </div>
        <div class="panel-body">

        </div>
    </div>
</div>

@component('com.spiner')@endcomponent
@endsection
@section('script')
    @parent
    <script src="{{asset('js/app/notifications.js')}}"></script>
@endsection
