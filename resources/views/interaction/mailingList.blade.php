@extends('layouts.interaction')

@section('head_scripts')
    {!! HTML::style(asset('css/mailing_list.css')) !!}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <style>

    </style>
@stop

@section('title', 'Mailing List')

@section('content')

    <div>
        <!-- banner -->
        {{--<img id="banner-mailing" class="img-responsive center-block" src="{{asset('img').'/'.$images['small'] }}" alt="Enera Portal">--}}
        <img id="banner-mailing" class="img-responsive center-block"
             src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['small'] !!}"
             alt="Banner"/>

    </div>

    <div class="banner-button">
        <!-- subscribe button -->
        {{--<button type="button" class="btn btn-primary btn-block"--}}
                {{--success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration='. session('session_time') }}">--}}
            {{--ME INTERESA--}}
        {{--</button>--}}

        <div id="subscribe" class="col-md-12  col-xs-12 e-content" style="cursor: pointer; margin: 0 0 15px 0"
             success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration='. session('session_time') }}">
            <div class="col-md-9 col-xs-9 button-text">
                <p style="margin: 0; font-size: 145%;">ME INTERESA</p>
            </div>
            <div class="col-md-3  col-xs-3 button-icon">
                <div class="borderLeft">
                    <i class="material-icons" style="margin: 0; position: relative; transform: translateY(25%);">&#xE63E;</i>
                    <p style="margin: 0; position: relative; transform: translateY(-25%);">Conectar</p>
                </div>
            </div>
        </div>


        <!-- navigate button -->
        <div style="margin: 10px 0;">
            <a id="navegar" href="#"
               success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration='. session('session_time') }}">
                <p class="text-center" style="color:white; text-shadow: 2px 2px 6px #000000;">Deseo navegar en internet sin suscribirme </p>
            </a>
        </div>
    </div>


@stop

@section('footer_scripts')

    <script>
        $(document).ready(function () {
            var myLog = new logs();
            //console.log("ready!");
            //console.log($("#navegar").attr('success_url'));
            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });
            $("#subscribe").click(function () {



                var json = {
                    _token: "{!! session('_token') !!}"
                };
                myLog.saveMail(json, function () {
                    //on success mail save
                    var completedJson = {
                        _token: "{!! session('_token') !!}",
                        client_mac: "{!! Input::get('client_mac') !!}"
                    };

                    myLog.completed(completedJson, function () {
                        //on completed saved
                        myLog.redirectOut(btn.attr('success_url'));


                    }, function () {
                        //fail completed save
                        myLog.redirectOut(btn.attr('success_url'));

                    });


                }, function () {
                    //fail mail save
                    myLog.redirectOut(btn.attr('success_url'));

                });





            });


            var btn = $("#navegar");
            btn.click(function () {
                console.log('click en el boton de solo navegar');

                var accessedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };
                myLog.accessed(accessedJson, function () {
                    //on accessed saved
                    myLog.redirectOut(btn.attr('success_url'));

                }, function () {
                    //fail accessed save
                });

            });
        });
    </script>

@stop