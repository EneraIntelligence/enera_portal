<!DOCTYPE html>
<html>
<head>
    <title>Enera Intelligence - Portal</title>

    <link href="//fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">

    <style>
        html, body {
            height: 100%;
        }

        body {
            margin: 0;
            padding: 0;
            width: 100%;
            color: #B0BEC5;
            display: table;
            font-weight: 100;
            font-family: 'Lato';
        }

        .container {
            text-align: center;
            display: table-cell;
            vertical-align: middle;
        }

        .content {
            text-align: center;
            display: inline-block;
        }

        .title {
            font-size: 72px;
            margin-bottom: 40px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="content">
        <div class="title">
            <div>
                <img style="width:450px" src="{!! asset('img/enera_logo.png') !!}" alt="">
            </div>
            El documento no fue encontrado
            <div id="url"></div>
        </div>
    </div>
</div>

<script>
    var id = document.getElementById("id");
    id.append(window.location.href);
</script>

</body>
</html>
