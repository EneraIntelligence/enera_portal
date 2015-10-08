@extends('layouts.interaction')

@section('title', 'Banner')
@section('content')

    <div>
        <img id="banner"  class="img-responsive center-block" src="{{asset('img').'/'.$data['imagen'] }}" alt="Enera Portal">
    </div>
    <div style="margin: 15px 0; margin: 15px 0; position: absolute; bottom: 10px; width: 94%; left:3%">
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