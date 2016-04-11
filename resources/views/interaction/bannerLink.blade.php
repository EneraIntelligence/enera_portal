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

    <div id="test"></div> <!-- borrar -->

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

            var test = btn.attr('success_url');
            test = replaceUrlParam(test, "continue_url","{{$banner_link}}");
            //$("#test").html(test);

            btn.click(function () {
                if(!clicked)
                {
                    clicked=true;

                    var success_url = btn.attr('success_url');
                    //force redirect to banner link
                    success_url = replaceUrlParam(success_url, "continue_url","{{$banner_link}}");
                    success_url = replaceUrlParam(success_url, "redir","{{$banner_link}}");

                    var completedJson = {
                        _token: "{!! session('_token') !!}",
                        client_mac: "{!! Input::get('client_mac') !!}"
                    };

                    myLog.completed(completedJson, function () {
                        //on completed saved
                        myLog.redirectOut(success_url);

                    }, function () {
                        //fail completed save
                        myLog.redirectOut(success_url);
                    });
                }



            });
        });

        function replaceUrlParam(url, paramName, paramValue){
            paramValue = encodeURIComponent(paramValue);
            var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)');
            if(url.search(pattern)>=0){
                return url.replace(pattern,'$1' + paramValue + '$2');
            }
            return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue
        }
    </script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logs.js') }}"></script>
@stop