@extends('layouts.main')
@section('head_scripts')

@stop
@section('main_bg'){!! $main_bg !!}@stop
@section('content')

        <!-- encuesta inicio-->
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
    <h3 style="color:darkgrey; text-align: center;">Ahora estás conectado a internet</h3>
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


<!-- ads inicio -->

<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<!-- Anuncio Adaptable -->
<ins class="adsbygoogle"
     style="display:block"
     data-ad-client="ca-pub-7906422245182015"
     data-ad-slot="2591062884"
     data-ad-format="auto"></ins>
<script>
    (adsbygoogle = window.adsbygoogle || []).push({});
</script>

<!-- ads fin -->

@stop