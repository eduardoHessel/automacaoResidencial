<?php

include_once 'Conectar.php';
include_once 'Controles.php';

class Usuario {

    private $id;
    private $nome;
    private $email;
    private $senha;
    private $tipo_usuario;
    private $pinRestricao;
    private $id_casa;
    private $con;
    private $ct;

    function getId() {
        return $this->id;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getSenha() {
        return $this->senha;
    }

    function getTipo_usuario() {
        return $this->tipo_usuario;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setTipo_usuario($tipo_usuario) {
        $this->tipo_usuario = $tipo_usuario;
    }

    function getId_casa() {
        return $this->id_casa;
    }

    function setId_casa($id_casa) {
        $this->id_casa = $id_casa;
    }

    function getPinRestricao() {
        return $this->pinRestricao;
    }

    function setPinRestricao($pinRestricao) {
        $this->pinRestricao = $pinRestricao;
    }

    function salvar() {
        try {
            $this->con = new Conectar();
            $sql = "INSERT INTO usuario VALUES (?,?,?,?,?, null, ?)";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getEmail(), PDO::PARAM_STR);
            $ligacao->bindValue(2, "Administrador", PDO::PARAM_STR);
            $ligacao->bindValue(3, $this->getNome(), PDO::PARAM_STR);
            $ligacao->bindValue(4, $this->getSenha(), PDO::PARAM_STR);
            $ligacao->bindValue(5, $this->getPinRestricao(), PDO::PARAM_STR);
            $ligacao->bindValue(6, $this->getId_casa(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                $this->ct = new Controles();
                return "Usuário cadastrado com sucesso.";
            } else {
                return "Erro ao cadastrar Usuário.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function consultar($id, $id_casa) {
        try {
            $this->con = new Conectar();
            if ($id == "") {
                $sql = "SELECT * FROM usuario where id_casa = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $id_casa, PDO::PARAM_INT);
            } else if ($id != "" || $id != NULL) {
                $sql = "SELECT * FROM usuario where id = ?";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $id, PDO::PARAM_INT);
            }
            if ($ligacao->execute() == 1) {
                return $ligacao->fetchAll();
            } else {
                return "Erro ao consultar usuário.";
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

            $sql = "DELETE FROM usuario WHERE id = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getId(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Usuário excluído com sucesso.";
                /* $this->ct->excluirArquivo("../imagem/eixo/" .
                  $capturar['imagem']); */
            } else {
                return "Erro ao excluir usuário.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarDados() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE usuario SET Nome = ?, Email = ?, Senha = ?, pinRestricao = ? where Id = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getNome(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $this->getEmail(), PDO::PARAM_STR);
            $ligacao->bindValue(3, $this->getSenha(), PDO::PARAM_STR);
            $ligacao->bindValue(4, $this->getPinRestricao(), PDO::PARAM_INT);
            $ligacao->bindValue(5, $this->getId(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Usuário editado com sucesso.";
            } else {
                return "Erro ao editar usuário.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function editarSenha() {
        try {
            $this->con = new Conectar();
            $sql = "UPDATE usuario SET Senha = ? where Id = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getSenha(), PDO::PARAM_STR);
            $ligacao->bindValue(2, $this->getId(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Senha editada com sucesso.";
            } else {
                return "Erro ao editar senha. Tente novamente.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function verificarEmail($emailCon) {
        if ($this->getEmail() != $emailCon) {
            include_once '../class/Conectar.php';
            $this->con = new Conectar();
            $sql = "SELECT * FROM Usuario WHERE Email = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getEmail(), PDO::PARAM_STR);
            $ligacao->execute();
            if ($ligacao->rowCount() > 0) {
                return "existe";
            } else {
                return "nãoexiste";
            }
        }
    }

}
