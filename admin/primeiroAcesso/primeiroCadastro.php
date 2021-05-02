<?php
session_start();
$ok = 's';
include_once '../../class/Usuario.php';
$e = new Usuario();
$nome = "";
$id_casa = $_SESSION['id_casa'];
if ($_SESSION['acesso'] != 'cadastro') {
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

        <title>Will Domus - Admin</title>

        <!-- Bootstrap core CSS-->
        <link href="../../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom fonts for this template-->
        <link href="../../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Page level plugin CSS-->
        <link href="../../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

        <!-- Custom styles for this template-->
        <link href="../../css/sb-admin.css" rel="stylesheet">
        <link rel="icon" href="../../imagem/icone.ico" type="image/x-icon" />

        <link href="../../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
        <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic,900,900italic' rel='stylesheet' type='text/css'>

    </head>

    <body id="page-top">
        <nav class="navbar navbar-expand navbar-dark bg-dark static-top" style=" font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;">

            <a class="navbar-brand mr-1" style="color: white; font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif; font-weight: 670;">WILL DOMUS</a>

            <!-- Navbar Search -->
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
                    function emailExistente() {
                        var resposta = alert("E-mail já existente! Favor inserir outro!");
                    }
                </script>
                <div class="container">
                    <div class="card card-register mx-auto mt-5 small">
                        <div class="card-header">Cadastro de Usuário</div>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <input type="text" autofocus="" class="form-control"  id="txtnome"name="txtnome" placeholder="Nome do Usuário"
                                                       value="<?php
                                                       if (isset($_SESSION['nome'])) {
                                                           echo $_SESSION['nome'];
                                                       } else if (isset($nome)) {
                                                           echo $nome;
                                                       }
                                                       ?>" required="">
                                                <label for="txtnome">Nome do Usuário</label>
                                            </div>
                                        </div>                      
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="form-label-group">
                                        <input type="email" id="txtemail" class="form-control" name="txtemail" placeholder="E-mail do Usuário"
                                               value="<?php
                                               if (isset($_SESSION['email'])) {
                                                   echo $_SESSION['email'];
                                               } else if (isset($email)) {
                                                   echo $email;
                                               }
                                               ?>" required="">
                                        <label for="txtemail">E-mail do Usuário</label>
                                    </div>
                                </div>
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
                                <div class="form-group">
                                    <div class="form-row">
                                        <div class="col-md-12">
                                            <div class="form-label-group">
                                                <input data-mask="000000" type="text" autofocus="" class="form-control"  id="txtpin" name="txtpin" placeholder="Pin de Restrição"
                                                       value="<?php
                                                       if (isset($_SESSION['pinRestricao'])) {
                                                           echo $_SESSION['pinRestricao'];
                                                       } else if (isset($pinRestricao)) {
                                                           echo $pinRestricao;
                                                       }
                                                       ?>" required="" minlength="6" maxlength="6">
                                                <label for="txtpin">Pin de Restrição</label>
                                            </div>
                                        </div>                      
                                    </div>
                                </div>
                                <div class="box-footer clearfix" style="text-align: right;">
                                    <input type="submit" class="pull-right btn btn-primary btn-sm" id="btnsalvar" name="btnsalvar" value="Adicionar">
                                    <a class="pull-right btn btn-danger btn-sm"style="margin-right: 1%;" href="../../">Voltar</a>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
                <?php
                $nome = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
                $senha = filter_input(INPUT_POST, 'txtsenha', FILTER_SANITIZE_STRING);
                $consenha = filter_input(INPUT_POST, 'txtconsenha', FILTER_SANITIZE_STRING);
                $email = filter_input(INPUT_POST, 'txtemail', FILTER_SANITIZE_STRING);
                $tipo = filter_input(INPUT_POST, 'txttipo', FILTER_SANITIZE_STRING);
                $pinRestricao = filter_input(INPUT_POST, 'txtpin', FILTER_SANITIZE_STRING);

                $_SESSION['nome'] = $nome;
                $_SESSION['email'] = $email;
                $_SESSION['tipo'] = $tipo;
                $_SESSION['senha'] = $senha;
                $_SESSION['consenha'] = $consenha;
                $_SESSION['pinRestricao'] = $pinRestricao;

                if (filter_input(INPUT_POST, 'btnsalvar')) {
                    include_once '../../class/Conectar.php';
                    $con = new Conectar();
                    $sql = "SELECT * FROM usuario WHERE email = ?";
                    $ligacao = $con->prepare($sql);
                    $ligacao->bindValue(1, $email, PDO::PARAM_STR);
                    $ligacao->execute();

                    //verifica email
                    if ($ligacao->rowCount() > 0) {
                        $_SESSION['email'] = "";
                        echo '<meta http-equiv="refresh" content="0;"/>';
                        echo '<script>emailExistente();</script>';
                    } else if ($senha != $consenha) { //verifica senha
                        $_SESSION['senha'] = "";
                        $_SESSION['consenha'] = "";

                        echo '<meta http-equiv="refresh" content="0;"/>';
                        echo '<script>senhaIgual();</script>';
                    } else {
                        include_once '../../class/Usuario.php';
                        $e = new Usuario();

                        $e->setNome($nome);
                        $e->setSenha(sha1($senha));
                        $e->setEmail($email);
                        $e->setTipo_usuario($tipo);
                        $e->setPinRestricao($pinRestricao);
                        $e->setId_casa($id_casa);

                        echo '<div class="box">'
                        . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%" role="alert">'
                        . '<h3>'
                        . $e->salvar()
                        . ' Redirecionando para a tela de Login.'
                        . '</h3>'
                        . '</div>'
                        . '</div>';

                        include_once '../../class/PinAcesso.php';
                        $p = new PinAcesso();
                        $p->setPin($_SESSION['pinAcesso']);
                        $p->excluir();

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

