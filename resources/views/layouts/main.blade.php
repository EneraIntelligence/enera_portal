<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    {!! HTML::style(asset('css/main.css')) !!}
    @yield('head_scripts')
</head>
<body>
@yield('content')
@yield('footer_scripts')
</body>
</html>