<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Login - WillDomus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../../css/bootstrap.css" rel="stylesheet">
        <link href="../../css/login.css" rel="stylesheet">
        <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='../../css/opensans.css' rel='stylesheet' type='text/css'>
        <link rel="icon" href="../../imagem/icone.ico" type="image/x-icon" />
        <link href='../../css/merriweather.css' rel='stylesheet' type='text/css'>
        <script src="../../js/jquery.js"></script>
        <script src="../../js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="container">
            <div class="card card-container" style="margin-top: 10%">
                <form class="form-signin" method="post">
                    <span id="reauth-email" class="reauth-email"></span>
                    <h1 class="form-signin-heading text-muted">Primeiro Acesso</h1>
                    <input type="text" id="inputText" class="form-control" placeholder="PIN de Acesso" required autofocus name="txtpin" minlength="6" maxlength="6">
                    <br>
                    <input class="btn btn-lg btn-primary btn-block btn-signin" style="width: 50%;height: 55px; margin-left: 62px;font-size: 115%;font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;" type="submit" value="CADASTRAR" name="btnacessar">

                </form><!-- /form 
                -->
            </div><!-- /card-container -->
        </div><!-- /container -->
    </body>
</html>


<?php
if (filter_input(INPUT_POST, 'btnacessar')) {
    //recebendo dados do form
    $pin = filter_input(INPUT_POST, 'txtpin', FILTER_SANITIZE_STRING);

    //acesso a table no MySQL
    include_once '../../class/Conectar.php';
    $con = new Conectar();
    $sql = "SELECT pin, id_casa FROM pincadastro WHERE pin = ?";
    $ligacao = $con->prepare($sql);
    $ligacao->bindValue(1, $pin, PDO::PARAM_INT);
    if ($ligacao->execute() == 1) {
        $dados = $ligacao->fetchAll();
        foreach ($dados as $mostrar) {
            $pinAcesso = $mostrar['pin'];
            $id_casa = $mostrar['id_casa'];
        }
    }
    //comparar dados
    if ($ligacao->rowCount() > 0) {
        //session_name();
        session_start();
        $_SESSION['acesso'] = "cadastro";
        $_SESSION['pinAcesso'] = $pinAcesso;
        $_SESSION['id_casa'] = $id_casa;
        //redireciona página
        header("location:primeiroCadastro.php");
    } else {
        echo '<div class="container">'
        . '<div class="alert alert-warning" role="alert">'
        . '<h3>Este PIN de acesso não existe!</h3>'
        . '<p>Para mais informações entre em contato conosco!</p>'
        . '</div>'
        . '</div>';
    }
}