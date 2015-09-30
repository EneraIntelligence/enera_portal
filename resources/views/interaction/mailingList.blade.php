@extends('layouts.interaction')

@section('content')
    <div class=" container">
        <div class="center-block">
            <img class="img-responsive center-block"
                 src="{{asset('img').'/'.$data['imagen'] }}"
                 alt="Enera Portal">
        </div>
        <button id="subscribe" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}">
            Deseo suscribirme
        </button>
        <a id="navigate" href="#" data="{{$data['link']}}">
            <p class="text-center">Navegar en internet</p>
        </a>
    </div>

@stop

@section('footer_scripts')

    <script>

        $(function(){

            //setup clicks
            $("#subscribe").click(subscribe);
            $("#navigate").click(navigate);

        });//jquery is loaded

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