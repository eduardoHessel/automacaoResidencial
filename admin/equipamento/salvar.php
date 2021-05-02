<?php
$id_casa = $_SESSION['id_casa'];
if ($_SESSION['acesso'] != 'admin') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:index.php');
}
$ok = 's';
include_once '../class/Equipamento.php';
$e = new Equipamento();
include_once '../class/Camera.php';
$c = new Camera();
$tipoEquipamento = null;
$isBlocked = "não";

$_SESSION['tipoEquipamento'] = null;
$_SESSION['isBlocked'] = null;

if (filter_input(INPUT_GET, 'idEquipamento')) {
    $ok = 'e';
    $_SESSION['isBlocked'] = "não";
    $idEquipamento = filter_input(INPUT_GET, 'idEquipamento', FILTER_SANITIZE_STRING);
    $dados = $e->consultar($idEquipamento, $id_casa);
    foreach ($dados as $mostrar) {
        $nomeEq = $mostrar['Nome'];
        $descricao = $mostrar['Descricao'];
        $nomeComodo = $mostrar['NomeComodo'];
        if ($mostrar['TipoEquipamento'] == "1") {
            $tipoEquipamento = 'Televisão';
            $_SESSION['valor'] = "1";
            $valor = 1;
        } else if ($mostrar['TipoEquipamento'] == "2") {
            $tipoEquipamento = 'Ar-condicionado';
            $_SESSION['valor'] = "2";
            $valor = 2;
        } else if ($mostrar['TipoEquipamento'] == "3") {
            $tipoEquipamento = 'Câmera';
            $_SESSION['valor'] = "3";
            $valor = 3;
        }
        if ($mostrar['isBlocked'] == 1) {
            $isBlocked = 'sim';
        } else {
            $isBlocked = 'não';
        }
    }
    $dadosC = $c->consultar($idEquipamento, $id_casa);
    foreach ($dadosC as $mostrar) {
        $ip = $mostrar['IP'];
        $ipCons = $mostrar['IP'];
    }
}
if (isset($_SESSION['valor'])) {
    if ($_SESSION['valor'] == "1") {
        $_SESSION['tipoEquipamento'] = 'Televisão';
    } else if ($_SESSION['valor'] == "2") {
        $_SESSION['tipoEquipamento'] = 'Ar-condicionado';
    } else if ($_SESSION['valor'] == "3") {
        $_SESSION['tipoEquipamento'] = 'Câmera';
    }
}
?>
<script type="text/javascript">
    function mostrar() {
        var select_status = $('#txttipo').val();

        if (select_status == '3') {
            $('#divCamera').show(500);
        } else {
            $('#divCamera').hide(500);
        }
    }
    function mostrarCamera() {
        $('#divCamera').show(500);
    }
    function ipExistente() {
        alert("IP já cadastrado! Favor inserir outro!");
    }
</script>


<div class="container">
    <div class="card card-register mx-auto mt-5 small">
        <div class="card-header">Cadastro de Equipamento</div>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-label-group">
                                <input type="text" class="form-control" required autofocus="" id="txtnome"name="txtnome" placeholder="Nome do Equipamento"
                                       value="<?php
                                       if (isset($_SESSION['nomeEq'])) {
                                           echo $_SESSION['nomeEq'];
                                       } else if (isset($nomeEq)) {
                                           echo $nomeEq;
                                       }
                                       ?>" required="">
                                <label for="txtnome">Nome do Equipamento</label>
                            </div>
                        </div>                      
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <div class="form-group">
                            <textarea class="form-control" type="text" rows="5" id="txtdescricao" name="txtdescricao" placeholder="Descrição do Equipamento"><?php
                                if (isset($_SESSION['descricao'])) {
                                    echo $_SESSION['descricao'];
                                } else if (isset($descricao)) {
                                    echo $descricao;
                                }
                                ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-label-group">
                                <input id="txtnomecomodo" required type="text" class="form-control" name="txtnomecomodo" placeholder="Nome do Cômodo"
                                       value="<?php
                                       if (isset($_SESSION['nomeComodo'])) {
                                           echo $_SESSION['nomeComodo'];
                                       } else if (isset($nomeComodo)) {
                                           echo $nomeComodo;
                                       }
                                       ?>" required="">
                                <label for="txtnomecomodo">Nome do cômodo do equipamento</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <select required="" onchange="mostrar();" id="txttipo" class="form-control" title="Tipo de Equipamento" name="txttipo">
                            <?php
                            if (isset($tipoEquipamento)) {
                                echo '<option hidden="" value="' . $_SESSION['valor'] . '" selected="">'
                                . $tipoEquipamento
                                . '</option>';
                            } else if (isset($_SESSION['tipoEquipamento'])) {
                                echo '<option hidden="" value="' . $_SESSION['valor'] . '" selected="">'
                                . $_SESSION['tipoEquipamento']
                                . '</option>';
                            }
                            ?>
                            <option value="">Insira o tipo de equipamento</option>
                            <option value="1">Televisão</option>
                            <option value="2">Ar-condicionado</option>                           
                            <option value="3">Câmera</option>                           
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label>
                            <input id="chkBlock" name="chkBlock" type="checkbox"  
                            <?php
                            if ($_SESSION['isBlocked'] == "sim" || $isBlocked == "sim") {
                                ?> checked
                                   <?php }
                                   ?>   value="sim">
                            Bloquear este equipamento?
                        </label>
                    </div>
                </div>
                <div id="divCamera" <?php if ($tipoEquipamento == "Câmera" || $_SESSION['tipoEquipamento'] == "Câmera") { ?>
                         style="" required
                     <?php } else { ?>
                         style="display: none" required
                     <?php } ?> class="form-group">
                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-label-group">
                                <input type="text" class="form-control" data-mask="099.099.099.099" maxlength="15" minlength="7" id="txtip" name="txtip"
                                       value="<?php
                                       if (isset($_SESSION['ip'])) {
                                           echo $_SESSION['ip'];
                                       } else if (isset($ip)) {
                                           echo $ip;
                                       }
                                       ?>">
                                <label for="txtip">IP da Câmera</label>
                            </div>
                        </div>                      
                    </div>          
                </div>
                <div class="box-footer clearfix" style="text-align: right;">
                    <input type="submit" class="pull-right btn btn-primary btn-sm" id="btnsalvar" name="btnsalvar" value="Adicionar">
                    <a class="pull-right btn btn-danger btn-sm" href="?p=equipamento/consultar" style="margin-right: 1%;">Voltar</a>
                </div>
            </div>
        </form>
    </div>
</div>

<?php
$nomeEq = filter_input(INPUT_POST, 'txtnome', FILTER_SANITIZE_STRING);
$descricao = filter_input(INPUT_POST, 'txtdescricao', FILTER_SANITIZE_STRING);
$nomeComodo = filter_input(INPUT_POST, 'txtnomecomodo', FILTER_SANITIZE_STRING);
$tipoEquipamento = filter_input(INPUT_POST, 'txttipo', FILTER_SANITIZE_STRING);
$isBlocked = filter_input(INPUT_POST, 'chkBlock', FILTER_SANITIZE_STRING);
$ip = filter_input(INPUT_POST, 'txtip', FILTER_SANITIZE_STRING);

$_SESSION['nomeEq'] = $nomeEq;
$_SESSION['descricao'] = $descricao;
$_SESSION['nomeComodo'] = $nomeComodo;
$_SESSION['isBlocked'] = $isBlocked;
$_SESSION['valor'] = $tipoEquipamento;
$_SESSION['ip'] = $ip;

if (filter_input(INPUT_POST, 'btnsalvar')) {
    include_once '../class/Equipamento.php';
    $e = new Equipamento();

    include_once '../class/Camera.php';
    $c = new Camera();

    if ($ok == 's') {
        $c->setIP($ip);
        if ($c->verificarIPNS($id_casa) == "existe") {
            $_SESSION['ip'] = "";
            echo '<meta http-equiv="refresh" content="0;"/>';
            echo '<script>ipExistente();</script>';
        } else {
            $e->setNome($nomeEq);
            $e->setDescricao($descricao);
            $e->setNomeComodo($nomeComodo);
            $e->setTipoEquipamento($tipoEquipamento);
            if ($isBlocked == "sim") {
                $e->setIsBlocked(1);
            } else {
                $e->setIsBlocked(0);
            }
            $e->setId_casa($id_casa);

            echo '<div class="box">'
            . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%" role="alert">'
            . '<h3>'
            . $e->salvar()
            . '</h3>'
            . '</div>'
            . '</div>';

            if ($tipoEquipamento == "3") {
                $dados = $e->consultar(null, $id_casa);
                foreach ($dados as $mostrar) {
                    $c->setIdEquipamento($mostrar['Id_Equipamento']);
                }
                $c->salvar();
            }
            echo '<meta http-equiv="refresh" content="2; url=?p=equipamento/consultar"/>';
        }
    } else if ($ok == 'e') {
        $c->setIP($ip);
        if ($tipoEquipamento == 3 && $c->verificarIP($ipCons, $id_casa) == "existe") {
            $_SESSION['ip'] = "";
            echo '<meta http-equiv="refresh" content="0;"/>';
            echo '<script>ipExistente();</script>';
        } else {
            if ($tipoEquipamento != 3 && $valor == 3) {
                $c->setIdEquipamento(filter_input(INPUT_GET, 'idEquipamento'));
                $c->excluir();
            } else if ($tipoEquipamento == 3 && $valor != 3) {
                $c->setIP($ip);
                $c->setIdEquipamento($idEquipamento);
                $c->salvar();
            }
            $e->setNome($nomeEq);
            $e->setDescricao($descricao);
            $e->setNomeComodo($nomeComodo);
            $e->setTipoEquipamento($tipoEquipamento);

            if ($isBlocked == "sim") {
                $e->setIsBlocked(1);
            } else {
                $e->setIsBlocked(0);
            }
            $e->setIdEquipamento(filter_input(INPUT_GET, 'idEquipamento'));

            $c->setIP($ip);
            $c->setIdEquipamento(filter_input(INPUT_GET, 'idEquipamento'));
            echo '<div class="box">'
            . '<div class="alert alert-success" style="margin-left:3%;width: 94%; margin-top: 2%;margin-right:3%;" role="alert">'
            . '<h3>'
            . $e->editarDados()
            . '</h3>'
            . '</div>'
            . '</div>';
            $c->editarDados();
            echo '<meta http-equiv="refresh" content="1; url=?p=equipamento/consultar"/>';
        }
    }
}





    