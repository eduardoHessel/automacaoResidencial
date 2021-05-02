<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <title>Login - WillDomus</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="../css/bootstrap.css" rel="stylesheet">
        <link href="../css/login.css" rel="stylesheet">
        <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='../css/opensans.css' rel='stylesheet' type='text/css'>
        <link href='../css/merriweather.css' rel='stylesheet' type='text/css'>
        <link rel="icon" href="../imagem/icone.ico" type="image/x-icon" />
        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
    </head>

    <body>       
        <div class="container">
            <div class="card card-container" style="margin-top: 10%">
                <form class="form-signin" method="post">
                    <span id="reauth-email" class="reauth-email"></span>
                    <a class="navbar-brand" href="../"><img class="horizontal-align" src="../imagem/logo_app.png" alt="WD"></a>
                    <br>
                    <br>
                    <br>
                    <h1 class="form-signin-heading text-muted" style="font-size: xx-large;"></h1>
                    <input type="email" id="inputText" class="form-control" style="border-bottom-left-radius: 0;
                           border-bottom-right-radius: 0; border-bottom: none;" placeholder="E-mail" required autofocus name="txtemail" maxlength="50">
                    <input type="password" id="inputPassword" class="form-control" placeholder="Senha" required name="txtsenha" maxlength="60">
                    <input class="btn btn-lg btn-primary btn-block btn-signin" style="width: 50%;height: 55px; margin-left: 62px;font-size: 115%" type="submit" value="ENTRAR" name="btnacessar">
                </form>
            </div>
            <div class="card card-container" style="text-align: center;">
                <a style="color:black; font-weight: bold;" href="recuperarSenha/">Esqueceu sua senha?</a>
            </div><!-- /card-container -->
        </div><!-- /container -->
    </body>
</html>


<?php
if (filter_input(INPUT_POST, 'btnacessar')) {
    //recebendo dados do form
    $email = filter_input(INPUT_POST, 'txtemail', FILTER_SANITIZE_STRING);
    $senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);

    //acesso a table no MySQL
    include_once '../class/Conectar.php';
    $con = new Conectar();
    $sql = "SELECT id_casa, Id FROM usuario WHERE email = ?  && senha = ? && tipo_usuario = 'Administrador'";
    $ligacao = $con->prepare($sql);
    $ligacao->bindValue(1, $email, PDO::PARAM_STR);
    $ligacao->bindValue(2, sha1($senha), PDO::PARAM_STR);
    if ($ligacao->execute() == 1) {
        $dados = $ligacao->fetchAll();
        foreach ($dados as $mostrar) {
            $id_casa = $mostrar['id_casa'];
            $idUsuario = $mostrar['Id'];
        }
    }
    //comparar dados
    if ($ligacao->rowCount() > 0) {
        session_start();
        $_SESSION['acesso'] = 'admin';
        $_SESSION['id_casa'] = $id_casa;
        $_SESSION['idUsuario'] = $idUsuario;

        //redireciona página
        header("location:admin.php");
    } else {
        echo '<div class="container">'
        . '<div class="alert alert-warning" role="alert">'
        . '<h3>E-mail e/ou senha incorreto(s)</h3>'
        . '<p>é possível que você não seja um administrador!</p>'
        . '</div>'
        . '</div>';
    }
}

/*  <div id="fullscreen_bg" class="fullscreen_bg"/>
            <div class="container">
                <form class="form-signin">
                    <h1 class="form-signin-heading text-muted">Login</h1>
                    <input type="text" name="txtemail" class="form-control" placeholder="E-mail do Usuário" required="" autofocus="">
                    <input type="password" name="txtsenha" class="form-control" placeholder="Senha do Usuário" required="">
                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="acessar" name="btnacessar">
                </form>
            </div>
        </div>*/