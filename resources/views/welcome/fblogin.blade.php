
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
            <img id="fb-img" src="img/fb-login.png" alt="">
        </a>

        <div style=" width: 70px; height: 70px; margin-top: -50px; margin-left: 110px;" id="canvasloader-container" class="wrapper"></div>
    </div>




@stop
@section('footer_scripts')
    <script>

        // code generated from http://heartcode.robertpataki.com/canvasloader/
        var cl = new CanvasLoader('canvasloader-container');
        cl.setColor('#3e5a98');
        cl.setDiameter(66);
        cl.setDensity(140);
        cl.setRange(0.9);
        cl.setSpeed(3);
        cl.setFPS(30);
        //end of canvas loader configuration

        function showLoader()
        {
            cl.show(); // show loader

            //animate out fb login button
            TweenLite.to('#fb-img',.4,
                    {
                        scaleX:0,
                        scaleY:0,
                        alpha:0,
                        ease: Back.easeIn
                    });

            //animate in canvas loader
            TweenLite.from('#canvasloader-container',.4,
                    {
                        delay:.4,
                        scaleX:0,
                        scaleY:0,
                        alpha:0,
                        ease: Power2.easeOut
                    });
        }

    </script>
@stop
