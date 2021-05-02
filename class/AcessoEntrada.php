<?php

include_once 'Conectar.php';
include_once 'Controles.php';

class acessoEntrada {

    private $idAcesso;
    private $SenhaAcesso;
    private $RadioFrequencia;
    private $IdRfid;
    private $id_casa;

    function getIdAcesso() {
        return $this->idAcesso;
    }

    function getSenhaAcesso() {
        return $this->SenhaAcesso;
    }

    function getRadioFrequencia() {
        return $this->RadioFrequencia;
    }

    function getIdRfid() {
        return $this->IdRfid;
    }

    function getId_casa() {
        return $this->id_casa;
    }

    function setIdAcesso($idAcesso) {
        $this->idAcesso = $idAcesso;
    }

    function setSenhaAcesso($SenhaAcesso) {
        $this->SenhaAcesso = $SenhaAcesso;
    }

    function setRadioFrequencia($RadioFrequencia) {
        $this->RadioFrequencia = $RadioFrequencia;
    }

    function setIdRfid($IdRfid) {
        $this->IdRfid = $IdRfid;
    }

    function setId_casa($id_casa) {
        $this->id_casa = $id_casa;
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO acessoentrada VALUES (null,?,null,null,?)";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getSenhaAcesso(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $this->getId_casa(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Acesso à entrada concedido com sucesso.";
            } else {
                return "Erro ao conceder entrada.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultar($id, $id_casa) {
        try {
            $this->con = new Conectar();
            if ($id == "") {
                $sql = "SELECT * FROM acessoentrada where id_casa = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $id_casa, PDO::PARAM_INT);
            } else if ($id != "" || $id != NULL) {
                $sql = "SELECT * FROM acessoentrada where Id_Acesso = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $id, PDO::PARAM_INT);
            }
            if ($ligacao->execute() == 1) {
                return $ligacao->fetchAll();
            } else {
                return "Erro ao consultar acesso à entrada.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function excluir($id) {
        try {
            $this->con = new Conectar();
            $this->ct = new Controles();

            $sql = "DELETE FROM acessoentrada WHERE Id_Acesso = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $id, PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Acesso à entrada excluído com sucesso.";
            } else {
                return "Erro ao excluir acesso à entrada.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarDados() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE acessoentrada SET SenhaAcesso = ? where Id_Acesso = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getSenhaAcesso(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $this->getIdAcesso(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Acesso à entrada alterado com sucesso.";
            } else {
                return "Erro ao alterar acesso à entrada.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
