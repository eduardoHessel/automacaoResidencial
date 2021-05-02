<?php
//session_start();
unset($_SESSION['email']);
unset($_SESSION['nome']);
unset($_SESSION['pinRestricao']);
unset($_SESSION['senha']);
unset($_SESSION['consenha']);
$id_casa = $_SESSION['id_casa'];
if ($_SESSION['acesso'] != 'admin') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:index.php');
}
?>
<script type="text/javascript">
    function confirmar(id) {
        var resposta = confirm("Deseja excluir?");
        //se a resposta for SIM
        if (resposta) {
            window.location.href = "?p=usuario/excluir&id=" + id;
        }
    }
</script>


<div class="card mb-3" style="margin-right: 3%;margin-left: 3%;">
    <div class="card-header">
        <i class="fas fa-table"></i>
        Consultar seu perfil</div>
    <div class="card-body">
        <div class="table-responsive small">
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>PIN de Restrição</th>
                        <th class="text-center">Opções</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>PIN de Restrição</th>
                        <th class="text-center">Opções</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    include_once '../class/Usuario.php';
                    $u = new usuario();

                    $dados = $u->consultar(null, $id_casa);
                    foreach ($dados as $mostrar) {
                        ?>
                        <tr>
                            <td><?php echo $mostrar['Nome']; ?></td>
                            <td><?php echo $mostrar['Email']; ?></td>
                            <td><?php echo $mostrar['pinRestricao']; ?></td>
                            <td class="text-center"><a class='btn btn-sm btn-info' style="margin-top: 1%; margin-bottom: 1%" href="?p=usuario/salvar&id=<?php echo $mostrar['Id']; ?>"><span class="glyphicon glyphicon-edit"></span> Editar</a> 
                            </td>
                        </tr>  
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

