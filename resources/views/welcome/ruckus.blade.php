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


            <form id="hiddenForm" method=POST action="http://192.168.128.14:9997/login">
            Username:<input type="text" name="username" value="enera">
            Password:<input type="password" name="password" value="enera">
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
        /*
        var xml = '' +
                "<?xml version='1.0' encoding='UTF-8'?>" +
                '<ruckus>'+
                '<req-password>myPassword</req-password>'+
                '<version>1.0</version>'+
                '<command cmd="unrestricted" ipaddr="172.18.110.221" macaddr="c4:17:fe:03:0d:1b" name="frank"/>'+
                '</ruckus>';

        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("POST","http://192.168.128.14/admin/_portalintf.jsp",true);
        xmlhttp.send(encodeURI(xml));
*/

/*
        var xml = '' +
                "<?xml version='1.0' encoding='UTF-8'?>" +
                '<ruckus>'+
                '<req-password>myPassword</req-password>'+
                '<version>1.0</version>'+
                '<command cmd="unrestricted" ipaddr="172.18.110.221" macaddr="c4:17:fe:03:0d:1b" name="frank"/>'+
                '</ruckus>';

        $.ajax({
            url: "http://192.168.128.14/admin/_portalintf.jsp",
            data: xml,
            type: 'POST',
            contentType: "text/xml",
            dataType: "text",
            success : function () {
                console.log("success");
            },
            error : function (xhr, ajaxOptions, thrownError){
                console.log(xhr.status);
                console.log(thrownError);
            }
        });*/

        $("#hiddenForm").css("display","none");

        window.onload=function(){
            //var auto = setTimeout(function(){ autoRefresh(); }, 100);

            function submitform(){
                //alert('test');
                document.forms["hiddenForm"].submit();
            }

            submitform();

            /*
            function autoRefresh(){
                clearTimeout(auto);
                auto = setTimeout(function(){ submitform(); autoRefresh(); }, 10000);
            }
            */
        }
    </script>
    {{--{!! HTML::script('js/welcome.js') !!}--}}

@stop


