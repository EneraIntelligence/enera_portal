@extends('layouts.main')
@section('head_scripts')

{!! HTML::style(asset('css/interaction-common.css')) !!}
{!! HTML::style(asset('css/video.css')) !!}

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
        <video id="theVideo" class="responsive-video banner-video">
            <source src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $video !!}" type="video/mp4">

            {{--<source src="http://media.w3.org/2010/05/sintel/trailer.webm" type="video/webm">--}}
            {{--<source src="http://media.w3.org/2010/05/sintel/trailer.ogv" type="video/ogg">--}}
            Tu navegador no soporta reproduccion de video.
        </video>
    </div>
    <!-- Banner card -->

    <!-- botones -->
    <div class="card-panel center-align actions-card">


        <a class="btn waves-effect waves-light play-btn indigo z-depth-2" href="#!"
          onclick="playVideo()">
            <span class="white-text left">
                Reproducir video
            </span>
            <i class="material-icons right">play_circle_filled</i>

        </a>

        <a class="btn waves-effect waves-light nav-btn indigo z-depth-2" href="#!"
           success_url="{{Input::get('base_grant_url') }}">
            <span class="white-text left">
                Navegar en internet
            </span>
            <i class="right material-icons">wifi</i>

        </a>


    </div>
    <!-- botones -->


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


    {!! HTML::script('js/greensock/plugins/CSSPlugin.min.js') !!}
    {!! HTML::script('js/greensock/easing/EasePack.min.js') !!}
    {!! HTML::script('js/greensock/TweenLite.min.js') !!}

    {{--{!! HTML::script('js/iphone-inline-video.common-js.js') !!}--}}
    {{--{!! HTML::script('js/iphone-inline-video.es-modules.js') !!}--}}
    {!! HTML::script('js/iphone-inline-video.browser.js') !!}

    {!! HTML::script('js/ajax/logs.js') !!}


    <script>
        var video = $("#theVideo");
        var bannerVideo=$('video').get(0);
        var playing = false;
        makeVideoPlayableInline(bannerVideo);


        function playVideo()
        {
            if (!playing)
            {
                var actionsCard = $(".actions-card");
                TweenLite.to(actionsCard, .3, {y: -actionsCard.outerHeight()});

                playing = true;
//                console.log(video);
                bannerVideo.play();
            }
        }

        $(document).ready(function ()
        {


            var clicked = false;

            video.on('ended', myHandler);





            function myHandler(e)
            {
                console.log('Video Ended');

                var actionsCard = $(".actions-card");

                var playBtn= $(".play-btn");
                var navBtn = $(".nav-btn");
                playBtn.css("display", "none");
                navBtn.css("display", "block");
                TweenLite.fromTo(actionsCard, .3, {y: -actionsCard.outerHeight()}, {y: 0, ease: Quad.easeOut});

            }

            var myLog = new logs();
            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            var btn = $(".nav-btn");
            btn.click(function ()
            {
                if (!clicked)
                {
                    clicked = true;

                    var completedJson = {
                        _token: "{!! session('_token') !!}",
                        client_mac: "{!! Input::get('client_mac') !!}"
                    };
                    myLog.completed(completedJson, function ()
                    {
                        //success saving completed
                        myLog.redirectOut(btn.attr('success_url'));

                    }, function ()
                    {
                        //fail on save completed
                        myLog.redirectOut(btn.attr('success_url'));
                    });
                }
            });
        });
    </script>


@stop



