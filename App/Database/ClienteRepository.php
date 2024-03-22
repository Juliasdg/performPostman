<?php
namespace App\Database;
use App\Model\Cliente;

class ClienteRepository {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function criarCliente($cliente) {
        $nome = $cliente->nome;
        $email = $cliente->email;
        $cidade = $cliente->cidade;
        $estado = $cliente->estado;

        $sql = "INSERT INTO clientes (nome, email, cidade, estado) VALUES ('$nome', '$email', '$cidade', '$estado')";

        if ($this->conn->query($sql) === TRUE) {
            return "Novo registro criado com sucesso.";
        } else {
            return "Erro: " . $sql . "<br>" . $this->conn->error;
        }
    }

    public function lerTodosClientes() {
        $sql = "SELECT * FROM clientes";
        $result = $this->conn->query($sql);
        $clientes = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $cliente = new Cliente($row['nome'], $row['email'], $row['cidade'], $row['estado']);
                $cliente->cliente_id = $row['cliente_id'];
                $clientes[] = $cliente;
            }
        }

        return $clientes;
    }

    public function lerClientePorId($cliente_id) {
        $sql = "SELECT * FROM clientes WHERE cliente_id = $cliente_id";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $cliente = new Cliente($row['nome'], $row['email'], $row['cidade'], $row['estado']);
            $cliente->cliente_id = $row['cliente_id'];
            return $cliente;
        } else {
            return null;
        }
    }

    public function alterarCliente($cliente) {
        $cliente_id = $cliente->cliente_id;
        $nome = $cliente->nome;
        $email = $cliente->email;
        $cidade = $cliente->cidade;
        $estado = $cliente->estado;

        $sql = "UPDATE clientes SET nome='$nome', email='$email', cidade='$cidade', estado='$estado' WHERE cliente_id=$cliente_id";

        if ($this->conn->query($sql) === TRUE) {
            return "Registro atualizado com sucesso.";
        } else {
            return "Erro ao atualizar o registro: " . $this->conn->error;
        }
    }

    public function deletarCliente($cliente_id) {
        $sql = "DELETE FROM clientes WHERE cliente_id=$cliente_id";

        if ($this->conn->query($sql) === TRUE) {
            return "Registro deletado com sucesso.";
        } else {
            return "Erro ao deletar o registro: " . $this->conn->error;
        }
    }
}
