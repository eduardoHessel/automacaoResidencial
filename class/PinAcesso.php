<?php

class PinAcesso {

    private $pin;
    private $id_casa;

    function getPin() {
        return $this->pin;
    }

    function getId_casa() {
        return $this->id_casa;
    }

    function setPin($pin) {
        $this->pin = $pin;
    }

    function setId_casa($id_casa) {
        $this->id_casa = $id_casa;
    }

    function excluir() {
        try {
            $this->con = new Conectar();
            $this->ct = new Controles();

            $sql = "DELETE FROM pincadastro WHERE pin = ?";
            $ligacao = $this->con->prepare($sql);
            $ligacao->bindValue(1, $this->getPin(), PDO::PARAM_INT);
            if ($ligacao->execute() == 1) {
                return "Pin excluído com sucesso.";
            } else {
                return "Erro ao excluir pin.";
            }
        } catch (PDOException $exc) {
            echo $exc->getMessage();
        }
    }

}
