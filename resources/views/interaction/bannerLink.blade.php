@extends('layouts.interaction')
@section('head_scripts')
    {!! HTML::style(asset('css/banner.css')) !!}
@stop
@section('title', 'Banner Link')

@section('content')
    <div>
        {{--<img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$images['small'] }}" alt="Enera Portal">--}}
        <img id="banner" class="img-responsive center-block"
             src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['small'] !!}"
             alt="Banner"/>
    </div>

    error!
    {!! Input::get('base_grant_url') !!}

    <div class="banner-button">
        <div>
            <button id="navegar" type="button" class="btn btn-primary btn-block"
                    success_url="{{Input::get('base_grant_url') }}">
                Navegar en internet
            </button>
        </div>
    </div>
@stop

@section('footer_scripts')
    <script>
        $(document).ready(function () {

            var clicked = false;

            var myLog = new logs();
//            console.log("ready!");

            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            var btn = $("#navegar");
            btn.click(function () {
                if(!clicked)
                {
                    clicked=true;
                    var completedJson = {
                        _token: "{!! session('_token') !!}",
                        client_mac: "{!! Input::get('client_mac') !!}"
                    };

                    myLog.completed(completedJson, function () {
                        //on completed saved
                        myLog.redirectOut(btn.attr('success_url'));

                    }, function () {
                        //fail completed save
                        myLog.redirectOut(btn.attr('success_url'));
                    });
                }



            });
        });
    </script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logs.js') }}"></script>
@stop