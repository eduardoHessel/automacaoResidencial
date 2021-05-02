<?php
session_start();
$Id = $_SESSION['Id'];
if ($_SESSION['acesso'] != 'recuperar') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:../index.php');
}
?>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Editar Senha - Will Domus</title>

        <!-- Bootstrap core CSS-->
        <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template-->
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="../../imagem/icone.ico" type="image/x-icon" />

        <!-- Page level plugin CSS-->
        <link href="../../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="../../css/sb-admin.css" rel="stylesheet">

        <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    </head>

    <body id="page-top">
        <nav class="navbar navbar-expand navbar-dark bg-dark static-top" style=" font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;">

            <a class="navbar-brand mr-1" style="color: white; font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif; font-weight: 670;">WILL DOMUS</a>

            <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <div class="input-group">

                </div>
            </form>
        </nav> 

        <div id="wrapper">
            <div id="content-wrapper">
                <script type="text/javascript">
                    function senhaIgual() {
                        var resposta = confirm("As senhas devem ser iguais!");

                        if (resposta) {
                            this.document.getElementById("txtemail").focus();
                        }
                    }

                </script>
                <div class="container">
                    <div class="card card-register mx-auto mt-5 small">
                        <div class="card-header">Editar senha perdida</div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <div class="form-label-group">
                                                <input id="txtsenha" type="password" minlength="8" maxlength="100" class="form-control" name="txtsenha" placeholder="Senha do Usuário"
                                                       value="<?php
                                                       if (isset($_SESSION['senha'])) {
                                                           echo $_SESSION['senha'];
                                                       }
                                                       ?>" required="">
                                                <label for="txtsenha">Senha do Usuário</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-label-group">
                                                <input id="txtconsenha" minlength="8" maxlength="100" type="password" class="form-control" name="txtconsenha" placeholder="Confirmar Senha"
                                                       value="<?php
                                                       if (isset($_SESSION['consenha'])) {
                                                           echo $_SESSION['consenha'];
                                                       }
                                                       ?>" required="">
                                                <label for="txtconsenha">Confirmar Senha</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer clearfix" style="text-align: right;">
                                    <input type="submit" class="pull-right btn btn-primary btn-sm" id="btnsalvar" name="btnsalvar" value="Adicionar">
                                    <a class="pull-right btn btn-danger btn-sm" href="../../index.php" style="margin-right: 1%;">Cancelar</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <?php
                $senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);
                $consenha = filter_input(INPUT_POST, 'txtconsenha', FILTER_SANITIZE_STRING);

                $_SESSION['senha'] = $senha;
                $_SESSION['consenha'] = $consenha;

                if (filter_input(INPUT_POST, 'btnsalvar')) {
                    if ($senha != $consenha) { //verifica senha
                        $_SESSION['senha'] = "";
                        $_SESSION['consenha'] = "";

                        echo '<meta http-equiv="refresh" content="0;"/>';
                        echo '<script>senhaIgual()</script>';
                    } else {
                        include_once '../../class/Usuario.php';
                        $u = new Usuario();
                        
                        $u->setSenha(sha1($senha));
                        $u->setId($Id);
                        echo '<div class="box">'
                        . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%" role="alert">'
                        . '<h3>'
                        . $u->editarSenha()
                        . ' Redirecionando para a tela de Login.'
                        . '</h3>'
                        . '</div>'
                        . '</div>';

                        include_once '../../class/Email.php';
                        $e = new Email();
                        $e->setPassword($_SESSION['password']);
                        $e->excluir();

                        $_SESSION = array();
                        session_destroy();
                        echo '<meta http-equiv="refresh" content="3; url=../index.php"/>';
                    }
                }
                ?>
                <!--/.container-fluid -->
            </div>
            <!--/.content-wrapper -->
        </div>
        <!--/#wrapper -->

        <!--Bootstrap core JavaScript-->
        <script src = "../../vendor/jquery/jquery.min.js"></script>
        <script src="../../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="../../vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="../../js/sb-admin.js"></script>

        <script src="../../js/jquery.js"</script>
    </body>
</html>

