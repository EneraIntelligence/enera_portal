@extends('layouts.main')
@section('head_scripts')
    {!! HTML::style(asset('css/ads.css')) !!}

    <!-- branch colors -->
    <style>
        body {
            background-color: #e8eaf6;
        }

        footer.page-footer {
            background-color: #3f51b5;
        }
    </style>


@stop

@section('header')

@stop

@section('content')

    <!-- Main card -->
    <div class="welcome card small center-align">
        <div class="container">
            <h4>Validando...</h4>
        </div>
    </div>
    <!-- Main card -->

    <input type="hidden" value="EneraPass2236">


@stop

@section('footer')


    <div class="footer-copyright">
        <div class="container">

            <a class="grey-text text-lighten-4 right" href="http://enera.mx" target="_blank">© 2016 Enera
                Intelligence</a>
        </div>
    </div>

@stop

@section('footer_scripts')


@stop


