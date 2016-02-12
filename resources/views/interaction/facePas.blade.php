{!! HTML::script(asset('js/jquery.min.js')) !!}
{!! HTML::script('js/ajax/logs.js') !!}

<script>
    $(document).ready(function () {
//        var myLog = new logs();
        console.log("ready!");
        var myLog = new logs();

        var accessedJson = {
            _token: "{!! session('_token') !!}",
            client_mac: "{!! Input::get('client_mac') !!}"
        };
        myLog.accessed(accessedJson, function () {
            //on accessed saved
            //myLog.redirectOut(btn.attr('success_url'));
            window.location.href = "{{Input::get('base_grant_url').'?continue_url='.$link.'&duration='.session('session_time')}}"
        }, function () {
            //fail accessed save
        });


    });
</script>