<?php

include_once 'Conectar.php';
include_once 'Controles.php';

class Email {

    private $email;
    private $subject;
    private $msg;
    private $password;

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getPassword() {
        return $this->password;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function enviarEmail() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT Id FROM usuario where Email = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getEmail(), PDO::PARAM_STR);
            if ($ligacao->execute() == 1) {
                $dados = $ligacao->fetchAll();
                foreach ($dados as $mostrar) {
                    $Id = $mostrar['Id'];
                }
            }
            if ($ligacao->rowCount() > 0) {
                $random_number = intval("0" . rand(1, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9));
                $sql = "INSERT INTO pinrecover VALUES(?,?);";
                $ligacao = $this->con->prepare($sql);
                $ligacao->bindValue(1, $random_number, PDO::PARAM_STR);
                $ligacao->bindValue(2, $Id, PDO::PARAM_STR);
                if ($ligacao->execute() == 1) {
                    $resultado = "Pin cadastrado com sucesso";
                }else{
                    return 'Erro ao enviar senha, tente novamente. Caso o problema persista, entre em contato conosco.';
                }
                $this->msg = "Para recuperar sua conta, entre nesse link e insira a senha abaixo:\n" . "Senha: " . $random_number
                        . "\nLink para inserção: http://tccwd.ddns.net:1234/admin/recuperarSenha/recuperarSenha.php";
                $this->msg = wordwrap($this->msg, 200);

                $this->subject = "Senha para recuperação da conta Will Domus.";

                if (mail($this->getEmail(), $this->subject, $this->msg) == 1) {
                    return "E-mail enviado com sucesso.";
                }
            } else {
                return "E-mail não encontrado. Favor inserir outro E-mail.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

    function verificarPin() {
        try {
            $this->con = new Conectar();
            $sql = "SELECT * FROM pinrecover WHERE password = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getPassword(), PDO::PARAM_INT);
            $ligacao->execute();
            if ($ligacao->rowCount() > 0) {
                return $ligacao->fetchAll();
            } else {
                return 'Não foi encontrado nenhuma senha de recuperação. Tente enviar o e-mail novamente.';
            }
        } catch (PDOException $exc) {
            
        }
    }
      function excluir() {
        try {
            $this->con = new Conectar();
         
            $sql = "DELETE FROM pinrecover WHERE password = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getPassword(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
            } else {
                return "Erro ao excluir senha.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
