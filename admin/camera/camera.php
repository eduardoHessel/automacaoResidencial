<?php
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
        <i class="fas fa-camera"></i>
        Visualização de Câmeras</div>
    <div class="card-body">
        <div class="table-responsive small">
            <div class="card-deck">

                <?php
                include_once '../class/Equipamento.php';
                $e = new Equipamento();
                include_once '../class/Camera.php';
                $c = new Camera();
                $dados = $c->visualizarCam($id_casa);
                foreach ($dados as $mostrar) {
                    ?>
                    <div class="card shadow" style="border: none !important; ">
                        <iframe style="border: none !important; " width="640" height="470" class="card-img-top"  src="http:\\<?php echo $mostrar['IP'] ?>:8080/browserfs.html"></iframe>
                        <div class="card-body" style="text-align: center;">
                            <h5 class="card-title"><?php echo $mostrar['Nome']?></h5>
                            <h5 class="card-title"><?php echo $mostrar['NomeComodo']?></h5>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</div>



<!--<iframe style="margin-left: 5%; border: none" width="52.3%" height="75%" src="http:\\192.168.20.11:8080/browserfs.html"></iframe> -->


