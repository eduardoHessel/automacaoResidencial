<?php
if ($_SESSION['acesso'] != 'admin') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:index.php');
}
include_once '../class/AcessoEntrada.php';
$ae = new AcessoEntrada();
$id = filter_input(INPUT_GET, 'id');
echo '<section class="content">'
 . '<div class="box">'
 . '<div class="alert alert-success" role="alert" style="margin-right:3%;margin-left:3%;">'
 . '<h3>'
 . $ae->excluir($id)
 . '</h3>'
 . '</div>'
 . '</div>'
 . '</section>';
?>

<meta http-equiv="refresh" content="1;URL='?p=acessoEntrada/consultar'"/>

