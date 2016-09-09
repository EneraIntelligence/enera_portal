@extends('layouts.main')
@section('head_scripts')
    {!! HTML::style(asset('css/ads.css')) !!}

    <!-- branch colors -->
    <style>
        body {
            background-color: #e8eaf6;
        }

        footer.page-footer {
            background-color: #3f51b5;
        }
    </style>


@stop

@section('header')

@stop

@section('content')

    <!-- Main card -->
    <div class="welcome card small center-align">
        <div class="container">
            <h4>Validando con Radius Server</h4>
        </div>
    </div>
    <!-- Main card -->


    {{--<form id="hiddenForm" method=POST action="{{$ip}}">--}}
    <form id="hiddenForm" method=POST action="https://{{$ip}}/login.html">

        {{--IP:{{$ip}} <br>--}}
        Username:<input type="text" name="username" value="{{$client_mac}}">
        Password:<input type="password" name="password" value="{{$client_mac}}">
        redirect_url:<input type="text" name="redirect_url" value="http://potal.enera-intelligence.mx/success">
        buttonClicked:<input type="text" name="buttonClicked" value="4">
        {{--<input type="submit" value="Login">--}}
    </form>


@stop

@section('footer')


    <div class="footer-copyright">
        <div class="container">
            <!--
                        <img src="https://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/logo_pie_enera_alto.png"
                             alt="" class="footer-logo left">-->

            <a class="grey-text text-lighten-4 right" href="http://enera.mx" target="_blank">© 2016 Enera
                Intelligence</a>
        </div>
    </div>

@stop

@section('footer_scripts')

    <script>

        $("#hiddenForm").css("display", "none");

        $(document).ready(function () {

            function submitform() {
                document.forms["hiddenForm"].submit();


                /*
                var link = document.location.href;
                var searchString = "redirect=";
                var equalIndex = link.indexOf(searchString);
                var redirectUrl = "";

                if (document.forms[0].action == "") {
                    var url = window.location.href;
                    var args = new Object();
                    var query = location.search.substring(1);
                    var pairs = query.split("&");
                    for (var i = 0; i < pairs.length; i++) {
                        var pos = pairs[i].indexOf('=');
                        if (pos == -1) continue;
                        var argname = pairs[i].substring(0, pos);
                        var value = pairs[i].substring(pos + 1);
                        args[argname] = unescape(value);
                    }
                    document.forms[0].action = args.switch_url;
                }
                if (equalIndex >= 0) {
                    equalIndex += searchString.length;
                    redirectUrl = "";
                    redirectUrl += link.substring(equalIndex);
                }
                if (redirectUrl.length > 255)
                    redirectUrl = redirectUrl.substring(0, 255);
                document.forms[0].redirect_url.value = redirectUrl;
                document.forms[0].buttonClicked.value = 4;
                document.forms[0].submit();*/

            }

            submitform();

        });
    </script>
    {{--{!! HTML::script('js/welcome.js') !!}--}}

@stop


