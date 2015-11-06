@extends('layouts.interaction')
@section('head_scripts')
    {!! HTML::style(asset('css/captcha.css')) !!}
@endsection
@section('title', 'Captcha')

@section('content')
    <div id="captcha">

            <div>
                <img id="captcha-img" src="{{asset('img/'. $cover_path)}}" alt="Enera Portal">
            </div>
            <form action="#">
                <input id="captcha-value" type="text" name="Captcha"><br>
            </form>
            <div id="error">Respuesta invalida</div>
            <button id="navegar" class="btn btn-primary btn-block" susses_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=900' }}">
                Navegar por intenet
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
                            console.log('click en el boton');
                            var response =myLog.completed({
                                _token: "{!! session('_token') !!}",
                                client_mac: "{!! Input::get('client_mac') !!}"
                            });
                            myLog.redirectOut(btn.attr('susses_url'));
                        });
//                        document.getElementById('captcha-value').value = '';
//                        document.getElementById('error').style.display = 'none';
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