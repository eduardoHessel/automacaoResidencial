<?php
//session_start();
if ($_SESSION['acesso'] != 'admin') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:index.php');
}
include_once '../class/Equipamento.php';
$e = new Equipamento();
include_once '../class/Camera.php';
$c = new Camera();

$idEquipamento = filter_input(INPUT_GET, 'idEquipamento');

$e->setIdEquipamento($idEquipamento);
$c->setIdEquipamento($idEquipamento);

echo '<section class="content">'
 . '<div class="box">'
 . '<div class="alert alert-success" role="alert" style="margin-right:3%;margin-left:3%;">'
 . '<h3>'
 . $e->excluir()
 . '</h3>'
 . '</div>'
 . '</div>'
 . '</section>';
 $c->excluir();
?>
<meta http-equiv="refresh" content="1;URL='?p=equipamento/consultar'" />

