@extends('layouts.interaction')
@section('head_scripts')
    {!! HTML::style(asset('css/captcha.css')) !!}
@stop
@section('title', 'Captcha')

@section('content')
    <div id="captcha">

            <div>
                <img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$images['small'] }}" alt="Enera Portal">

            </div>
            <form action="#">
                <input id="captcha-value" type="text" name="Captcha"><br>
            </form>
            <div id="error">Respuesta invalida</div>
            <button id="navegar" class="btn btn-primary btn-block" success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=900' }}">
                Navegar por internet
            </button>
            <div>
                <p> * Para navegar por internet ingresa la palabra en la imagen </p>
            </div>
    </div>

@endsection

@section('footer_scripts')

    <script>
        $(document).ready(function () {
//            console.log("ready!");
            $("button").click(function () {
                var data = $("form").serializeArray();
                $.each(data, function (i, field) {
                    if (field.value == "" || field.value == null) {
                        document.getElementById('error').style.display = 'block';
                    } else if (field.value == '{¡¡ $captcha ¡¡}') {
                        var myLog = new logs();
                        myLog.loaded({
                            _token: "{!! session('_token') !!}",
                            client_mac: "{!! Input::get('client_mac') !!}"
                        });

                        var btn = $("#navegar");
                        btn.click(function () {

                            var completedJson = {
                                _token: "{!! session('_token') !!}",
                                client_mac: "{!! Input::get('client_mac') !!}"
                            };

                            myLog.completed(completedJson, function()
                            {
                                //on completed saved
                                myLog.redirectOut(btn.attr('success_url'));

                            }, function()
                            {
                                //fail completed save
                            });

                        });

                    } else {
                        document.getElementById('error').style.display = 'block';
                    }
                });
            });
            $(window).keydown(function (event) {
                if (event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
    </script>


@endsection