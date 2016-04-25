@extends('layouts.main')
@section('head_scripts')
{!! HTML::style(asset('css/ads.css')) !!}

        <!-- branch colors -->
<style>
    body {
        background-color: #e8eaf6;
    }

    footer.page-footer {
        background-color: #3f51b5;
    }
</style>
@stop

@section('header')

@stop

@section('content')

        <!-- Main card -->
<div class="welcome card small center-align">
    <div class="container">
        <h4>Bienvenido a Enera WiFi.</h4>
        <p>Ahora estás conectado.</p>
    </div>
</div>
<!-- Main card -->

<div class="ads card small z-depth-2">


    <!-- ads google --
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!— Rectangle Banner —>
    <ins class="adsbygoogle"
         style="display:inline-block;width:300px;height:250px"
         data-ad-client="ca-pub-7906422245182015"
         data-ad-slot="9115810884"></ins>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({});
    </script>
    <!-- ads -->


    <script src="//go.mobtrks.com/notice.php?p=623555&interstitial=1"></script>

</div>


<!-- bottom text -->
<div class="text card">
    <div class="container">
        <p>Enera es la red más grande de Internet Gratuito en Latinoamerica. Hemos desarrollado innovadores mecanismos
            para ofrecer el Wi-Fi gratuito en distintos puntos públicos como: Centros Comerciales, Parques, Transporte
            Público, Hoteles, Restaurantes, Hospitales y más lugares.</p>
        <p>Con el objetivo de mantenerte conectado el y ofrececiendo la mejor calidad en conectividad Enera Wifi ofrece
            un medio a anunciantes para tener oportunidad de ofrecer propuestas de valor a los consumidores con el
            objetivo de activar económicamente sus empresas al ofrecer productos competitivos en el mercado.</p>
        <p>Enera Intelligence facilita la comunicación y conocimiento de marca hacia los usuarios de la red. A través
            del portal de bienvenida ayuda a promocionar una marca por medio de un gráfico, un video, promociones
            exclusivas o mensajes hacia el cliente potencial.</p>

        <p>Actualmente Enera Intelligence tiene presencia en varios establecimientos dentro de las categorías de Centros
            Comerciales, Hotelería, Centros de Consumo, Transporte Público, y Supermercados. En 2016 implementaremos
            2,300 hotspots, lo que nos permitirá alcanzar más de 500,000 conexiones diariamente.</p>
        <p>Enera Publishers es una herramienta Self-Service para crear campañas con los diferentes productos con los que
            contamos. En esta herramienta, puedes diseñar tu estrategia de comunicación, definir a quien va dirigida y
            asignarle el periodo en el que estará activa esa campaña. Nuestra plataforma de Publishers permite crear
            campañas de forma fácil y sencilla.  Si deseas conocer más sobre Enera visita www.enera.mx o envíanos un
            correo a contacto@enera.mx.</p>

        <img style="max-width:100%; display:block; margin:0 auto;" src="img/btn_enera.png" alt="">

    </div>


</div>
<!-- bottom text -->


<!-- encuesta inicio --
<script type="text/javascript">
    (function ()
    {
        var ARTICLE_URL = window.location.href;
        var CONTENT_ID = 'everything';
        document.write(
                '<scr' + 'ipt ' +
                'src="//survey.g.doubleclick.net/survey?site=_sri472xtikse2ibpcf6yinxuwe' +
                '&amp;url=' + encodeURIComponent(ARTICLE_URL) +
                (CONTENT_ID ? '&amp;cid=' + encodeURIComponent(CONTENT_ID) : '') +
                '&amp;random=' + (new Date).getTime() +
                '" type="text/javascript">' + '\x3C/scr' + 'ipt>');
    })();
</script>

<div class="p402_premium">
    @if($image!="")
        <div style="width: 100%;  margin: 30px auto 10px;  padding: 0px;  text-align: center;">
            <img src="https://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/{!! $image !!}">
        </div>
    @endif

        <h3 style="color: {{$color}}; text-align: center;">Ahora estás conectado a internet</h3>

</div>
<script type="text/javascript">
    try
    {
        _402_Show();
    } catch (e)
    {
    }
</script>
<!-- encuesta fin -->


@stop

@section('footer')


    <div class="footer-copyright">
        <div class="container">
            <!--
                        <img src="https://s3-us-west-1.amazonaws.com/enera-publishers/branch_items/logo_pie_enera_alto.png"
                             alt="" class="footer-logo left">-->

            <a class="grey-text text-lighten-4 right" href="http://enera.mx" target="_blank">© 2016 Enera
                Intelligence</a>
        </div>
    </div>

@stop

@section('footer_scripts')


    {{--{!! HTML::script('js/welcome.js') !!}--}}

@stop


