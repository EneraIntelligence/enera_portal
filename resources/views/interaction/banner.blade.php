@extends('layouts.interaction')
@section('head_scripts')
    {!! HTML::style(asset('css/banner.css')) !!}
@endsection

@section('title', 'Banner')
@section('content')

    <div>
        <img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$data['imagen'] }}"
             alt="Enera Portal">
    </div>
    <div class="banner-button">
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
                var response = myLog.completed({
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                });
                myLog.redirectOut('http://www.enera.mx');
                if (response.ok == true) {

                }
            });
        });
    </script>

@stop