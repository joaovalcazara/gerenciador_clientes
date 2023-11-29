<?php
include_once '../config/database.php';
include_once '../model/cliente-model.php';

$conn = Database::getConexao();
$clienteModel = new ClienteModel($conn);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Listar clientes
    $clientes = $clienteModel->listarClientes();
    echo json_encode($clientes);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Adicionar cliente
    $dados = json_decode(file_get_contents('php://input'), true);

    if ($dados) {
        $novoId = $clienteModel->adicionarCliente($dados);
        echo json_encode(['idCliente' => $novoId]);
    } else {
        // Responder com erro se os dados não puderem ser decodificados
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Dados inválidos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Editar cliente
    $dados = json_decode(file_get_contents('php://input'), true);

    if ($dados && isset($dados['idCliente'])) {
        $clienteModel->editarCliente($dados['idCliente'], $dados);
        echo json_encode(['success' => true]);
    } else {
        // Responder com erro se os dados ou o ID do cliente estiverem ausentes
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'Dados inválidos']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Excluir cliente
    $dados = json_decode(file_get_contents('php://input'), true);

    if ($dados && isset($dados['idCliente'])) {
        $clienteModel->excluirCliente($dados['idCliente']);
        echo json_encode(['success' => true]);
    } else {
        // Responder com erro se o ID do cliente estiver ausente
        http_response_code(400); // Bad Request
        echo json_encode(['error' => 'ID do cliente não fornecido']);
    }
}
