<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="">
</head>
<body>

</body>
<div style="text-align: center;">
    <img src="http://enera.mx/images/logo-dark.png" alt="">
</div>
<div>
    <p>Estimado Usuario: {{$user->name['first'] . ' ' . $user->name['last']}}</p>
    <p>Por medio de este medio le informamos que su campaña ha finalizado por motivos de terminacion de fecha </p>
    <p>Atentamente:</p>
    <p>Enera Intelligence</p>

    <p>Este correo se genero de forma automatica, porfavoe de no contestar. Si usted tiene alguna duda mandar un correo a la siguente dirección: "soporte&#64;enera.mx"</p>
</div>
</html>