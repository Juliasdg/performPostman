<?php
namespace App;
require "../vendor/autoload.php";
use App\Model\Cliente;
use App\Database\ClienteRepository;

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}
$data = json_decode(file_get_contents("php://input"));
$conn = new \mysqli("localhost", "root", "", "bancoPerform");


if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Rotas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cliente = new Cliente($data['nome'], $data['email'], $data['cidade'], $data['estado']);
    $repository = new ClienteRepository($conn);
    echo $repository->criarCliente($cliente);
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['cliente_id'])) {
        $cliente_id = $_GET['cliente_id'];
        $repository = new ClienteRepository($conn);
        echo json_encode($repository->lerClientePorId($cliente_id));
    } else {
        $repository = new ClienteRepository($conn);
        echo json_encode($repository->lerTodosClientes());
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cliente = new Cliente($data['nome'], $data['email'], $data['cidade'], $data['estado']);
    $cliente->cliente_id = $data['cliente_id'];
    $repository = new ClienteRepository($conn);
    echo $repository->alterarCliente($cliente);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    $cliente_id = $data['cliente_id'];
    $repository = new ClienteRepository($conn);
    echo $repository->deletarCliente($cliente_id);
} else {
    http_response_code(405);
}


$conn->close();
?>
