@extends('layouts.main')
@section('head_scripts')

    {{--{!! HTML::style(asset('css/welcome.css')) !!}--}}
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

        .banner {
            padding: 20px 0;
            max-width: 440px;
        }

        #brand_cap_widget {
            margin: 0 auto;
            width: 310px;
        }

        .loader-full
        {
            position: fixed;
            background-color: white;
            top:0;
            left: 0;
            bottom: 0;
            right: 0;
            z-index: 10;

        }

        .progress
        {
            top: -8px;
            background-color: #e8eaf6;
        }

        .progress .indeterminate
        {
            background-color: #3f51b5;
        }
    </style>
@stop
@section('title', 'Brand Captcha')

@section('header')
    <nav>
        <div class="nav-wrapper z-depth-3 valign-wrapper">
            <img class="circle avatar" src="http://graph.facebook.com/{{@$fb_id}}/picture?type=square"
                 alt="">
            <p class="instructions valign center-align">Ingresa la frase solicitada <br>para navegar gratuitamente</p>

        </div>
    </nav>
@stop


@section('content')

    <div id="loader" class="loader-full">
        <div class="progress">
            <div class="indeterminate"></div>
        </div>
    </div>

    <!-- Main card -->

    <form action="" method="post">

        <div class="banner card z-depth-2">


            <?php
            include(app_path() . '/includes/brandcaptchalib.php');

            $publickey = "1d49e1794e929ea8ac80eb9386dfa79372e6f856";
            if (isset($public_key))
                $publickey = $public_key;

            if (!isset($error))
                echo brandcaptcha_get_html($publickey);
            else
                echo brandcaptcha_get_html($publickey, $error);


            ?>
        </div>
        <!-- Main card -->

        <div class="card-panel center-align actions-card">
            <a class="btn waves-effect waves-light nav-btn indigo z-depth-2" href="javascript:void(0)"
               success_url="{{Input::get('base_grant_url') }}">
                <span class="white-text left">
                    Navegar en Internet
                </span>
                <i class="right material-icons">wifi</i>
            </a>
        </div>

    </form>

@stop

@section('footer_scripts')

    {!! HTML::script('js/image-detector.js') !!}
    {!! HTML::script('js/ajax/logs.js') !!}
    {!! HTML::script('js/greensock/TweenLite.min.js') !!}
    {!! HTML::script('js/greensock/easing/EasePack.min.js') !!}
    {!! HTML::script('js/greensock/plugins/CSSPlugin.min.js') !!}

    <script>
        var btn;
        var clicked = false;
        var myLog;


        $(document).ready(function () {
            myLog = new logs();
            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            $("form").submit(function (e) {
                e.preventDefault();
                sendBrandCaptcha();
            });

            btn = $(".nav-btn");
            btn.click(sendBrandCaptcha);
        });

        function sendBrandCaptcha() {
            if (!clicked) {
                clicked = true;

                //json_data = JSON.stringify( $('form').serializeArray() );

                var o = {};
                var a = $('form').serializeArray();
                $.each(a, function () {
                    if (o[this.name] !== undefined) {
                        if (!o[this.name].push) {
                            o[this.name] = [o[this.name]];
                        }
                        o[this.name].push(this.value || '');
                    } else {
                        o[this.name] = this.value || '';
                    }
                });

                json_data = o;
                //alert(json_data);

                <?php
                $bcURL = '/interaction/logs/brandcaptcha/';
                if (isset($public_key))
                {
                    $bcURL = '/interaction/logs/brandcaptchademo/';
                }
                ?>

                var bcValidationURL = "{!! $bcURL !!}";

                $.ajax({
                    url: bcValidationURL,
                    type: 'POST',
                    dataType: 'JSON',
                    data: json_data
                }).done(function (data) {
                    console.log("response brandcaptcha");
                    console.log(data);

                    if (data.ok) {
                        var success_url = btn.attr('success_url');

                        //force redirect to ads
                        var adsLink = "{{ URL::route('ads') }}";

                        success_url = replaceUrlParam(success_url, "continue_url", adsLink);
                        success_url = replaceUrlParam(success_url, "redir", adsLink);

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
                    else {
                        alert("Frase incorrecta, intenta de nuevo.");
                        $("#brand_cap_button_reload")[0].click();
                        clicked = false;
                    }

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR);
                    console.log(textStatus);
                    console.log(errorThrown);

                    alert("Hubo un problema intenta de nuevo");

                    $("#brand_cap_button_reload")[0].click();
                    clicked = false;

                });


            }


        }

        function replaceUrlParam(url, paramName, paramValue) {
            paramValue = encodeURIComponent(paramValue);
            var pattern = new RegExp('\\b(' + paramName + '=).*?(&|$)');
            if (url.search(pattern) >= 0) {
                return url.replace(pattern, '$1' + paramValue + '$2');
            }
            return url + (url.indexOf('?') > 0 ? '&' : '?') + paramName + '=' + paramValue
        }

        window.onload = function () {
            console.log("removing loader");
            //remove loader


            TweenLite.to("#loader", .3, {
                "opacity": 0, delay:1, onComplete: function () {
                    $("#loader").css("display", "none");
                }
            });
        };
    </script>
@stop