<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Recuperar Acesso - Will Domus</title>
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
                    <h1 class="form-signin-heading text-muted">Insira sua Senha</h1>
                    <input type="text" id="inputText" class="form-control" placeholder="PIN de Recuperação" required autofocus name="txtpin" minlength="6" maxlength="6">
                    <br>
                    <input class="btn btn-lg btn-primary btn-block btn-signin btn-login" type="submit" value="VALIDAR" name="btnacessar">

                </form><!-- /form 
                -->
            </div><!-- /card-container -->
        </div><!-- /container -->
    </body>
</html>


<?php
if (filter_input(INPUT_POST, 'btnacessar')) {
    $password = filter_input(INPUT_POST, 'txtpin', FILTER_SANITIZE_STRING);

    include_once '../../class/Email.php';
    $e = new Email();
    $e->setPassword($password);
    $dados = $e->verificarPin();
    foreach ($dados as $mostrar) {
        $Id = $mostrar['Id'];
        $pin = $mostrar['password'];
    }

    if ($pin != "" || $pin != null) {
        session_start();
        $_SESSION['acesso'] = "recuperar";
        $_SESSION['Id'] = $Id;
        $_SESSION['password'] = $pin;
        //redireciona página
        header("location:editarSenha.php");
    } else {
        echo '<div class="container">'
        . '<div class="alert alert-warning" role="alert">'
        . '<h3>Este PIN de recuperação não existe!</h3>'
        . '<p>Para mais informações entre em contato conosco!</p>'
        . '</div>'
        . '</div>';
    }
}