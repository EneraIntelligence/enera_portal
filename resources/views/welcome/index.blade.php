@extends('layouts.main')
@section('head_scripts')
    {!! HTML::style(asset('css/welcome.css')) !!}

    {!! HTML::script('js/canvasloader.js') !!}
    {!! HTML::script('js/greensock/plugins/CSSPlugin.min.js') !!}
    {!! HTML::script('js/greensock/easing/EasePack.min.js') !!}
    {!! HTML::script('js/greensock/TweenLite.min.js') !!}
@stop
@section('content')
    <div class="welcome_conteiner">
        <div class="logo">
            <img src="{!! asset('img/'.$image) !!}">
        </div>
        <div class="content">
            <span style="color: {{$message['color']}}">
                {{ $message['text'] }}
            </span>
        </div>
        <div class="login_fb">
            <a id="fb-btn" onclick="showLoader()" href="{!! $login_response !!}">     {{-- --}}
                <img id="fb-img" src="{!! asset('img/fb-login.png') !!}" alt="">
            </a>

            <div style=" width: 70px; height: 70px; margin: -55px auto 0px auto;"
                 id="canvasloader-container" class="wrapper"></div>

        </div>
    </div>
@stop
@section('footer_scripts')
    {!! HTML::script('js/ajax/logs.js') !!}
    <script>
        $(document).ready(function () {
            var myLog = new logs();

            $("#fb-btn").click(function () {
                console.log('click en el boton');
                myLog.joined({
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                });
            });

        });

        // code generated from http://heartcode.robertpataki.com/canvasloader/
        var cl = new CanvasLoader('canvasloader-container');
        cl.setColor('#3e5a98');
        cl.setDiameter(66);
        cl.setDensity(140);
        cl.setRange(0.9);
        cl.setSpeed(3);
        cl.setFPS(30);
        //end of canvas loader configuration

        function showLoader() {
            cl.show(); // show loader

            //animate out fb login button
            TweenLite.to('#fb-img', .4,
                    {
                        scaleX: 0,
                        scaleY: 0,
                        alpha: 0,
                        ease: Back.easeIn
                    });

            //animate in canvas loader
            TweenLite.from('#canvasloader-container', .4,
                    {
                        delay: .4,
                        scaleX: 0,
                        scaleY: 0,
                        alpha: 0,
                        ease: Power2.easeOut
                    });
        }

    </script>
@stop