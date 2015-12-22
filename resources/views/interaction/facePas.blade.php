{!! HTML::script(asset('js/jquery.min.js')) !!}

<script>
    $(document).ready(function () {
//        var myLog = new logs();
        console.log("ready!");
        window.location.href="{{Input::get('base_grant_url').'?continue_url=http://'.Input::get('user_continue_url').'&duration=900'}}"

    });
</script>