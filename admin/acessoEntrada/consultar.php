<?php
unset($_SESSION['senhaAcesso']);
unset($_SESSION['radioFreq']);
unset($_SESSION['rfid']);
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
            window.location.href = "?p=acessoEntrada/excluir&id=" + id;
        }
    }
</script>


<div class="card mb-3" style="margin-right: 3%;margin-left: 3%;">
    <div class="card-header">
        <i class="fas fa-table"></i>
        Consultar acesso à entrada</div>
    <div class="card-body">
        <div class="table-responsive small">
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Senha de Acesso</th>
                        <th class="text-center">Opções</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Senha de Acesso</th>
                        <th class="text-center">Opções</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    include_once '../class/AcessoEntrada.php';
                    $ae = new AcessoEntrada();

                    $dados = $ae->consultar(null, $id_casa);
                    foreach ($dados as $mostrar) {
                        ?>
                        <tr>
                            <td><?php echo $mostrar['SenhaAcesso']; ?></td>
                            <td class="text-center"><a class='btn btn-info btn-sm btn-info' style="margin-top: 1%; margin-bottom: 1%" href="?p=acessoEntrada/salvar&idAcesso=<?php echo $mostrar['Id_Acesso']; ?>">Editar</a> 
                                <a href="javascript:func()" style="margin-top: 1%; margin-bottom: 1%" onclick="confirmar(<?php echo $mostrar['Id_Acesso']; ?>)" class="btn btn-danger btn-xs btn-sm">Apagar</a>
                            </td>
                        </tr>  
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <a class="pull-right btn btn-primary btn-sm" style="margin-top: 2%" href="?p=acessoEntrada/salvar">Conceder acesso à entrada</a>
        </div>
    </div>
</div>

