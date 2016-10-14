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

        {{--

            <form id="hiddenForm" method=POST action="https://{{$ip}}:9443/portalintf">
            Username:<input type="text" name="username" value="{{$client_mac}}">
            Password:<input type="password" name="password" value="{{$client_mac}}">
            </form>
        --}}

    <div id="status" class="black-text">
        <p>{{$query}}</p>
        <p>{{$resp}}</p>

    </div>


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
/*
        $("#hiddenForm").css("display","none");

        $(document).ready(function(){

            function submitform(){
                document.forms["hiddenForm"].submit();
            }

            submitform();

        });*/




/*
        $(document).ready(function()
        {
            var url = "https://{!! $ip !!}:9443/portalintf";

            var statusLog=$("#status");
            statusLog.append("<p>Iniciando conexión a "+url+"</p>");

            var json_data={
                "Vendor": "ruckus",
                "RequestPassword": "t3!um123",
                "APIVersion": "1.0",
                "RequestCategory": "GetConfig",
                "RequestType": "Encrypt",
                "Data": "{!! $client_mac !!}"
            };

            statusLog.append("<p>Encriptando mac: "+json_data.Data+"</p>");


            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: json_datawel
            }).done(function (data)
            {
                console.log("success");
                statusLog.append("<p>conexión exitosa, mac encriptada: "+data.Data+"</p>");

                //console.log(data);
            }).fail(function (jqXHR, textStatus, errorThrown)
            {


                statusLog.append("<p>error de conexión: </p>");

                statusLog.append("<p>"+jqXHR+"</p>");
                statusLog.append("<p>"+textStatus+"</p>");
                statusLog.append("<p>"+errorThrown+"</p>");

            });


        });*/


    </script>
    {{--{!! HTML::script('js/welcome.js') !!}--}}

@stop


