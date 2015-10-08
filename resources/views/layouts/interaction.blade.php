<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=.70,maximum-scale=.70,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <title>@yield('title')</title>
    {!! HTML::style(asset('css/app.css')) !!}
    {!! HTML::style(asset('css/main.css')) !!}
    {!! HTML::style(asset('css/bootstrap.css')) !!}
    {!! HTML::script(asset('js/jquery.min.js')) !!}
    {!! HTML::script(asset('js/main.js')) !!}

    @yield('head_scripts')

</head>
<body style="background-image: url('{!! url('img') !!}/{!! session('main_bg') !!}')">
<header>
    Hola, {!! session('user_name') !!}
</header>
<div id="portal_content">
    <div class="col-md-4"></div>
    <div class="col-md-4">
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
{!! HTML::script('js/ajax/logs.js') !!}
{!! HTML::script('js/resize.js') !!}
@yield('footer_scripts')
</body>
</html>