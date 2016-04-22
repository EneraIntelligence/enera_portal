@extends('layouts.main')
@section('head_scripts')

{!! HTML::style('http://fonts.googleapis.com/icon?family=Material+Icons') !!}
{!! HTML::style(asset('css/interaction-common.css')) !!}
{!! HTML::style(asset('css/survey.css')) !!}

        <!-- branch colors -->
<style>
    body {
        background-color: #e8eaf6;
    }

    .nav-wrapper, footer.page-footer {
        background-color: #3f51b5;
    }
</style>

<!-- fb button scale -->
<style>
    .fb_iframe_widget iframe {
        transform: scale(2.5);
        -ms-transform: scale(2.5);
        -webkit-transform: scale(2.5);
        -o-transform: scale(2.5);
        -moz-transform: scale(2.5);
        transform-origin: top left;
        -ms-transform-origin: top left;
        -webkit-transform-origin: top left;
        -moz-transform-origin: top left;
        -webkit-transform-origin: top left;

        left: -35px;
        top: -3px;
    }
</style>
@stop

@section('title', 'Interactúa')

@section('header')
    <nav>
        <div class="nav-wrapper valign-wrapper">

            <img class="circle avatar" src="http://graph.facebook.com/{{$fb_id}}/picture?type=square"
                 alt="">
            <p class="instructions valign center-align">Contesta las preguntas <br> para navegar gratuitamente</p>

        </div>
    </nav>
@stop

@section('content')

    <div id="fb-root"></div>


    <!-- Banner card -->
    <div class="banner card-panel z-depth-2 center-align">
        <img class="responsive-img image-small" style="margin-bottom: -6px;"
             src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['survey'] !!}">
    </div>
    <!-- Banner card -->

    <!-- botones -->
    <div class="card-panel center-align actions-card">

        <?php
        $step_num = 0;
        $step_display = "block";
        ?>

        @foreach($survey as $qk => $qv)

            <div class="question" id="step_{{$step_num}}" style="display:<?php echo $step_display ?>">
                {{--question--}}
                <h5>{{ $qv['question'] }}</h5>

                {{--answers--}}
                <div>
                    @foreach($qv['answers'] as $ak => $av)
                        <a class="answer btn waves-effect waves-light indigo z-depth-2" href="#!">
                        <span class="white-text left">
                            {{ $av }}
                        </span>
                            <i class="right material-icons">navigate_next</i>
                        </a>
                        <p></p>
                    @endforeach

                </div>
            </div>

            <?php
            $step_num++;
            $step_display = "none";
            ?>


        @endforeach

        <div id="step_{{$step_num}}" style="display:<?php echo $step_display ?>">
            <h5>¡Gracias!</h5>


            <a class="btn-flat waves-effect waves-orange nav-btn" href="#!"
               success_url="{{Input::get('base_grant_url') }}">
                <span class="blue-text text-darken-4">
                    Navegar en internet
                </span>
            </a>
        </div>


    </div>
    <!-- botones -->


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


    {!! HTML::script('js/greensock/plugins/CSSPlugin.min.js') !!}
    {!! HTML::script('js/greensock/easing/EasePack.min.js') !!}
    {!! HTML::script('js/greensock/TweenLite.min.js') !!}
    {{--{!! HTML::script('js/survey.js') !!}--}}
    {!! HTML::script('js/ajax/logs.js') !!}

    <script>


        $(document).ready(function ()
        {

            var myLog = new logs();
            var clicked = false;

            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });


            /**
             * completed survey
             * @type {jQuery|HTMLElement}
             */
            var btn = $(".nav-btn");
            btn.click(function ()
            {

                if (!clicked)
                {
                    clicked = true;


                    var json = {
                        _token: "{!! session('_token') !!}",
                        client_mac: "{!! Input::get('client_mac') !!}",
                        answers: userAnswers
                    };
                    myLog.saveUserSurvey(json, function ()
                    {

                        //on success like save
                        //console.log("all saved!");
                        var completedJson = {
                            _token: "{!! session('_token') !!}",
                            client_mac: "{!! Input::get('client_mac') !!}"
                        };
                        myLog.completed(completedJson, function ()
                        {
                            //on completed saved
                            myLog.redirectOut(btn.attr('success_url'));

                        }, function ()
                        {
                            myLog.redirectOut(btn.attr('success_url'));
                        });


                    }, function ()
                    {
                        myLog.redirectOut(btn.attr('success_url'));
                    });


                }
            });


            var currentQuestion = 0;
            var userAnswers = {};
            var inTransition = false;

            setupQuestionsClick();

            function setupQuestionsClick()
            {
                $(".question").each(function (index)
                {
                    var question = $(this);
                    $(this).find(".answer").each(function (ans_index)
                    {

                        var answer = $(this);
                        $(this).click(function ()
                        {
                            if (!inTransition)
                            {
                                inTransition = true;

                                saveAnswer(index, ans_index);
                                goNextQuestion();
                            }
                        });
                    });
                });
            }


            function goNextQuestion()
            {
                currentQuestion++;
                //console.log("click: "+currentQuestion);
                var card = $(".actions-card");
                var answeredQ = $("#step_" + (currentQuestion - 1));
                qHeight = card.outerHeight();

                TweenLite.to(card, .3, {
                    y: -qHeight,
                    ease:Quad.easeIn,
                    onComplete: function ()
                    {
                        console.log(answeredQ)
                        answeredQ.css("display", "none");

                        var nextQ = $("#step_" + currentQuestion);
                        nextQ.css("display", "block");


                        var qHeight = card.outerHeight();

                        TweenLite.fromTo(card, .3,
                                {
                                    y: -qHeight
                                },
                                {
                                    y: 0,
                                    ease:Quad.easeOut,
                                    onComplete: function ()
                                    {
                                        inTransition = false;
                                    }
                                });

                    }
                });


            }

            function saveAnswer(qId, aId)
            {

                userAnswers['q' + qId] = "a" + aId;

            }


        });


    </script>


@stop
