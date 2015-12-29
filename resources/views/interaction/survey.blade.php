@extends('layouts.interaction')

@section('title', 'Survey')

@section('head_scripts')
    {!! HTML::style(asset('css/survey.css')) !!}
@stop

@section('content')
    <div  style="overflow-x: hidden; height: 100%">

        <div>
            <img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$images['survey'] }}"alt="Enera Portal">
        </div>

        <div class="questionContainer" style="padding:5%;">
            @foreach($survey as $qk => $qv)

                <div class="question">

                    {{--question--}}
                    <h4 id="{!! $qk !!}" style="padding: 5px 0px;">
                        {{ $qv['question'] }}
                    </h4>

                    {{--answers--}}
                    <div>
                        @foreach($qv['answers'] as $ak => $av)
                            <button class="btn-block btn answer" id="{{$ak}}">{{ $av }}</button>
                        @endforeach
                    </div>

                </div>

            @endforeach


            <div class="question">
                <div class="banner-button">

                    <h3 class="text-center">¡Gracias por participar!</h3>

                    <div>
                        <button id="navegar" type="button" class="btn btn-primary btn-block"
                                success_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration='. session('session_time') }}">
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


        $(document).ready(function(){

            var myLog = new logs();

            myLog.loaded({
                _token: "{!! session('_token') !!}",
                client_mac: "{!! Input::get('client_mac') !!}"
            });

            var prevHeight = 0;
            var width = 0;
            var currentQuestion = 0;

            setupQuestionsClick();
            setupQuestionsPosition();

            function goNextQuestion(question, answerId)
            {
                currentQuestion++;
                TweenLite.to(".questionContainer",.5,{x:"-="+(width+10), ease:Quad.easeIn});

                question.find(".answer").each(function (ans_index) {
                    if(ans_index!=answerId)
                    {
                        TweenLite.to($(this),.2, {alpha:0});
                    }
                });
            }

            function saveAnswer(qId, aId)
            {
                var completedJson = {
                    _token: "{!! session('_token') !!}",
                    client_mac: "{!! Input::get('client_mac') !!}"
                };

                myLog.completed(completedJson, function()
                {
                    //on completed saved

                    //aquí almacenar las respuestas
                    console.log(qId+": "+aId);

                    //despues de guardar respuestas redireccionar
                    myLog.redirectOut(btn.attr('success_url'));

                }, function()
                {
                    //fail completed save
                });


            }

            $( window ).resize(resizeSurveyDelayed);

            function resizeSurveyDelayed()
            {
                resizeSurvey();

                setTimeout(resizeSurvey,10);
            }

            function resizeSurvey()
            {
                TweenLite.killTweensOf(".questionContainer");
                TweenLite.to(".questionContainer",.0001,{x:-(width+10)*currentQuestion});

                setupQuestionsPosition();
            }

            function setupQuestionsClick()
            {
                $( ".question" ).each(function( index )
                {
                    var question = $(this);
                    $(this).find(".answer").each(function (ans_index) {

                        var answer = $(this);
                        $(this).click(function () {
                            $(this).removeClass("btn-default");
                            $(this).addClass("btn-primary");
                            saveAnswer(index, ans_index);
                            goNextQuestion(question, ans_index);
                        });
                    });
                });
            }

            function setupQuestionsPosition()
            {
                $( ".question" ).each(function( index )
                {
                    if(index>0)
                    {
                        $(this).css("position", "relative");
                        $(this).css("margin-top", -prevHeight);
                        $(this).css("left", (width+10)*index);

                        var w = $(this).width();

                        prevHeight = $(this).height()+10;

                    }
                    else
                    {
                        prevHeight = $(this).height()+10;
                        width = Math.floor($(this).width()*1.1);
                    }

                });
            }

        });


    </script>
@stop