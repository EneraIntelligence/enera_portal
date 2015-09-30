<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    {!! HTML::style(asset('css/main.css')) !!}
    {!! HTML::style(asset('css/bootstrap.css')) !!}
    {!! HTML::script(asset('js/jquery-2.1.4.min.js')) !!}
    @yield('head_scripts')
</head>
<body style="background-image: url('{!! url('img') !!}/{!! session('main_bg') !!}')">
<div id="portal_content">
    @yield('content')
</div>
@yield('footer_scripts')
</body>
</html>