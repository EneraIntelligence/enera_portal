@extends('layouts.main')
@section('head_scripts')

@stop
@section('main_bg'){!! $main_bg !!}@stop
@section('content')
    Invalid Network

    <pre>
        res: {{$_GET["res"]}}
        uamip: {{$_GET["uamip"]}}
        uamport: {{$_GET["uamport"]}}
        mac: {{$_GET["mac"]}}
        called: {{$_GET["called"]}}
        ssid: {{$_GET["ssid"]}}
        nasid: {{$_GET["nasid"]}}
        userurl: {{$_GET["userurl"]}}
        challenge: {{$_GET["challenge"]}}
    </pre>

@stop