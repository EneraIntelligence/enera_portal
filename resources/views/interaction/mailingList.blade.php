@extends('layouts.main')
@section('head_scripts')

{!! HTML::style('http://fonts.googleapis.com/icon?family=Material+Icons') !!}
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
        $(document).ready(function () {

            var myLog = new logs();
            var clicked = false;

            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            $(".subscribe-btn").click(function () {

                if(!clicked)
                {
                    clicked = true;

                    var json = {
                        _token: "{!! session('_token') !!}"
                    };

                    myLog.saveMail(json, function () {
                        //on success mail save
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


                    }, function () {
                        //fail mail save
                        myLog.redirectOut(btn.attr('success_url'));

                    });
                }

            });


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

@stop

