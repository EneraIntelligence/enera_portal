<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
</head>
<body style="margin:0; width: 100%">

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
        <font size="6" color="#696969">
            <a href="http://admins.enera-intelligence.mx/issuetracker/show/{{ $issue->_id }}">
                {{ $issue->issue['title'] }}
            </a>
        </font>
    </p>
    <p>
        <font size="4" color="#000000">
            {{ $issue->exception['msg'] }}
        </font><br>
        <font size="3" color="#696969">
            {{ $issue->issue['file']['path'] }}:{{ $issue->issue['file']['line'] }}
        </font>
    </p>
    <p>
        <font size="4" color="#000000">
            ENTORNO
        </font><br>
        <font size="3" color="#696969">
            {{ $env }}
        </font>
    </p>
    <p>
        <font size="4" color="#000000">
            HOST
        </font><br>
        <font size="3" color="#696969">
            {{ gethostname() }}
        </font>
    </p>
    <p>
        <font size="4" color="#000000">
            URL
        </font><br>
        <font size="3" color="#696969">
            ---
        </font>
    </p>
</main>

<footer style="background-color: #00BFFF; padding: 10px; margin-top: 20px;">
    <div style="text-align: right;">
        <h3 style="margin: 0 auto; color: white;">
            Enera Intelligence
        </h3>
    </div>
</footer>

</body>
</html>