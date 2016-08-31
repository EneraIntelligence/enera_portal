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
        <h4>Bienvenido a Enera WiFi.</h4>
        <p>Yuju!</p>
    </div>
</div>
<!-- Main card -->

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
        var xml = '' +
                "<?xml version='1.0' encoding='UTF-8'?>" +
                '<ruckus>'+
                '<req-password>myPassword</req-password>'+
                '<version>1.0</version>'+
                '<command cmd="unrestricted" ipaddr="172.18.110.221" macaddr="c4:17:fe:03:0d:1b" name="frank"/>'+
                '</ruckus>';

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST","/admin/_portalintf.jsp",true);
        xmlhttp.send(encodeURI(xml));
    </script>
    {{--{!! HTML::script('js/welcome.js') !!}--}}

@stop

