@extends('layouts.main')
@section('head_scripts')
    {!! HTML::style(asset('css/captcha.css')) !!}
@endsection
@section('title', 'Captcha test')

@section('content')
    <div id="captcha">
        <div class="col-md-4">
            <img src="{{asset('img/'. $cover)}}" alt="Enera Portal" style="width: 100%;">

            <form action="#">
                <input id="captcha-value" type="text" name="Captcha" style="width: 100%;"><br>
            </form>
            <div id="error">Respuesta invalida</div>
            <button class="btn btn-primary btn-lg" style="margin: 5px;">Check</button>
        </div>
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
                    } else if (field.value == '{{$captcha}}') {
                        alert('Captcha Valido')
                        document.getElementById('captcha-value').value = '';
                        document.getElementById('error').style.display = 'none';
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