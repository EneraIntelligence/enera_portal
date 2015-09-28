<!-- view that shows the data got by de facebook button -->
@extends('layouts.main')
@section('head_scripts')
    <script></script>
@stop
@section('content')

    <h1>Welcome {{$userData['facebook']['name']}}</h1>
    <p>Your data has been saved</p>
    <h3>Likes({{count($userData['facebook']['likes'])}}) ids:</h3>
    <ul>
    @foreach($userData['facebook']['likes'] as $like)
        <li> {{ $like }} </li>
    @endforeach
    </ul>

@stop
@section('footer_scripts')
    <script></script>
@stop
