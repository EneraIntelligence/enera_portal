<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    {{--<meta name="viewport" content="width=device-width,initial-scale=.70,maximum-scale=.70,user-scalable=no">--}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">

    <title>@yield('title')</title>

    <!-- css -->
    {{--{!! HTML::style(asset('css/main.css')) !!}--}}
    {{--{!! HTML::style(asset('css/bootstrap.css')) !!}--}}
    {!! HTML::style('css/material_icons.css') !!}
    {!! HTML::style('css/materialize.css') !!}

            <!-- apple icons -->
    {{--<link rel="icon" sizes="128x128" href="img/enera_logo_app.png">--}}
    {{--<link rel="apple-touch-icon" sizes="128x128" href="img/enera_logo_app.png">--}}
    {{--<link rel="apple-touch-icon-precomposed" sizes="128x128" href="img/enera_logo_app.png ">--}}
    @yield('head_scripts')
</head>
{{--<body style="overflow-y:auto; background-attachment: fixed; background-image: url('https://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/{!! session('main_bg') !!}' )">--}}
<body>

{{--<div id="portal_content">--}}
    {{--@yield('content')--}}
{{--</div>--}}

<header>
    @yield('header')
</header>

<main class="container">
    <!-- Page Content goes here -->
    @yield('content')
</main>

<footer class="page-footer">
    @yield('footer')
</footer>


<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','http://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-83818238-1', 'auto');
    ga('send', 'pageview');

</script>

{!! HTML::script(asset('js/jquery.min.js')) !!}
{{--{!! HTML::script(asset('js/bootstrap.min.js')) !!}--}}
{!! HTML::script( 'js/materialize.js' ) !!}

{{--{!! HTML::script(asset('js/main.js')) !!}--}}
@yield('footer_scripts')

</body>
</html>