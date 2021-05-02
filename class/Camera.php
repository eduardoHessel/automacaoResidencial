<?php

class Camera {

    private $IP;
    private $idEquipamento;

    function getIP() {
        return $this->IP;
    }

    function getIdEquipamento() {
        return $this->idEquipamento;
    }

    function setIP($IP) {
        $this->IP = $IP;
    }

    function setIdEquipamento($idEquipamento) {
        $this->idEquipamento = $idEquipamento;
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "insert into camera values(null,?,?)";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getIP(), PDO::PARAM_INT);
            $ligacao->bindValue(2, $this->getIdEquipamento(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                $this->ct = new Controles();
                return "Câmera cadastrada com sucesso.";
            } else {
                return "Erro ao cadastrar câmera.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultar($idEquipamento, $id_casa) {
        try {
            $this->con = new Conectar();
            if ($idEquipamento == "") {
                $sql = "SELECT * FROM camera where id_casa = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $id_casa, PDO::PARAM_INT);
            } else if ($idEquipamento != "" || $idEquipamento != NULL) {
                $sql = "SELECT * FROM camera where Id_Equipamento = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $idEquipamento, PDO::PARAM_INT);
            }
            if ($ligacao->execute() == 1) {
                return $ligacao->fetchAll();
            } else {
                return "Erro ao consultar câmera.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function excluir() {
        try {
            $this->con = new Conectar();
            $this->ct = new Controles();

            $sql = "DELETE FROM camera WHERE Id_Equipamento = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getIdEquipamento(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Câmera excluído com sucesso.";
            } else {
                return "Erro ao excluir câmera.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarDados() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE camera SET IP = ? where Id_Equipamento = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getIP(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $this->getIdEquipamento(), PDO::PARAM_STR);
            if ($ligacao->execute() == 1) {
                return "Câmera editada com sucesso.";
            } else {
                return "Erro ao editar câmera.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function verificarIP($ipCons, $id_casa) {
        if ($this->getIP() != $ipCons) {
            include_once '../class/Conectar.php';
            $con = new Conectar();
            $sql = "SELECT * FROM camera c, equipamento e WHERE c.IP = ? && e.id_casa = ? && c.Id_Equipamento = e.Id_Equipamento";
            $ligacao = $con->prepare($sql);
            $ligacao->bindValue(1, $this->getIP(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $id_casa, PDO::PARAM_STR);
            $ligacao->execute();
            if ($ligacao->rowCount() > 0) {
                return "existe";
            } else {
                return "nãoexiste";
            }
        }
    }

    function visualizarCam($id_casa) {
        include_once '../class/Conectar.php';
        $con = new Conectar();
        $sql = "SELECT IP, Nome, NomeComodo FROM camera c, equipamento e WHERE e.id_casa = ? && c.Id_Equipamento = e.Id_Equipamento";
        $ligacao = $con->prepare($sql);
        $ligacao->bindValue(1, $id_casa, PDO::PARAM_STR);
        $ligacao->execute();
        if ($ligacao->execute() == 1) {
            return $ligacao->fetchAll();
        } else {
            return "Erro ao consultar câmera";
        }
    }

    function verificarIPNS($id_casa) {
        include_once '../class/Conectar.php';
        $con = new Conectar();
        $sql = "SELECT * FROM camera c, equipamento e WHERE c.IP = ? && e.id_casa = ? && c.Id_Equipamento = e.Id_Equipamento";
        $ligacao = $con->prepare($sql);
        $ligacao->bindValue(1, $this->getIP(), PDO::PARAM_STR);
        $ligacao->bindValue(2, $id_casa, PDO::PARAM_STR);
        $ligacao->execute();
        if ($ligacao->rowCount() > 0) {
            return 'existe';
        }
    }

}
