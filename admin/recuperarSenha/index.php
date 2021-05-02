<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Recuperar senha - Will Domus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/login.css" rel="stylesheet">
        <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='../../css/opensans.css' rel='stylesheet' type='text/css'>
        <link href='../../css/merriweather.css' rel='stylesheet' type='text/css'>
        <link rel="icon" href="../../imagem/icone.ico" type="image/x-icon" />
        <script src="../../js/jquery.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="card card-container" style="margin-top: 10%">
                <form class="form-signin" method="post">
                    <span id="reauth-email" class="reauth-email"></span>
                    <h1 class="form-signin-heading">Recuperar Senha</h1>
                    <input type="email" id="txtemail" class="form-control" placeholder="E-mail de recuperação" required autofocus name="txtemail">
                    <br>
                    <input class="btn btn-lg btn-primary btn-block btn-signin" style="width: 50%;height: 55px; margin-left: 62px;font-size: 115%" type="submit" value="ENVIAR" name="btnacessar">
                </form><!-- /form 
                -->
            </div><!-- /card-container -->
        </div><!-- /container -->
    </body>
</html>


<?php
if (filter_input(INPUT_POST, 'btnacessar')) {
    //recebendo dados do form
    $email = filter_input(INPUT_POST, 'txtemail', FILTER_SANITIZE_STRING);

    include_once '../../class/Email.php';
    $e = new Email();
    $e->setEmail($email);
    echo '<div class="box">'
    . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%" role="alert">'
    . '<h3>'
    . $e->enviarEmail()
    . '</h3>'
    . '</div>'
    . '</div>';
    echo '<meta http-equiv="refresh" content="2; url=../index.php"/>';
}