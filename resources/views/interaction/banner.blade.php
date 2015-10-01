@extends('layouts.interaction')

@section('content')
    <div class=" container">
        <div class="center-block">
            <img class="img-responsive center-block" src="{{asset('img').'/'.$data['imagen'] }}" alt="Enera Portal">
        </div>
        <button id="navegar" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}"> Navegar en
            internet
        </button>
    </div>

@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            //var elArray = new Array();
            //var elArray = "{{ json_encode($data) }}";
            var link = "{!! $data['link'] !!}";
            var idCamp = "{!! $id !!}";
            console.log("id campaña: " + idCamp);
            //var arr = JSON.parse(elArray);
            console.log(link);
            var myLog = new logs();
            console.log("ready!");

            myLog.loaded();

            $("#navegar").click(function () {
                myLog.completed(link);
            });


        });

    </script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logs.js') }}"></script>
@stop