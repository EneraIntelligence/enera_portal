@extends('layouts.interaction')

@section('head_scripts')
    {!! HTML::style(asset('css/mailing_list.css')) !!}
@stop

@section('title', 'Mailing List')

@section('content')

    <div>
        <!-- banner -->
        {{--<img id="banner-mailing" class="img-responsive center-block" src="{{asset('img').'/'.$images['small'] }}" alt="Enera Portal">--}}
        <img  id="banner-mailing" class="img-responsive center-block"
              src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['small'] !!}"
              alt="Banner"/>

    </div>

    <div class="banner-button">
        <!-- subscribe button -->
        <button id="subscribe" type="button" class="btn btn-primary btn-block"
                success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration='. session('session_time') }}">
        SUSCRIBIRME
        </button>

        <!-- navigate button -->
        <div style="margin: 10px 0;">
            <a id="navegar" href="#"
               success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration='. session('session_time') }}">
                <p class="text-center">Deseo navegar en internet sin suscribirme</p>
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

                var completedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };

                myLog.completed(completedJson, function()
                {
                    //on completed saved
                    var json = {
                        _token: "{!! session('_token') !!}"
                    };
                    myLog.saveMail(json, function()
                    {
                        //on success mail save
                        myLog.redirectOut(btn.attr('success_url'));


                    },function()
                    {
                        //fail mail save
                    });

                }, function()
                {
                    //fail completed save
                });





            });


            var btn = $("#navegar");
            btn.click(function () {
                console.log('click en el boton de solo navegar');

                var accessedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };
                myLog.accessed(accessedJson, function()
                {
                    //on accessed saved
                    myLog.redirectOut(btn.attr('success_url'));

                }, function()
                {
                    //fail accessed save
                });

            });
        });
    </script>

@stop