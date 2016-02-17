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

    <link rel="icon" sizes="128x128" href="img/enera_logo_app.png">
    <link rel="apple-touch-icon" sizes="128x128" href="img/enera_logo_app.png">
    <link rel="apple-touch-icon-precomposed" sizes="128x128" href="img/enera_logo_app.png ">
    @yield('head_scripts')
</head>
<body style="overflow-y:auto; background-attachment: fixed; background-image: url('https://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/{!! session('main_bg') !!}' )">
<div id="portal_content">
    @yield('content')
</div>

@yield('footer')

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