<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
</head>
<body style="margin:0;">
<header style="background-color: #00BFFF; padding: 20px; ">
    <div style="display: inline-block">
        <img src="{{asset('img/logo_enera.png')}}" alt="Enera">
    </div>
    <div style="width: 40%; display: inline-block;"></div>
    <div style="display: inline-block;">
        <h1 style="margin: 0 auto; color: white;">Issues Traker</h1>
    </div>
</header>

<main style="padding: 0 50px;">
    <p>
        <font size="9" color="#696969">
            New exception in Enera {{ $issue->issue['platform'] }}
        </font>
    </p>
    <br>
    <p>
        <font size="4" color="#000000">
            {{ $issue->issue['title'] }}
        </font>
        <font size="4" color="#696969">
            - {{ $issue->issue['file']['path'] }}:{{ $issue->issue['file']['line'] }}
        </font>
    </p>
    <p>
        <font size="3" color="#696969">
            {{ $issue->exception['msg'] }}
        </font>
    </p>
    <br>
    <p style="margin:0 0 2px 0;"><font size="4" color="#000000" >STAGE</font></p>
    <p style="margin:0 0 10px 0;"><font size="3" color="#696969" >production</font></p>
    <p style="margin:0 0 2px 0;"><font size="4" color="#000000" >SEVERITY</font></p>
    <p style="margin:0 0 10px 0;"><font size="3" color="#696969" >error</font></p>
    <p style="margin:0 0 2px 0;"><font size="4" color="#000000" >Host</font></p>
    <p style="margin:0 0 10px 0;"><font size="3" color="#696969" >Server 1</font></p>
    <br>
    <p><font size="9" color="#696969">Stacktrace summary</font></p>
    <p style="border: solid #696969 1px; background-color: #f0f0f0; padding:5px 20px; margin:0;">
        app/Jobs/FbLikesJob.php:55 · [main]</p>
    <p style="border: solid #696969 1px; background-color: #f0f0f0; padding:5px 20px; margin:0;">
        app/Jobs/FbLikesJob.php:55 · [main]</p>
</main>

</body>
</html>