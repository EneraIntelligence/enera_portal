@extends('layouts.interaction')

@section('content')
    <div class=" container">
        <div class="center-block">
            <img class="img-responsive center-block" src="{{asset('img').'/'.$data['imagen'] }}" alt="Enera Portal">
        </div>
        <button id="navegarL" type="button" class="center-block btn btn-primary">Navegar en internet</button>
    </div>

@stop

@section('footer_scripts')
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/bannerAjax.js') }}" ></script>
@stop