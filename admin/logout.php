<?php
session_start();
//varre toda a sessão, buscando seus elementos/variáveis
$_SESSION = array();
//destrói toda a sessão e seus elementos
session_destroy();
//redireciona a página JS
echo "<script language='javaScript'>window.location.href='../index.php'</script>";
