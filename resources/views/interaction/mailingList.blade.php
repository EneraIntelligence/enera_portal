@extends('layouts.interaction')

@section('head_scripts')
    {!! HTML::style(asset('css/mailing_list.css')) !!}
@endsection

@section('footer_scripts')
    {!! HTML::script('js/resize-mailing.js') !!}
@endsection
@section('title', 'Mailing List')

@section('content')

    <div>
        <!-- banner -->
        <img class="img-responsive center-block"
             src="{{asset('img').'/'.$data['imagen'] }}"
             id="banner-mailing"
             alt="Enera Portal">

        {{--
        <img class="img-landscape img-responsive center-block banner"
             src="{{asset('img').'/banner-hor.png' }}"
             id="banner-horizontal"
             alt="Enera Portal">
        --}}
    </div>

    <div class="banner-button">
        <!-- subscribe button -->
        <button id="subscribe" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}">
            SUSCRIBIRME
        </button>

        <!-- navigate button -->
        <div style="margin: 10px 0;">
            <a id="navigate" href="#" data="{{$data['link']}}">
                <p class="text-center">Deseo navegar en internet sin suscribirme</p>
            </a>
        </div>
    </div>

    {{--<div class="banner-button">--}}
        {{--<div>--}}
            {{--<button id="navegar" type="button" class="btn btn-primary btn-block" data="{{$data['link']}}"> Navegar en--}}
                {{--internet--}}
            {{--</button>--}}
        {{--</div>--}}

    {{--</div>--}}

@stop

@section('footer_scripts')

    <script>

        $(document).ready(function () {
            var _token = '{!! csrf_token() !!}';

            //resize();


            var link = "{!! $data['link'] !!}";
            //var idCamp = "{!! $id !!}";

            //console.log("id campaña: "+idCamp);
            //console.log("link: "+link);

            var myLog = new logs();
            console.log("ready!");
            myLog.loaded(_token, 'loaded');


            $("#subscribe").click(function () {
                myLog.completed(_token, link, "completado");
                window.location.href = '{{route("campaign::action::save_mail")}}';
            });

            $("#navigate").click(function () {
                myLog.completed(_token, link, "navegar");
            });


        });

        //resize del banner para que no se encime al botón
        /* movido y mejorado en resize.js
         $(function(){
         resize();
         });

         $( window ).resize(resize);

         function resize() {
         resizeBanner("#banner-vertical");
         resizeBanner("#banner-horizontal");

         }

         function resizeBanner(idBanner)
         {
         var bannerImg = $( idBanner );
         bannerImg.height('auto');
         var imgHeight = bannerImg.height();

         var bottomHeight = $( ".bottom-container" ).height();
         var windowHeight = $( window ).height();
         if(imgHeight>windowHeight-bottomHeight)
         {
         bannerImg.height(windowHeight-bottomHeight);
         }
         }

         */
    </script>

@stop