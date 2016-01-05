@extends('layouts.interaction')
@section('head_scripts')
    {!! HTML::style(asset('css/captcha.css')) !!}
@stop
@section('title', 'iframe')

@section('content')
    <div style="width:100%; height:90%;">
        <div id="mascara" style="position:absolute; width:100%; height:90%;">
        </div>
        <iframe id="frame" src="{{ $iframe }}" frameborder="0" style="width:100%; height:100%;"></iframe>
    </div>
    <div class="banner-button">
        <div>
            <button id="navegar" type="button" class="btn btn-primary btn-block"
                    success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration='. session('session_time') }}">
                Navegar en internet
            </button>
        </div>
    </div>

@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            var myLog = new logs();
            console.log("ready!");


            var iframe = $("#mascara");
            iframe.click(function (){
                console.log('click en blablacar');
            })

//            console.log("url = ".url);

//            myLog.loaded({
                {{--_token: "{!! session('_token') !!}",--}}
                {{--client_mac: "{!! Input::get('client_mac') !!}"--}}
//            });

            var btn = $("#navegar");
            btn.click(function () {

                console.log('click en el boton');
//                console.log();

                var response =myLog.completed({
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                });
                //myLog.redirectOut(btn.attr('susses_url'));
            });
        });
    </script>


@stop