<?php
include 'Conexao.php';

// Receber dados do pedido
$dataPedido = date("Y-m-d");
$horarioPedido = date("H:i:s");
$valorPedido = $_POST['total'];
$itensPedido = json_decode(urldecode($_POST['itens']), true);

// Conectar ao banco de dados
$conexao = conectar();

// Verificar se a conexão foi bem-sucedida
if (!$conexao) {
    echo json_encode(array('status' => 'error', 'message' => 'Erro na conexão com o banco de dados.'));
    exit;
}

// Inserir dados na tabela de pedidos
$sql = "INSERT INTO pedidos (data_pedido, horario_pedido, valor_pedido, itens_do_pedido) VALUES (:dataPedido, :horarioPedido, :valorPedido, :itensPedido)";
$stmt = $conexao->prepare($sql);

if ($stmt) {
    $stmt->bindParam(':dataPedido', $dataPedido);
    $stmt->bindParam(':horarioPedido', $horarioPedido);
    $stmt->bindParam(':valorPedido', $valorPedido);
    $stmt->bindParam(':itensPedido', json_encode($itensPedido));

    // Executar a inserção
    if ($stmt->execute()) {
        // Enviar uma resposta de sucesso para o JavaScript
        echo json_encode(array('status' => 'success', 'message' => 'Pedido registrado com sucesso!'));
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Erro ao executar a declaração SQL.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Erro ao preparar a declaração SQL.'));
}

// Fechar a conexão com o banco de dados (o PDO não possui um método 'close')
$conexao = null;
