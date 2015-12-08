@extends('layouts.interaction')

@section('head_scripts')
    {!! HTML::style(asset('css/mailing_list.css')) !!}
@endsection

@section('title', 'Like')

@section('content')

    <div id="fb-root"></div>
    <script>

        //fb initialization

        window.fbAsyncInit = function() {
            FB.init({
                appId      : 'GEu8L7YaTo68wbRJ54peqf0EdgMgf8f4',
                xfbml      : true,
                version    : 'v2.5'
            });

            FB.Event.subscribe('xfbml.render', finished_rendering);

            FB.Event.subscribe('edge.create', page_like_callback);
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));



    </script>

    <div>
        <!-- banner -->
        <img class="img-responsive center-block"
             src="{{asset('img').'/'.$image }} "
             id="banner-mailing"
             alt="Enera Portal">



    </div>

    <div class="center-block" style="width:73px;">
        <!-- like button -->
        <div class="fb-like" data-href="http://ederdiaz.com" data-send="false" data-layout="button" data-width="200" data-show-faces="false"></div>
    </div>


    <div class="banner-button">

        <!-- navigate button -->
        <div style="margin: 10px 0;">
            <a id="navegar" href="#"
               success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=900' }}">
                <p class="text-center">Deseo navegar en internet sin suscribirme</p>
            </a>
        </div>
    </div>


@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {

        });

        var myLog = new logs();

        myLog.loaded({
            _token: "{!! session('_token') !!}",
            client_mac: "{!! Input::get('client_mac') !!}"
        });


        var btn = $("#navegar");
        btn.click(function () {
            console.log('click en el boton');
//                console.log();
            var response = myLog.completed({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });
            myLog.redirectOut(btn.attr('success_url'));
        });

        //when like button is loaded...
        var finished_rendering = function() {
            console.log("finished rendering fb plugins");
        };

        //like button is pressed
        var page_like_callback = function(url, html_element) {
            console.log("page_like_callback");
            console.log(url);
            console.log(html_element);

            myLog.completed({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });
            myLog.redirectOut(btn.attr('success_url'));

        };
    </script>

@stop