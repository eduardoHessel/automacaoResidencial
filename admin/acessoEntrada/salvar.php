<?php
$id_casa = $_SESSION['id_casa'];
if ($_SESSION['acesso'] != 'admin') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:index.php');
}
$ok = 's';
include_once '../class/AcessoEntrada.php';
$ae = new AcessoEntrada();

if (filter_input(INPUT_GET, 'idAcesso')) {
    $ok = 'e';
    $idAcesso = filter_input(INPUT_GET, 'idAcesso', FILTER_SANITIZE_STRING);
    $dados = $ae->consultar($idAcesso, $id_casa);
    foreach ($dados as $mostrar) {
        $senhaAcesso = $mostrar['SenhaAcesso'];
        $radioFreq = $mostrar['RadioFrequencia'];
        $rfid = $mostrar['IdRfid'];
    }
}
?>

<script type="text/javascript">
    function ipExistente() {
        alert("IP já cadastrado! Favor inserir outro!");
    }
</script>

<div class="container">
    <div class="card card-register mx-auto mt-5 small">
        <div class="card-header">Conceder acesso à entrada</div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-label-group">
                                <input type="text" data-mask="0000" maxlength="4" minlength="4" class="form-control" required autofocus="" id="txtsenhaacesso" name="txtsenhaacesso" placeholder="Senha para Acesso"
                                       value="<?php
                                       if (isset($_SESSION['senhaAcesso'])) {
                                           echo $_SESSION['senhaAcesso'];
                                       } else if (isset($senhaAcesso)) {
                                           echo $senhaAcesso;
                                       }
                                       ?>" required="">
                                <label for="txtsenhaacesso">Senha para Acesso</label>
                            </div>
                        </div>                      
                    </div>
                </div>
                <div class="box-footer clearfix" style="text-align: right;">
                    <input type="submit" class="pull-right btn btn-primary btn-sm" id="btnsalvar" name="btnsalvar" value="Adicionar">
                    <a class="pull-right btn btn-danger btn-sm" href="?p=acessoEntrada/consultar" style="margin-right: 1%;">Voltar</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
$senhaAcesso = filter_input(INPUT_POST, 'txtsenhaacesso', FILTER_SANITIZE_STRING);
$_SESSION['senhaAcesso'] = $senhaAcesso;

if (filter_input(INPUT_POST, 'btnsalvar')) {
    include_once '../class/AcessoEntrada.php';
    $ae = new AcessoEntrada();

    if ($ok == 's') {
        $ae->setSenhaAcesso($senhaAcesso);
        $ae->setId_casa($id_casa);

        echo '<div class="box">'
        . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%" role="alert">'
        . '<h3>'
        . $ae->salvar()
        . '</h3>'
        . '</div>'
        . '</div>';
        echo '<meta http-equiv="refresh" content="2; url=?p=acessoEntrada/consultar"/>';
    } else if ($ok == 'e') {

        $ae->setSenhaAcesso($senhaAcesso);
        $ae->setId_casa($id_casa);
        $ae->setIdAcesso(filter_input(INPUT_GET, 'idAcesso'));

        echo '<div class="box">'
        . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%;" role="alert">'
        . '<h3>'
        . $ae->editarDados()
        . '</h3>'
        . '</div>'
        . '</div>';
        echo '<meta http-equiv="refresh" content="1; url=?p=acessoEntrada/consultar"/>';
    }
}





    