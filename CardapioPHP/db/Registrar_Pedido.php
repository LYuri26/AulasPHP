<?php
include 'Tabelas.php'; // Inclui o arquivo de conexão com o banco de dados

error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

// Verify request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição não permitido']);
    exit;
}

// Get JSON input
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Validate input
if (json_last_error() !== JSON_ERROR_NONE) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'JSON inválido']);
    exit;
}

if (!isset($data['total']) || !isset($data['itens']) || !is_array($data['itens'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Dados do pedido incompletos']);
    exit;
}

try {
    $conexao = conectar();

    if (!$conexao) {
        throw new Exception('Erro na conexão com o banco de dados');
    }

    // Begin transaction
    $conexao->beginTransaction();

    // Insert order
    $stmtPedido = $conexao->prepare(
        "INSERT INTO pedidos (data_pedido, horario_pedido, valor_pedido, itens_do_pedido) 
         VALUES (CURDATE(), CURTIME(), :valorPedido, :itensPedido)"
    );

    $itensJson = json_encode($data['itens']);
    $stmtPedido->bindParam(':valorPedido', $data['total'], PDO::PARAM_STR);
    $stmtPedido->bindParam(':itensPedido', $itensJson, PDO::PARAM_STR);

    if (!$stmtPedido->execute()) {
        throw new Exception('Erro ao registrar pedido');
    }

    $pedidoId = $conexao->lastInsertId();
    $conexao->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Pedido registrado com sucesso!',
        'pedido_id' => $pedidoId
    ]);
} catch (Exception $e) {
    if (isset($conexao)) {
        $conexao->rollBack();
    }
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
} finally {
    if (isset($conexao)) {
        $conexao = null;
    }
}
