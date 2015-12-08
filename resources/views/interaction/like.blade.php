@extends('layouts.interaction')

@section('head_scripts')
    {!! HTML::style(asset('css/mailing_list.css')) !!}
@endsection

@section('title', 'Like')

@section('content')

    <div id="fb-root"></div>

    <div>
        <!-- banner -->
        <img class="img-responsive center-block"
             src="{{asset('img').'/'.$image }} "
             id="Like"
             alt="Enera Portal">



    </div>

    <div class="center-block" style="width:73px;">
        <!-- like button -->
        <div class="fb-like" data-href="{{$like_url}}" data-send="false" data-layout="button" data-width="200" data-show-faces="false"></div>
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


        var pageWasLikedBefore = false;
        var myLog = new logs();

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

            var completedJson = {
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            };
            myLog.completed(completedJson, function()
            {
                //on completed saved
                var json = {
                    _token: "{!! session('_token') !!}"
                };

                if(!pageWasLikedBefore)
                {
                    myLog.saveUserLike(json, function () {
                        //on success like save
                        myLog.redirectOut(btn.attr('success_url'));


                    }, function () {
                        //fail mail save
                    });
                }
                else
                {
                    myLog.redirectOut(btn.attr('success_url'));
                }

            }, function()
            {
                //fail completed save
            });


        };

        var page_unlike_callback = function(url, html_element) {

            pageWasLikedBefore = true;

        };


        //fb initialization
        window.fbAsyncInit = function() {
            FB.init({
                appId      : 'GEu8L7YaTo68wbRJ54peqf0EdgMgf8f4',
                xfbml      : true,
                version    : 'v2.5'
            });

            FB.Event.subscribe('xfbml.render', finished_rendering);

            FB.Event.subscribe('edge.create', page_like_callback);
            FB.Event.subscribe('edge.remove', page_unlike_callback);
        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


        $(document).ready(function () {
            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });
        });
    </script>

@stop