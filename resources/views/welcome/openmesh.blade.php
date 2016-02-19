@extends('layouts.main')
@section('head_scripts')

@stop

@section('content')
    Open-mesh Network

    <br>

    <a href="{{$redirect_url}}">Login</a>

    <br>

    redirect_url: {{$redirect_url}}

    <br>

    res: {{$redirect_url}}

@stop