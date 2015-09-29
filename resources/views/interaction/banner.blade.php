@extends('layouts.interaction')

@section('content')
    <div class=" container">
        <div class="center-block">
            <img class="img-responsive center-block" src="{{asset('img').'/'.$data['imagen'] }}" alt="Enera Portal">
        </div>
        <button id="navegar" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}"> Navegar en internet</button>
    </div>

@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            console.log("ready!");

            $("#navegar").click(function() {
                var url= $("#navegar").attr('data');
                url="http://www.";
                console.log(url);
                window.location.href = url;
                url: "{!! URL::route('campaign_loaded') !!}",
            });
        });
    </script>
    {{--<script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/bannerAjax.js') }}" ></script>--}}
@stop