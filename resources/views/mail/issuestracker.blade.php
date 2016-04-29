<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
</head>
<body style="margin:0;">

<header style="background-color: #00BFFF; padding: 20px 20px 20px 0px;">
    <div style="display: inline-block; margin: 0px 12px;">
        <img src="{{ asset('img/Logo Enera Blanco-01.svg') }}" alt="Enera" width="25" height="25">
    </div>
    <div style="display: inline-block;">
        <h1 style="margin: 0 auto; color: white;">
            New exception in Enera {{ $issue->issue['platform'] }}
        </h1>
    </div>
</header>

<main style="padding: 0 50px;">
    <p>
        <font size="7" color="#696969">
            {{ $issue->issue['title'] }}
        </font>
    </p>
    <p>
        <font size="4" color="#000000">
            {{ $issue->exception['msg'] }}
        </font><br>
        <font size="4" color="#696969">
            {{ $issue->issue['file']['path'] }}:{{ $issue->issue['file']['line'] }}
        </font>
    </p>
    <p>
        <font size="3" color="#696969">
            <b>ENTORNO</b> : {{ $env }}
        </font><br>
        <font size="3" color="#696969">
            <b>HOST</b> : {{ gethostname() }}
        </font><br>
        <font size="3" color="#696969">
            <b>URL</b> : ----
        </font>
    </p>
</main>

</body>
</html>