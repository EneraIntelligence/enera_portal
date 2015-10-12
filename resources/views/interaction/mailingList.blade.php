@extends('layouts.interaction')

@section('head_scripts')
    {!! HTML::style(asset('css/mailing_list.css')) !!}
@endsection

@section('footer_scripts')
    {!! HTML::script('js/resize-mailing.js') !!}
@endsection
@section('title', 'Mailing List')

@section('content')

    <div>
        <!-- banner -->
        <img class="img-responsive center-block"
             src="{{asset('img').'/'.$data['imagen'] }}"
             id="banner-mailing"
             alt="Enera Portal">

        {{--
        <img class="img-landscape img-responsive center-block banner"
             src="{{asset('img').'/banner-hor.png' }}"
             id="banner-horizontal"
             alt="Enera Portal">
        --}}
    </div>

    <div class="banner-button">
        <!-- subscribe button -->
        <button id="subscribe" type="button" class="btn btn-primary btn-block" susses_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=3600' }}">
            SUSCRIBIRME
        </button>

        <!-- navigate button -->
        <div style="margin: 10px 0;">
            <a id="navegar" href="#" susses_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=900' }}">
                <p class="text-center">Deseo navegar en internet sin suscribirme</p>
            </a>
        </div>
    </div>

    {{--<div class="banner-button">--}}
        {{--<div>--}}
            {{--<button id="navegar" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}"> Navegar en--}}
                {{--internet--}}
            {{--</button>--}}
        {{--</div>--}}

    {{--</div>--}}

@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            var myLog = new logs();
            console.log("ready!");
            console.log($("#navegar").attr('susses_url'));
            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });
            $("#subscribe").click(function () {
                myLog.completed({
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                });
                window.location.href = "{!! route("campaign::action::save_mail") !!}";
//                myLog.redirectOut(btn.attr('susses_url'));
            });
            var btn = $("#navegar");
            btn.click(function () {
                console.log('click en el boton');
//                console.log();
                var response =myLog.completed({
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                });
                myLog.redirectOut(btn.attr('susses_url'));
            });
        });
    </script>

@stop