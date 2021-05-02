<?php

include_once 'Conectar.php';
include_once 'Controles.php';

class Equipamento {

    private $idEquipamento;
    private $nome;
    private $descricao;
    private $nomeComodo;
    private $tipoEquipamento;
    private $isBlocked;
    private $id_casa;

    function getIdEquipamento() {
        return $this->idEquipamento;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getNomeComodo() {
        return $this->nomeComodo;
    }

    function getTipoEquipamento() {
        return $this->tipoEquipamento;
    }

    function setIdEquipamento($idEquipamento) {
        $this->idEquipamento = $idEquipamento;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setNomeComodo($nomeComodo) {
        $this->nomeComodo = $nomeComodo;
    }

    function setTipoEquipamento($tipoEquipamento) {
        $this->tipoEquipamento = $tipoEquipamento;
    }

    function getId_casa() {
        return $this->id_casa;
    }

    function setId_casa($id_casa) {
        $this->id_casa = $id_casa;
    }

    function getIsBlocked() {
        return $this->isBlocked;
    }

    function setIsBlocked($isBlocked) {
        $this->isBlocked = $isBlocked;
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "insert into equipamento values(null,?,?,?,?,?,?); select @@identity";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getNome(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $this->getDescricao(), PDO::PARAM_STR);
            $ligacao->bindValue(3, $this->getNomeComodo(), PDO::PARAM_STR);
            $ligacao->bindValue(4, $this->getTipoEquipamento(), PDO::PARAM_INT);
            $ligacao->bindValue(5, $this->getIsBlocked(), PDO::PARAM_INT);
            $ligacao->bindValue(6, $this->getId_casa(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                $this->ct = new Controles();
                $_SESSION['lastId'] = $ligacao->fetchAll();
                return "Equipamento cadastrado com sucesso.";
            } else {
                return "Erro ao cadastrar equipamento.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultar($idEquipamento, $id_casa) {
        try {
            $this->con = new Conectar();
            if ($idEquipamento == "" || $idEquipamento == NULL) {
                $sql = "SELECT * FROM equipamento where id_casa = ? && TipoEquipamento = 1 or TipoEquipamento=2 or TipoEquipamento = 3";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $id_casa, PDO::PARAM_INT);
            } else if ($idEquipamento != "" || $idEquipamento != NULL) {
                $sql = "SELECT * FROM equipamento where Id_Equipamento = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $idEquipamento, PDO::PARAM_INT);
            } else {
                $sql = "select max(Id_Equipamento) from camera c, equipamento e where id_casa = ? && c.Id_Equipamento = e.Id_Equipamento";
                $ligacao->bindValue(1, $id_casa, PDO::PARAM_INT);
                $ligacao = $this->con->prepare($sql);
            }
            if ($ligacao->execute() == 1) {
                return $ligacao->fetchAll();
            } else {
                return "Erro ao consultar equipamento.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function excluir() {
        try {
            $this->con = new Conectar();
            $this->ct = new Controles();

            //$mostrar = $this->consultar($this->getId());

            /* foreach ($mostrar as $capturar) {
              $capturar['imagem'];
              } */

            $sql = "DELETE FROM equipamento WHERE Id_Equipamento = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getIdEquipamento(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Equipamento excluído com sucesso.";
                /* $this->ct->excluirArquivo("../imagem/eixo/" .
                  $capturar['imagem']); */
            } else {
                return "Erro ao excluir equipamento.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarDados() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE equipamento SET Nome = ?, Descricao = ?, NomeComodo = ?, TipoEquipamento = ?, isBlocked = ? where Id_Equipamento = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getNome(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $this->getDescricao(), PDO::PARAM_STR);
            $ligacao->bindValue(3, $this->getNomeComodo(), PDO::PARAM_STR);
            $ligacao->bindValue(4, $this->getTipoEquipamento(), PDO::PARAM_INT);
            $ligacao->bindValue(5, $this->getIsBlocked(), PDO::PARAM_INT);
            $ligacao->bindValue(6, $this->getIdEquipamento(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Equipamento editado com sucesso.";
            } else {
                return "Erro ao editar Equipamento.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
