@extends('layouts.interaction')

@section('title', 'Survey')

@section('head_scripts')
    {!! HTML::style(asset('css/survey.css')) !!}
@endsection

@section('content')
    <div  style="overflow-x: hidden; height: 100%">

        <div>
            <img id="banner" class="img-responsive center-block" src="{{asset('img').'/'.$image }}"alt="Enera Portal">
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
                            <button class="btn-block btn btn-default answer" id="{{$ak}}">{{ $av }}</button>
                        @endforeach
                    </div>

                </div>

            @endforeach


            <div class="question">
                <div class="banner-button">

                    <div>
                        <button id="navegar" type="button" class="btn btn-primary btn-block"
                                susses_url="{{Input::get('base_grant_url').'?continue_url='.Input::get('user_continue_url').'&duration=900' }}">
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

            var prevHeight = 0;
            var width = 0;
            var currentQuestion = 0;

            setupQuestionsClick();
            setupQuestionsPosition();

            function goNextQuestion()
            {
                currentQuestion++;
                TweenLite.to(".questionContainer",.5,{x:"-="+(width+10)});
            }

            function saveAnswer(qId, aId)
            {
                console.log(qId+": "+aId);

            }

            $( window ).resize(resizeSurvey);

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
                    $(this).find(".answer").each(function (ans_index) {
                        $(this).click(function () {
                            $(this).removeClass("btn-default");
                            $(this).addClass("btn-primary");
                            saveAnswer(index, ans_index);
                            goNextQuestion();
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
                        width = $(this).width()*1.1;
                    }

                });
            }

        });


    </script>
@stop