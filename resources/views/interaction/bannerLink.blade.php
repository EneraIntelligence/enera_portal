@extends('layouts.interaction')

@section('content')
    <div class=" container">
        <div class="center-block">
            <img class="img-responsive center-block" src="{{asset('img/default.png')}}" alt="Enera Portal">
        </div>
        <button id="navegar" type="button" class="center-block btn btn-primary">Navegar en internet</button>
    </div>

@stop

@section('footer_scripts')
    <script type="text/javascript">
        alert("Un mensaje de prueba");
        $( document ).ready(function() {
            console.log( "ready!" );
        });
    </script>
    {{--<link href="{{ URL::asset('js/ajax/requested.js') }}" rel="stylesheet">--}}
@stop