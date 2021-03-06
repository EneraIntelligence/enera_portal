
{!! HTML::script(asset('js/jquery.min.js')) !!}
{!! HTML::script('js/ajax/logs.js') !!}


<script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
            m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','http://www.google-analytics.com/analytics.js','ga');

    ga('create', 'UA-83818238-1', 'auto');
    ga('send', 'pageview');

</script>

<script>
    $(document).ready(function () {
//        var myLog = new logs();
        console.log("ready!");
        var myLog = new logs();

        var accessedJson = {
            _token: "{!! session('_token') !!}",
            client_mac: "{!! Input::get('client_mac') !!}"
        };

        var success_url = "{{ Input::get('base_grant_url') }}";
        //force redirect to banner link
        var adsLink = "{{ URL::route('ads') }}";

        success_url = replaceUrlParam(success_url, "continue_url",adsLink);
        success_url = replaceUrlParam(success_url, "redir",adsLink);


        myLog.accessed(accessedJson, function () {
            //on accessed saved
            myLog.redirectOut(success_url);
        }, function () {
            //fail accessed save
            myLog.redirectOut(success_url);
        });

        function replaceUrlParam(url, paramName, paramValue){
            paramValue = encodeURIComponent(paramValue);
            var pattern = new RegExp('\\b('+paramName+'=).*?(&|$)');
            if(url.search(pattern)>=0){
                return url.replace(pattern,'$1' + paramValue + '$2');
            }
            return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue
        }


    });
</script>