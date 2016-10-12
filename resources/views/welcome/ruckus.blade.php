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


        {{--<form id="hiddenForm" method=POST action="http://{{$ip}}:9997/login">--}}
            <form id="hiddenForm" method=POST action="http://{{$ip}}:9443/login">
                {{--IP:{{$ip}} <br>--}}
            Username:<input type="text" name="username" value="{{$client_mac}}">
            Password:<input type="password" name="password" value="{{$client_mac}}">
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

        $("#hiddenForm").css("display","none");

        $(document).ready(function(){

            function submitform(){
                document.forms["hiddenForm"].submit();
            }

            submitform();

        });
    </script>
    {{--{!! HTML::script('js/welcome.js') !!}--}}

@stop


