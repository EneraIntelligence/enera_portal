@extends('layouts.main')
@section('head_scripts')

@stop
@section('main_bg'){!! $main_bg !!}@stop
@section('content')
    Invalid Network

    <pre>
        @if(isset($_GET["res"]))

            res: {{$_GET["res"]}}
        @endif

        @if(isset($_GET["uamip"]))

            uamip: {{$_GET["uamip"]}}
            uamport: {{$_GET["uamport"]}}
            mac: {{$_GET["mac"]}}
            called: {{$_GET["called"]}}
            ssid: {{$_GET["ssid"]}}
            userurl: {{$_GET["userurl"]}}
            challenge: {{$_GET["challenge"]}}

        @endif

    </pre>

@stop