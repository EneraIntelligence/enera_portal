<!DOCTYPE html>
<html lang="en">
<head>
    <title>ENERA PORTAL | @yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=.70,maximum-scale=.70,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    {!! HTML::style(asset('css/app.css')) !!}
    {!! HTML::style(asset('css/main.css')) !!}
    {!! HTML::style(asset('css/bootstrap.css')) !!}
    {!! HTML::script(asset('js/jquery.min.js')) !!}
    {!! HTML::script(asset('js/main.js')) !!}

    @yield('head_scripts')

</head>
<body style="background-image: url('http://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/{!! session('main_bg') !!}' )">
<div id="portal_content">
    <div class="col-md-4"></div>
    <div id="center-column" class="col-md-4">
        {{--<header style="font-weight: bold; font-size: 25px; width: 100%; margin: 5px auto; padding: 0px; text-align: center;">--}}
            {{--Hola, {!! session('user_name') !!}--}}
        {{--</header>--}}
        @yield('content')
    </div>
    <div class="col-md-4"></div>

</div>
<div id="modal1" class="modalmask">
    <div class="modalbox" style="background: none;">
        <img src="{{asset('img/landscape.png')}}" alt="" style="width: 100%; top: 100px; margin: auto;">
    </div>
    <div class="modalbox" style="background: none; color: white; text-align: center;">
        <h3>Please turn your device</h3>
    </div>
</div>

<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','http://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-83818238-1', 'auto');
    ga('send', 'pageview');

</script>

{!! HTML::script('js/ajax/logs.js') !!}
{!! HTML::script('js/resize.js') !!}
{!! HTML::script('js/resize-mailing.js') !!}
@yield('footer_scripts')
</body>
</html>