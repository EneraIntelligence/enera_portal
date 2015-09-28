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
<body style="background-image: url('{!! URL::asset('img/bg_welcome.jpg') !!}')">
@yield('content')
@yield('footer_scripts')
</body>
</html>