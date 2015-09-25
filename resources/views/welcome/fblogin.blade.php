
@extends('layouts.main')
@section('head_scripts')
    <script src="js/canvasloader.js"></script>
    <script src="js/greensock/plugins/CSSPlugin.min.js"></script>
    <script src="js/greensock/easing/EasePack.min.js"></script>
    <script src="js/greensock/TweenLite.min.js"></script>
@stop
@section('content')

    <div style="margin: 20px auto 0; width:290px;">
        <a id="fb-btn" onclick="showLoader()" href="{{ $loginUrl }}">
            <img id="fb-img" src="https://scontent-dfw1-1.xx.fbcdn.net/hphotos-xaf1/t39.2178-6/851579_209602122530903_1060396115_n.png" alt="">
        </a>

        <div style="display: none; width: 70px; height: 70px; margin-top: -64px; margin-left: 110px;" id="canvasloader-container" class="wrapper"></div>
    </div>




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
            //document.getElementById("fb-btn").style.display = "none";

            TweenLite.to('#fb-img',.4,{scaleX:0, scaleY:0, alpha:0, ease: Back.easeIn});
            TweenLite.from('#canvasloader-container',.3,{delay:.4, scaleX:0, scaleY:0, alpha:0, ease: Power2.easeOut});
        }

    </script>
@stop
