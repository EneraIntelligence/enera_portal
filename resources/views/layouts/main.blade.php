<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=.70,maximum-scale=.70,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="HandheldFriendly" content="true">
    <title>@yield('title')</title>
    {!! HTML::style(asset('css/main.css')) !!}
    {!! HTML::style(asset('css/bootstrap.css')) !!}
    {!! HTML::script(asset('js/jquery.min.js')) !!}
    {!! HTML::script(asset('js/bootstrap.min.js')) !!}
    {!! HTML::script(asset('js/main.js')) !!}
    @yield('head_scripts')
</head>
<body style="background-image: url('{!! url('img') !!}/{!! session('main_bg') !!}')">
<div id="portal_content">
    @yield('content')
</div>
<div id="modal1" class="modalmask">
    <div class="modalbox" style="background: none;">
        <img src="{{asset('img/landscape.png')}}" alt="" style="width: 100%; top: 100px; margin: auto;">
    </div>
    <div class="modalbox" style="background: none; color: white; text-align: center;">
        <h3>Please turn your device</h3>
    </div>
</div>
@yield('footer_scripts')
</body>
</html>