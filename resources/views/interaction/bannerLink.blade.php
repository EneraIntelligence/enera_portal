@extends('layouts.interaction')
@section('head_scripts')
    {!! HTML::style(asset('css/banner.css')) !!}
@endsection
@section('title', 'Banner Link')

@section('content')

    <div>
        <img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$imagen }}" alt="Enera Portal">
    </div>

    <div class="banner-button">
        <div>
            <button id="navegar" type="button" class="btn btn-primary btn-block" susses_url="{{Input::get('base_grant_url').'?continue_url=http://'.$link.'&duration=900' }}" >
                Navegar en internet
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

            var btn = $("#navegar");
            btn.click(function () {
                console.log('click en el boton');
                var response =myLog.completed({
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                });
                myLog.redirectOut(btn.attr('susses_url'));

            });
        });
    </script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logs.js') }}"></script>
@stop