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

<!-- fb button scale -->
<style>
    .fb_iframe_widget iframe {
        transform: scale(2.5);
        -ms-transform: scale(2.5);
        -webkit-transform: scale(2.5);
        -o-transform: scale(2.5);
        -moz-transform: scale(2.5);
        transform-origin: top left;
        -ms-transform-origin: top left;
        -webkit-transform-origin: top left;
        -moz-transform-origin: top left;
        -webkit-transform-origin: top left;

        left: -35px;
        top: -3px;
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
        <div id="fb-root"></div>


        <!-- Banner card -->
        <div class="banner card-panel z-depth-2 center-align">
            <img class="responsive-img image-small" style="margin-bottom: -6px;"
                 src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['small'] !!}">
            <img class="responsive-img image-large" style="margin-bottom: -6px;"
                 src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['large'] !!}">
        </div>
        <!-- Banner card -->

        <!-- botón de like -->
        <div class="card-panel center-align actions-card">

            <a class="btn waves-effect waves-light subscribe-btn indigo z-depth-2" href="#!"
               success_url="{{Input::get('base_grant_url') }}">
            <span class="white-text left">
                Me interesa
            </span>
                <i class="right material-icons">wifi</i>

            </a>

            <!-- deseo navegar sin like -->
            <a class="btn-flat waves-effect waves-orange nav-btn" href="#!"
               success_url="{{Input::get('base_grant_url') }}">
            <span class="blue-text text-darken-4">
                Navegar en internet
            </span>
            </a>

        </div>
        <!-- botón de like -->
    <!-- login buttons -->


    {{--<div>--}}
    {{--<img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$images['small'] }}" alt="Enera Portal">--}}
    {{--<img id="banner" class="img-responsive center-block"--}}
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

@section('footer')


    <div class="footer-copyright">
        <div class="container">
            <a class="grey-text text-lighten-4 right" href="http://enera.mx" target="_blank">© 2016 Enera
                Intelligence</a>
        </div>
    </div>

@stop

@section('footer_scripts')
    {!! HTML::script('js/image-detector.js') !!}
    {!! HTML::script('js/ajax/logs.js') !!}

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


        var btn = $(".nav-btn");
        btn.click(function () {
            //console.log('click en el boton de solo navegar');

            var accessedJson = {
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            };
            myLog.accessed(accessedJson, function () {
                //on accessed saved
                myLog.redirectOut(btn.attr('success_url'));

            }, function () {
                //fail accessed save
                myLog.redirectOut(btn.attr('success_url'));
            });

        });
        });
    </script>
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logs.js') }}"></script>
@stop