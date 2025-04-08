<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'Conexao.php';

// Verifica se é uma requisição POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Método não permitido']);
    exit;
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

if (!$data || !isset($data['nome_cliente']) || !isset($data['itens']) || !isset($data['total'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Dados inválidos']);
    exit;
}

try {
    $conn = conectar();
    $conn->beginTransaction();

    $stmt = $conn->prepare("INSERT INTO pedidos (nome_cliente, valor_total, itens_pedido) VALUES (:nome, :total, :itens)");

    $itens_json = json_encode($data['itens']);

    $stmt->bindParam(':nome', $data['nome_cliente']);
    $stmt->bindParam(':total', $data['total']);
    $stmt->bindParam(':itens', $itens_json);

    $stmt->execute();

    // Obtém o ID do último pedido inserido
    $pedido_id = $conn->lastInsertId();

    $conn->commit();

    echo json_encode([
        'status' => 'success',
        'message' => 'Pedido registrado com sucesso',
        'pedido_id' => $pedido_id
    ]);
} catch (PDOException $e) {
    if (isset($conn)) {
        $conn->rollBack();
    }
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro ao registrar pedido: ' . $e->getMessage()]);
} finally {
    if (isset($conn)) {
        fecharConexao($conn);
    }
}