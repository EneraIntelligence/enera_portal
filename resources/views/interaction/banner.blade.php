@extends('layouts.interaction')

@section('content')
    <div class=" container">
        <div class="center-block">
            <img class="img-responsive center-block" src="{{asset('img').'/'.$data['imagen'] }}" alt="Enera Portal">
        </div>
        <button id="navegar" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}"> Navegar en internet</button>
    </div>
    {{var_dump($data)}}

@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            //var elArray = new Array();
            var elArray = "{{ json_encode($data) }}";
            var arr = JSON.parse(elArray);
            console.log(arr[0]);
            var myLog = new logAjax;
            console.log("ready!");

            {{--console.log({{$data}});--}}
            {{--myLog.loaded({{$data}});--}}

            $("#navegar").click(function() {
//                myLog.completed(data);


            });
        });
    </script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logAjax.js') }}" ></script>
@stop