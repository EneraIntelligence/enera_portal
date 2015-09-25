
@extends('layouts.main')
@section('head_scripts')
    <script src="http://heartcode-canvasloader.googlecode.com/files/heartcode-canvasloader-min-0.9.1.js"></script>
@stop
@section('content')
    <a id="fb-btn" onclick="showLoader()" href="{{ $loginUrl }}">
        <img src="https://scontent-dfw1-1.xx.fbcdn.net/hphotos-xaf1/t39.2178-6/851579_209602122530903_1060396115_n.png" alt="">
    </a>

    <div style="display:none" id="canvasloader-container" class="wrapper"></div>


@stop
@section('footer_scripts')
    <script>

        var cl = new CanvasLoader('canvasloader-container');
        cl.setColor('#3e5a98'); // default is '#000000'
        cl.setDiameter(66); // default is 40
        cl.setDensity(50); // default is 40
        cl.setRange(0.9); // default is 1.3
        cl.setSpeed(1); // default is 2
        cl.setFPS(30); // default is 24
        cl.show(); // Hidden by default

        function showLoader()
        {
            document.getElementById("canvasloader-container").style.display = "block";
            document.getElementById("fb-btn").style.display = "none";

        }

    </script>
@stop
