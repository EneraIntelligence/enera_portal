@extends('layouts.interaction')

@section('title', 'Video')

@section('head_scripts')
    {!! HTML::style('css/video.css') !!}
@stop

@section('content')
    <header style="font-weight: bold; font-size: 25px; width: 100%; margin: 5px auto; padding: 0px; text-align: center;">
        Hola, {!! session('user_name') !!}
    </header>
    @if(session('device_os') != 'Iphone')
        <h5 style="text-align: center;">Para obtener acceso te invitamos a ver el siguiente video</h5>
        <div style="width: 100%;">
            <video id="theVideo" controls autoplay>
                <source src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $video !!}" type="video/mp4">

                {{--<source src="http://media.w3.org/2010/05/sintel/trailer.webm" type="video/webm">--}}
                {{--<source src="http://media.w3.org/2010/05/sintel/trailer.ogv" type="video/ogg">--}}
                Tu navegador no soporta reproduccion de video.
            </video>
        </div>
        <div class="banner-button">
            <div>
                <button id="navegar" type="button" class="btn btn-primary btn-block"
                        success_url="{{Input::get('base_grant_url') }}">
                Navegar en internet
                </button>
            </div>
        </div>
    @else
        <div>
            <img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$image }}" alt="Enera Portal">
        </div>
        <div class="banner-button">
            <div>
                <button id="navegar" type="button" class="btn btn-primary btn-block"
                        success_url="{{Input::get('base_grant_url') }}">
                Navegar en internet
                </button>
            </div>
        </div>
    @endif
@stop
@section('footer_scripts')
    <script>
        $(document).ready(function () {
            document.getElementById('theVideo').addEventListener('ended', myHandler, false);
            function myHandler(e) {
//                console.log('Video Ended');
            }

            var myLog = new logs();
            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            var btn = $("#navegar");
            btn.click(function () {

                var completedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };
                myLog.completed(completedJson, function () {
                    //success saving completed
                    myLog.redirectOut(btn.attr('success_url'));

                }, function () {
                    //fail on save completed
                });

            });
        });
    </script>

@stop