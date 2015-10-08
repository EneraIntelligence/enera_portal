@extends('layouts.main')
@section('head_scripts')
    {!! HTML::style(asset('css/captcha.css')) !!}
@endsection
@section('title', 'Captcha test')

@section('content')
    <div id="captcha">
        <div class="col-md-4"></div>
        <div class="col-md-4">
            <img src="{{asset('img/'. $data['cover_path'])}}" alt="Enera Portal" style="width: 100%; margin: 0 auto;">

            <form action="#">
                <input id="captcha-value" type="text" name="Captcha" style="width: 100%; margin: 5px 0;"><br>
            </form>
            <div id="error">Respuesta invalida</div>
            <button id="navegar" class="btn btn-primary btn-block" url="{{$data['link']}}" style="margin: 10px 0;">Navegar por intenet</button>
            <div>
                <p> * Para navegar por internet ingresa la palabra en la imagen </p>
            </div>
        </div>
        <div class="col-md-4"></div>
    </div>

@endsection

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            $("button").click(function () {
                var data = $("form").serializeArray();
                $.each(data, function (i, field) {
                    if (field.value == "" || field.value == null) {
                        document.getElementById('error').style.display = 'block';
                    } else if (field.value == '{{$data['captcha']}}') {
                        var _token = '{!! session('_token') !!}';
                        //var elArray = new Array();
                        //var elArray = "{{ json_encode($data) }}";
                        var link = "{!! $data['link'] !!}";
                        var idCamp = "{!! $id !!}";
                        console.log("id campaña: " + idCamp);
                        console.log(link);
                        var myLog = new logs();
                        console.log("ready!");

                        myLog.loaded({
                            token: "{!! session('_token') !!}",
                            client_mac: "{!! Input::get('client_mac') !!}"
                        });

                        $("#navegar").click(function () {
                            console.log('click en el boton');
                            myLog.completed(_token, link, 'completed');
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