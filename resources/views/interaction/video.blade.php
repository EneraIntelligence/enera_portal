@extends('layouts.interaction')

@section('title', 'Video')

@section('content')
    <div>
        <video id="video" controls autoplay>
            <source src="{!! $video !!}" type="video/mp4">
            {{--<source src="http://media.w3.org/2010/05/sintel/trailer.webm" type="video/webm">--}}
            {{--<source src="http://media.w3.org/2010/05/sintel/trailer.ogv" type="video/ogg">--}}
            Tu navegador no soporta reproduccion de video.
        </video>
    </div>
    <div class="banner-button">
        <div>
            <button id="navegar" type="button" class="btn btn-primary btn-block"
                    susses_url="{!! Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=900' !!}">
                Navegar en internet
            </button>
        </div>

    </div>
@stop