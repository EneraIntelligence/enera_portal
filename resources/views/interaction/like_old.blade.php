@extends('layouts.interaction')

@section('head_scripts')
    {!! HTML::style(asset('css/mailing_list.css')) !!}
    <style>
        .fb_iframe_widget iframe
        {
            transform: scale(2.5);
            -ms-transform: scale(2.5);
            -webkit-transform: scale(2.5);
            -o-transform: scale(2.5);
            -moz-transform: scale(2.5);
            transform-origin: bottom left;
            -ms-transform-origin: bottom left;
            -webkit-transform-origin: bottom left;
            -moz-transform-origin: bottom left;
            -webkit-transform-origin: bottom left;

            top: 40px;
            left: -25px;
        }
    </style>
@stop

@section('title', 'Like')

@section('content')
    <div id="fb-root"></div>

    <div>
        <!-- banner -->
        {{--<img id="banner" style="border: solid 1px white;" class="img-responsive center-block" src="{{asset('img').'/'.$images['small'] }}" alt="Enera Portal">--}}

        <img  id="banner" style="border: solid 1px white;" class="img-responsive center-block"
              src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['small'] !!}"
              alt="Banner"/>

    </div>

    <div class="center-block" style="margin-top:10px; width:73px;">
        <!-- like button -->
        <div class="fb-like" data-href="{{$like_url}}" data-send="false" data-layout="button" data-width="200" data-show-faces="false"></div>
    </div>


    <div class="banner-button">

        <!-- navigate button -->
        <div style="margin: 10px 0;">
            <a id="navegar" style="font-size:20px; color:white;" href="#"
               success_url="{{Input::get('base_grant_url') }}">
                <p class="text-center">Deseo navegar en internet</p>
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

            var accessedJson = {
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            };
            myLog.accessed(accessedJson, function()
            {
                //on accessed saved
                myLog.redirectOut(btn.attr('success_url'));

            }, function()
            {
                //fail accessed save
            });

        });

        //when like button is loaded...
        var finished_rendering = function() {
            console.log("finished rendering fb plugins");
        };


        var clicked=false;
        //like button is pressed
        var page_like_callback = function(url, html_element) {

            if(!clicked) {
                clicked = true;
                var completedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };
                myLog.completed(completedJson, function () {
                    //on completed saved
                    var json = {
                        _token: "{!! session('_token') !!}"
                    };

                    if (!pageWasLikedBefore) {
                        myLog.saveUserLike(json, function () {
                            //on success like save
                            myLog.redirectOut(btn.attr('success_url'));


                        }, function () {
                            myLog.redirectOut(btn.attr('success_url'));

                        });
                    }
                    else {
                        myLog.redirectOut(btn.attr('success_url'));
                    }

                }, function () {
                    //fail completed save
                    myLog.redirectOut(btn.attr('success_url'));

                });
            }

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