@extends('layouts.main')
@section('head_scripts')

    {!! HTML::style(asset('css/welcome.css')) !!}
    {!! HTML::style(asset('css/captcha.css')) !!}
    {!! HTML::style('css/interaction-common.css') !!}

    <style>
        body {
            background-color: #e8eaf6;
        }

        .nav-wrapper, footer.page-footer {
            background-color: #3f51b5;
        }

        /* label color */
        .input-field label {
            color: #000;
        }

        /* label focus color */
        .input-field input[type=text]:focus + label {
            color: #000;
        }

        /* label underline focus color */
        .input-field input[type=text]:focus {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }

        /* valid color */
        .input-field input[type=text].valid {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }

        /* invalid color */
        .input-field input[type=text].invalid {
            border-bottom: 1px solid #000;
            box-shadow: 0 1px 0 0 #000;
        }

        /* icon prefix focus color */
        .input-field .prefix.active {
            color: #000;
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
@section('title', 'Captcha')

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

    <!-- botón de navegar -->
    <div class="card-panel center-align actions-card">

        {{--<a class="btn waves-effect waves-light subscribe-btn indigo z-depth-2" href="#!"--}}
        {{--success_url="{{Input::get('base_grant_url') }}">--}}
        {{--<span class="white-text left">--}}
        {{--Navegar por Internet--}}
        {{--</span>--}}
        {{--<i class="right material-icons">wifi</i>--}}
        {{--</a>--}}
        <div id="captcha">

            <form action="#">
                <div class="input-field col s12">
                    <input id="captcha-value" type="text" name="captcha">
                    <label for="captcha-value" data-error="wrong" data-success="right">Captcha</label>
                </div>
            </form>
            <div id="error">Respuesta invalida</div>
            <button id="navegar" class="btn waves-effect waves-light subscribe-btn indigo z-depth-2"
                    success_url="{{Input::get('base_grant_url') }}">
                Navegar en internet
            </button>
            <div>
                <p> * Para navegar por internet ingresa la palabra en la imagen </p>
            </div>
        </div>

    </div>
    {{--<div id="captcha">--}}

    {{--<form action="#">--}}
    {{--<input id="captcha-value" type="text" name="Captcha"><br>--}}
    {{--</form>--}}
    {{--<div id="error">Respuesta invalida</div>--}}
    {{--<button id="navegar" class="btn btn-primary btn-block"--}}
    {{--success_url="{{Input::get('base_grant_url') }}">--}}
    {{--Navegar por internet--}}
    {{--</button>--}}
    {{--<div>--}}
    {{--<p> * Para navegar por internet ingresa la palabra en la imagen </p>--}}
    {{--</div>--}}
    {{--</div>--}}

@endsection

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

            $("button").click(function () {
                var data = $("form").serializeArray();
                $.each(data, function (i, field) {
                    console.log(field.value);
                    if (field.value == "" || field.value == null) {
                        document.getElementById('error').style.display = 'block';
                    } else if (field.value == '{!! $captcha !!}') {
                        document.getElementById('error').style.display = 'none';
                        var myLog = new logs();
                        myLog.loaded({
                            _token: "{!! session('_token') !!}",
                            client_mac: "{!! Input::get('client_mac') !!}"
                        });

                        var btn = $("#navegar");
                        if (!clicked) {
                            clicked = true;
                            var completedJson = {
                                _token: "{!! session('_token') !!}",
                                client_mac: "{!! Input::get('client_mac') !!}"
                            };

                            myLog.completed(completedJson, function () {
                                //on completed saved
                                myLog.redirectOut(btn.attr('success_url'));

                            }, function () {
                                //fail completed save
                            });
                        }
                    } else {
                        document.getElementById('error').style.display = 'block';
                    }
                });
            });
            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
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
    </script>


@endsection