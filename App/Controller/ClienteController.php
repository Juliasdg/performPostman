<?php
namespace App\Controller;

use App\Database\Database;

require_once 'Database/ClienteRepository.php';

class ClienteController {
    private $repository;

    public function __construct($conn) {
        $this->repository = new ClienteRepository($conn);
    }

    public function criarCliente($data) {
        
        if (!isset($data['nome']) || !isset($data['email']) || !isset($data['cidade']) || !isset($data['estado'])) {
            return "Erro: Todos os campos são obrigatórios.";
        }

        $cliente = new Cliente($data['nome'], $data['email'], $data['cidade'], $data['estado']);

        
        return $this->repository->criarCliente($cliente);
    }

    public function lerTodosClientes() {
        
        return $this->repository->lerTodosClientes();
    }

    public function lerClientePorId($cliente_id) {
        
        return $this->repository->lerClientePorId($cliente_id);
    }

    public function alterarCliente($cliente_id, $data) {
       
        if (!isset($data['nome']) || !isset($data['email']) || !isset($data['cidade']) || !isset($data['estado'])) {
            return "Erro: Todos os campos são obrigatórios.";
        }

        
        $cliente = new Cliente($data['nome'], $data['email'], $data['cidade'], $data['estado']);
        $cliente->cliente_id = $cliente_id;

        
        return $this->repository->alterarCliente($cliente);
    }

    public function deletarCliente($cliente_id) {
        return $this->repository->deletarCliente($cliente_id);
    }
}
