@extends('layouts.interaction')

@section('content')

    <div class="center-block container">

        <!-- banner -->
        <img class="img-responsive center-block"
             src="{{asset('img').'/'.$data['imagen'] }}"
             alt="Enera Portal">

        <!-- subscribe button -->
        <button id="subscribe" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}">
            Deseo suscribirme
        </button>

        <!-- navigate button -->
        <a id="navigate" href="#" data="{{$data['link']}}">
            <p class="text-center">Navegar en internet</p>
        </a>

    </div>

@stop

@section('footer_scripts')

    <script>

        $(function(){
            //jquery is loaded

            //setup clicks
            $("#subscribe").click(subscribe);
            $("#navigate").click(navigate);

        });

        function subscribe()
        {
            console.log("suscribiendo...");

            //al terminar de suscribir dar acceso a internet
            navigate();
        }

        function navigate()
        {
            console.log("usa el internet");
        }

    </script>

@stop