@extends('layouts.interaction')

@section('title', 'Video')

@section('head_scripts')
    {!! HTML::style('css/video.css') !!}
@stop

@section('content')
    <header style="font-weight: bold; font-size: 25px; width: 100%; margin: 5px auto; padding: 0px; text-align: center;">
        Hola, {!! session('user_name') !!}
    </header>
    <h5 style="text-align: center;">Para obtener acceso te invitamos a ver el siguiente video</h5>
    <div style="width: 100%;">
        <video controls autoplay>
            <source src="{!! $video !!}" type="video/mp4">
            {{--<source src="http://media.w3.org/2010/05/sintel/trailer.webm" type="video/webm">--}}
            {{--<source src="http://media.w3.org/2010/05/sintel/trailer.ogv" type="video/ogg">--}}
            Tu navegador no soporta reproduccion de video.
        </video>
    </div>
    <div class="banner-button">
        <div>
            <button id="navegar" type="button" class="btn btn-primary btn-block"
                    success_url="{!! Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=900' !!}">
                Navegar en internet
            </button>
        </div>

    </div>
@stop