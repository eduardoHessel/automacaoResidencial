<?php
//session_start();
$id_casa = $_SESSION['id_casa'];
unset($_SESSION['nomeEq']);
unset($_SESSION['descricao']);
unset($_SESSION['nomeComodo']);
unset($_SESSION['tipoEquipamento']);
unset($_SESSION['isBlocked']);
unset($_SESSION['valor']);
unset($_SESSION['ip']);

if ($_SESSION['acesso'] != 'admin') {
    session_destroy();
    unset($_SESSION['acesso']);
    header('location:index.php');
}
?>
<script type="text/javascript">
    function confirmar(idEquipamento) {
        var resposta = confirm("Deseja excluir?");
        //se a resposta for SIM
        if (resposta) {
            window.location.href = "?p=equipamento/excluir&idEquipamento=" + idEquipamento;
        }
    }
</script>


<div class="card mb-3" style="margin-right: 3%;margin-left: 3%;">
    <div class="card-header">
        <i class="fas fa-table"></i>
        Consulta de Equipamentos</div>
    <div class="card-body">
        <div class="table-responsive small">
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Nome do Cômodo</th>
                        <th>Tipo de Equipamento</th>
                        <th>Bloqueado</th>
                        <th class="text-center">Opções</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Nome do Cômodo</th>
                        <th>Tipo de Equipamento</th>
                        <th>Bloqueado</th>
                        <th class="text-center">Opções</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    include_once '../class/Equipamento.php';
                    $e = new Equipamento();
                    include_once '../class/Camera.php';
                    $c = new Camera();

                    $dados = $e->consultar(null, $id_casa);
                    foreach ($dados as $mostrar) {
                        ?>
                        <tr>
                            <td><?php echo $mostrar['Nome']; ?></td>
                            <td><?php echo $mostrar['Descricao']; ?></td>
                            <td><?php echo $mostrar['NomeComodo']; ?></td>
                            <td><?php
                                if ($mostrar['TipoEquipamento'] == "1") {
                                    echo 'Televisão';
                                } else if ($mostrar['TipoEquipamento'] == "2") {
                                    echo 'Ar-condicionado';
                                } else if ($mostrar['TipoEquipamento'] == "3") {
                                    $dados = $c->consultar($mostrar['Id_Equipamento'], $id_casa);
                                    foreach ($dados as $mostrarCamera) {
                                        echo 'Câmera - IP: ' . $mostrarCamera['IP'];
                                    }
                                }
                                ?></td>
                            <td><?php
                                if ($mostrar['isBlocked'] == "1") {
                                    echo 'Sim';
                                } else if ($mostrar['isBlocked'] == "0") {
                                    echo 'Não';
                                }
                                ?></td>
                            <td class="text-center"><a class='btn btn-info btn-sm btn-info' style="margin-top: 1%; margin-bottom: 1%" href="?p=equipamento/salvar&idEquipamento=<?php echo $mostrar['Id_Equipamento']; ?>">Editar</a> 
                                <a href="javascript:func()" style="margin-top: 1%; margin-bottom: 1%" onclick="confirmar(<?php echo $mostrar['Id_Equipamento']; ?>)" class="btn btn-danger btn-xs btn-sm">Apagar</a></td>
                        </tr>  
                        <?php
                    }
                    ?>
                </tbody>
            </table>
            <a class="pull-right btn btn-primary btn-sm" style="margin-top: 2%" href="?p=equipamento/salvar">Cadastrar novo equipamento</a>
        </div>
    </div>
</div>

