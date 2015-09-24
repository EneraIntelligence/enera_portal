
@extends('layouts.main')
@section('head_scripts')
    <script></script>
@stop
@section('content')

    <h1>Welcome {{$userData->getName()}}</h1>

    @if($userLikes!=null)
        <ul>
        @foreach($userLikes as $like)
            <li>{{$like['name']}}</li>
        @endforeach
        </ul>
    @endif

@stop
@section('footer_scripts')
    <script></script>
@stop
