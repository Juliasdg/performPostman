<?php
namespace App\Model;

class Cliente {
    public $cliente_id;
    public $nome;
    public $email;
    public $cidade;
    public $estado;

    public function __construct($nome, $email, $cidade, $estado) {
        $this->nome = $nome;
        $this->email = $email;
        $this->cidade = $cidade;
        $this->estado = $estado;
    }
}

