@extends('layouts.main')
@section('head_scripts')
{!! HTML::style(asset('css/interaction-common.css')) !!}
{!! HTML::style(asset('css/like.css')) !!}

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

@section('title', 'Interactúa')

@section('header')
    <nav>
        <div class="nav-wrapper valign-wrapper">

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
        <div class="container like-container z-depth-2">
            <!-- like button -->
            <div class="fb-like" data-href="{{$like_url}}" data-send="false" data-layout="button" data-width="200"
                 data-show-faces="false"></div>
        </div>


        <!-- deseo navegar sin like -->
        <a class="btn-flat waves-effect waves-orange nav-btn" href="#!"
           success_url="{{Input::get('base_grant_url') }}">
            <span class="blue-text text-darken-4">
                Navegar en internet
            </span>
        </a>

    </div>
    <!-- botón de like -->


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


    {{--{!! HTML::script('js/greensock/plugins/CSSPlugin.min.js') !!}--}}
    {{--{!! HTML::script('js/greensock/easing/EasePack.min.js') !!}--}}
    {{--{!! HTML::script('js/greensock/TweenLite.min.js') !!}--}}
    {!! HTML::script('js/image-detector.js') !!}
    {!! HTML::script('js/ajax/logs.js') !!}


    <script>


        var pageWasLikedBefore = false;
        var myLog = new logs();
        var clicked = false;

        var btn = $(".nav-btn");
        btn.click(function ()
        {
            if (!clicked)
            {
                clicked = true;

                var success_url = btn.attr('success_url');
                //force redirect to banner link
                <?php if(isset($banner_link)): ?>
                success_url = replaceUrlParam(success_url, "continue_url", "{{$banner_link}}");
                success_url = replaceUrlParam(success_url, "redir", "{{$banner_link}}");
                <?php endif;?>

                //log the access
                var accessedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };
                myLog.accessed(accessedJson, function ()
                {
                    //on accessed saved
                    myLog.redirectOut(success_url);

                }, function ()
                {
                    //fail accessed save
                    myLog.redirectOut(success_url);

                });
            }
        });

        //when like button is loaded...
        var finished_rendering = function ()
        {
            //console.log("finished rendering fb plugins");
        };


        //like button is pressed
        var page_like_callback = function (url, html_element)
        {

            if (!clicked)
            {
                clicked = true;

                var success_url = btn.attr('success_url');
                //force redirect to banner link
                <?php if(isset($banner_link)): ?>
                    success_url = replaceUrlParam(success_url, "continue_url", "{{$banner_link}}");
                    success_url = replaceUrlParam(success_url, "redir", "{{$banner_link}}");
                <?php endif;?>

                var completedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };
                myLog.completed(completedJson, function ()
                {
                    //on completed saved
                    var json = {
                        _token: "{!! session('_token') !!}"
                    };

                    if (!pageWasLikedBefore)
                    {
                        myLog.saveUserLike(json, function ()
                        {
                            //on success like save
                            myLog.redirectOut({{$success_url}});


                        }, function ()
                        {
                            myLog.redirectOut({{$success_url}});

                        });
                    }
                    else
                    {
                        myLog.redirectOut({{$success_url}});
                    }

                }, function ()
                {
                    //fail completed save
                    myLog.redirectOut({{$success_url}});

                });
            }

        };

        var page_unlike_callback = function (url, html_element)
        {

            pageWasLikedBefore = true;

        };


        //fb initialization
        window.fbAsyncInit = function ()
        {
            FB.init({
                appId: 'GEu8L7YaTo68wbRJ54peqf0EdgMgf8f4',
                xfbml: true,
                version: 'v2.5'
            });

            FB.Event.subscribe('xfbml.render', finished_rendering);

            FB.Event.subscribe('edge.create', page_like_callback);
            FB.Event.subscribe('edge.remove', page_unlike_callback);
        };

        (function (d, s, id)
        {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id))
            {
                return;
            }
            js = d.createElement(s);
            js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


        $(document).ready(function ()
        {
            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });
        });
    </script>

@stop
