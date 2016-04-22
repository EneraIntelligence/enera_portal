@extends('layouts.main')
@section('head_scripts')
{!! HTML::style('http://fonts.googleapis.com/icon?family=Material+Icons') !!}
{!! HTML::style(asset('css/welcome.css')) !!}
{!! HTML::style('css/bannerLink.css') !!}
{!! HTML::style('css/interaction-common.css') !!}

        <!-- branch colors -->
<style>
    body {
        background-color: #e8eaf6;
    }

    .nav-wrapper, footer.page-footer {
        background-color: #3f51b5;
    }
</style>
@stop
@section('title', 'Banner Link')

@section('header')
    <nav>
        <div class="nav-wrapper z-depth-3 valign-wrapper">
            <img class="circle avatar" src="http://graph.facebook.com/{{$fb_id}}/picture?type=square"
                 alt="">
            <p class="instructions valign center-align">Ve el siguiente anuncio <br> para navegar gratuitamente</p>

        </div>
    </nav>
    @stop


    @section('content')
            <!-- Main card -->
    <div class="welcome card small z-depth-2">
        <img class="responsive-img" style="margin-bottom: -6px;"
             src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['small'] !!}">
    </div>
    <!-- Main card -->

    <div class="card-panel center-align actions-card">
        <a class="btn waves-effect waves-light nav-btn indigo z-depth-2" href="javascript:void(0)"
           success_url="{{Input::get('base_grant_url') }}">
            <span class="white-text left">
                Navegar por Internet
            </span>
            <i class="right material-icons">wifi</i>
        </a>
    </div>
    <!-- login buttons -->


    {{--<div>--}}

    {{--src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['small'] !!}"--}}
    {{--alt="Banner"/>--}}
    {{--</div>--}}


    {{--<div class="banner-button">--}}
    {{--<div>--}}
    {{--<button id="navegar" type="button" class="btn btn-primary btn-block"--}}
    {{--success_url="{{Input::get('base_grant_url') }}">--}}
    {{--Navegar en internet--}}
    {{--</button>--}}
    {{--</div>--}}
    {{--</div>--}}
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

            var btn = $(".nav-btn");

            /*
             var test = btn.attr('success_url');
             test = replaceUrlParam(test, "continue_url","{{$banner_link}}");
             test = replaceUrlParam(test, "redir","{{$banner_link}}");
             $("#test").html(test);*/

            btn.click(function () {
                if (!clicked) {
                    clicked = true;

                    var success_url = btn.attr('success_url');
                    //force redirect to banner link
                    success_url = replaceUrlParam(success_url, "continue_url", "{{$banner_link}}");
                    success_url = replaceUrlParam(success_url, "redir", "{{$banner_link}}");

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

        function replaceUrlParam(url, paramName, paramValue) {
            paramValue = encodeURIComponent(paramValue);
            var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)');
            if (url.search(pattern) >= 0) {
                return url.replace(pattern, '$1' + paramValue + '$2');
            }
            return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
        }
    </script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logs.js') }}"></script>
@stop