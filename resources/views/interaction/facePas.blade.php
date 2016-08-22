{!! HTML::script(asset('js/jquery.min.js')) !!}
{!! HTML::script('js/ajax/logs.js') !!}

<script>
    $(document).ready(function () {
//        var myLog = new logs();
        //console.log("ready!");
        var myLog = new logs();

        var accessedJson = {
            _token: "{!! session('_token') !!}",
            client_mac: "{!! Input::get('client_mac') !!}"
        };

        var success_url = "{{ Input::get('base_grant_url') }}";
        //force redirect to banner link
        var adsLink = "{{ URL::route('ads') }}";

        console.log(adsLink);
        console.log(success_url);

        success_url = replaceUrlParam(success_url, "continue_url",adsLink);
        success_url = replaceUrlParam(success_url, "redir",adsLink);

        console.log(success_url);


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