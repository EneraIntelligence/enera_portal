@extends('layouts.interaction')

@section('title', 'Survey')

@section('head_scripts')
    {!! HTML::style(asset('css/survey.css')) !!}
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
@stop

@section('content')
    <div style="overflow-x: hidden; height: 100%">

        <div>
            {{--<img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$images['survey'] }}"alt="Enera Portal">--}}
            <img id="banner" class="img-responsive center-block"
                 src="https://s3-us-west-1.amazonaws.com/enera-publishers/items/{!! $images['survey'] !!}"
                 alt="Banner"/>
            <h4 class="text-center" style="color:white; font-family: 'Open Sans', sans-serif;">Para Obtener acceso a internet, contesta la siguiente encuesta...</h4>
        </div>

        <div class="questionContainer" style="padding:5%;">
            @foreach($survey as $qk => $qv)

                <div class="question">

                    {{--question--}}
                    <h3 id="{!! $qk !!}" class="text-center questionText" >
                        {{ $qv['question'] }}
                    </h3>

                    {{--answers--}}
                    <div>
                        @foreach($qv['answers'] as $ak => $av)
                            <button class="btn-block btn answer dl-horizontal" id="{{$ak}}">{{ $av }}</button>
                        @endforeach
                    </div>

                </div>

            @endforeach


            <div class="question">
                <div class="banner-button">

                    <h3 class="text-center questionText">¡Gracias por participar!</h3>

                    <div>
                        <button id="navegar" type="button" class="btn btn-primary btn-block"
                                success_url="{{Input::get('base_grant_url') }}">
                            Navegar en internet
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

    {!! HTML::script('js/greensock/plugins/CSSPlugin.min.js') !!}
    {!! HTML::script('js/greensock/easing/EasePack.min.js') !!}
    {!! HTML::script('js/greensock/TweenLite.min.js') !!}

    <script>


        $(document).ready(function () {

            var myLog = new logs();
            var clicked=false;

            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            var prevHeight = 0;
            var width = 0;
            var currentQuestion = 0;
            var userAnswers = {};
            var inTransition = false;

            setupQuestionsClick();
            setupQuestionsPosition();

            var btn = $("#navegar");
            btn.click(function () {

                if(!clicked) {
                    clicked = true;
                    var completedJson = {
                        _token: "{!! session('_token') !!}",
                        client_mac: "{!! Input::get('client_mac') !!}"
                    };
                    myLog.completed(completedJson, function () {
                        //on completed saved
                        var json = {
                            _token: "{!! session('_token') !!}",
                            client_mac: "{!! Input::get('client_mac') !!}",
                            answers: userAnswers
                        };
                        myLog.saveUserSurvey(json, function () {
                            //on success like save
                            console.log("all saved!");
                            myLog.redirectOut(btn.attr('success_url'));
                        }, function () {
                            myLog.redirectOut(btn.attr('success_url'));
                        });
                    }, function () {
                        myLog.redirectOut(btn.attr('success_url'));
                    });
                }
            });

            function goNextQuestion(question, answerId) {


                currentQuestion++;
                TweenLite.to(".questionContainer", .5, {
                    x: "-=" + (width + 10),
                    ease: Quad.easeIn, onComplete: function () {
                        inTransition = false;
                    }
                });

                question.find(".answer").each(function (ans_index) {
                    if (ans_index != answerId) {
                        TweenLite.to($(this), .2, {alpha: 0});
                    }
                });
            }

            function saveAnswer(qId, aId) {

                userAnswers['q' + qId] = "a" + aId;

            }

            $(window).resize(resizeSurveyDelayed);

            function resizeSurveyDelayed() {
                resizeSurvey();

                setTimeout(resizeSurvey, 10);
            }

            function resizeSurvey() {
                TweenLite.killTweensOf(".questionContainer");
                TweenLite.to(".questionContainer", .0001, {x: -(width + 10) * currentQuestion});

                setupQuestionsPosition();
            }

            function setupQuestionsClick() {
                $(".question").each(function (index) {
                    var question = $(this);
                    $(this).find(".answer").each(function (ans_index) {

                        var answer = $(this);
                        $(this).click(function () {

                            if (inTransition) {
                                return;
                            }
                            else {
                                inTransition = true;

                                //$(this).removeClass("btn-default");
                                //$(this).addClass("btn-primary");
                                saveAnswer(index, ans_index);
                                goNextQuestion(question, ans_index);
                            }
                        });
                    });
                });
            }

            function setupQuestionsPosition() {
                $(".question").each(function (index) {
                    if (index > 0) {
                        $(this).css("position", "relative");
                        $(this).css("margin-top", -prevHeight);
                        $(this).css("left", (width + 10) * index);

                        var w = $(this).width();

                        prevHeight = $(this).height() + 10;

                    }
                    else {
                        prevHeight = $(this).height() + 10;
                        width = Math.floor($(this).width() * 1.1);
                    }

                });
            }

        });


    </script>
@stop