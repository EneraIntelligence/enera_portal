@extends('layouts.interaction')

@section('content')

    <div class="center-block container">

        <!-- banner -->
        <img class="img-responsive center-block" style="max-height:80%"
             src="{{asset('img').'/'.$data['imagen'] }}"
             alt="Enera Portal">

        <div class="bottom-container">
            <!-- subscribe button -->
            <button id="subscribe" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}">
                Deseo suscribirme
            </button>

            <!-- navigate button -->
            <a id="navigate" href="#" data="{{$data['link']}}">
                <p class="text-center">Navegar en internet</p>
            </a>
        </div>

    </div>

@stop

@section('footer_scripts')

    <script>

        $(document).ready(function ()
        {
            var link = "{!! $data['link'] !!}";
            var idCamp = "{!! $id !!}";

            console.log("id campaña: "+idCamp);
            console.log("link: "+link);

            var myLog = new logs();
            console.log("ready!");
            myLog.loaded();


            $("#subscribe").click(function()
            {
                myLog.completed(link);
            });

            $("#navigate").click(function()
            {
                myLog.completed(link);
            });



        });

    </script>

@stop