<?php
$ok = 's';
include_once '../class/Usuario.php';
$e = new Usuario();
$nome = "";
$id_casa = $_SESSION['id_casa'];
if ($_SESSION['acesso'] != 'admin') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:index.php');
}
if (filter_input(INPUT_GET, 'id')) {
    $ok = 'e';
    $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
    $dados = $e->consultar($id, $id_casa);
    foreach ($dados as $mostrar) {
        $nome = $mostrar['Nome'];
        $email = $mostrar['Email'];
        $emailCon = $mostrar['Email'];
        $pinRestricao = $mostrar['pinRestricao'];
    }
}
?>
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

    $("#txtpinrestricao").mask("000000");

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
                                <input type="text" autofocus="" data-mask="000000" class="form-control" minlength="6" maxlength="6" id="txtpin" name="txtpin" placeholder="PIN de Restrição"
                                       value="<?php
                                       if (isset($_SESSION['pinRestricao'])) {
                                           echo $_SESSION['pinRestricao'];
                                       } else if (isset($pinRestricao)) {
                                           echo $pinRestricao;
                                       }
                                       ?>" required="">
                                <label for="txtpin">PIN de Restrição</label>
                            </div>
                        </div>                      
                    </div>
                </div>
                <div class="box-footer clearfix" style="text-align: right;">
                    <input type="submit" class="pull-right btn btn-primary btn-sm" id="btnsalvar" name="btnsalvar" value="Adicionar">
                    <a class="pull-right btn btn-danger btn-sm" href="?p=usuario/consultar" style="margin-right: 1%;">Voltar</a>
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
$pinRestricao = filter_input(INPUT_POST, 'txtpin', FILTER_SANITIZE_STRING);

$_SESSION['nome'] = $nome;
$_SESSION['email'] = $email;
$_SESSION['pinRestricao'] = $pinRestricao;
$_SESSION['senha'] = $senha;
$_SESSION['consenha'] = $consenha;

if (filter_input(INPUT_POST, 'btnsalvar')) {
    if ($email != $emailCon) {
        include_once '../class/Conectar.php';
        $con = new Conectar();
        $sql = "SELECT * FROM Usuario WHERE Email = ?";
        $ligacao = $con->prepare($sql);
        $ligacao->bindValue(1, $email, PDO::PARAM_STR);
        $ligacao->execute();
        if ($ligacao->rowCount() > 0) {
            echo '<meta http-equiv="refresh" content="0;"/>';
            echo '<script>emailExistente();</script>';
        }
    } else if ($senha != $consenha) { //verifica senha
        $_SESSION['senha'] = "";
        $_SESSION['consenha'] = "";

        echo '<meta http-equiv="refresh" content="0;"/>';
        echo '<script>senhaIgual();</script>';
    } else {
        include_once '../class/Usuario.php';
        $e = new Usuario();

        $e->setNome($nome);
        $e->setSenha(sha1($senha));
        $e->setEmail($email);
        $e->setPinRestricao($pinRestricao);
        $e->setId(filter_input(INPUT_GET, 'id'));

        echo '<div class="box">'
        . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%;" role="alert">'
        . '<h3>'
        . $e->editarDados()
        . '</h3>'
        . '</div>'
        . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=?p=usuario/consultar"/>';
    }
}



