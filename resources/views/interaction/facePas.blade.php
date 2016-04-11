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
        myLog.accessed(accessedJson, function () {
            //on accessed saved
            window.location.href = "{{Input::get('base_grant_url')}}";
        }, function () {
            //fail accessed save
            window.location.href = "{{Input::get('base_grant_url')}}";
        });


    });
</script>