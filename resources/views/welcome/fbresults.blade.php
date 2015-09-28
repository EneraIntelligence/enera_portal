<!-- view that shows the data got by de facebook button -->
@extends('layouts.main')
@section('head_scripts')
    <script></script>
@stop
@section('content')


    <ul>
    @foreach($userData['facebook']['likes'] as $like)
        <li> {{ $like['id'] }} </li>
    @endforeach
    </ul>

@stop
@section('footer_scripts')
    <script></script>
@stop
