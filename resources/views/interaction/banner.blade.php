@extends('layouts.interaction')

@section('title', 'Banner')
@section('content')

    <div>
        <img class="img-responsive center-block" src="{{asset('img').'/'.$data['imagen'] }}" alt="Enera Portal">
    </div>
    <div style="margin: 15px 0;">
        <div>
            <button id="navegar" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}"> Navegar en
                internet
            </button>
        </div>

    </div>
@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            var myLog = new logs();
//            console.log("ready!");

            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            $("#navegar").click(function () {
                console.log('click en el boton');
                myLog.completed({
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                });
            });
        });
    </script>

@stop