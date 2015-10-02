<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1" >--}}
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('css/bootstrap.css') }}" rel="stylesheet">
    <script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/jquery.min.js') }}" ></script>


    @yield('head_scripts')

</head>
<body>
@yield('content')
@yield('footer_scripts')
<script language="JavaScript" type="text/javascript" src="{{ URL::asset('js/ajax/logs.js') }}"></script>
</body>
</html>