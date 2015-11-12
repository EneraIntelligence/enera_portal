@extends('layouts.interaction')

@section('title', 'Survey')

@section('head_scripts')
    {!! HTML::style(asset('css/survey.css')) !!}
@endsection

@section('content')
    <div>
        @foreach($survey as $qk => $qv)
            <div class="question">
                <h4 id="{!! $qk !!}" style="padding: 5px 0px;">
                    {{ $qv['question'] }}
                </h4>

                <div>
                    @foreach($qv['answers'] as $ak => $av)
                        <div>
                            <input id="{!! $qk.$ak !!}" value="{!! $ak !!}" name="{!! $qk !!}" type="radio">
                            <label for="{!! $qk.$ak !!}">{{ $av }}</label>
                        </div>
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
@stop