<?php
// Habilitar relatório de erros
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Definir cabeçalho para resposta JSON
header('Content-Type: application/json');

// Verificar se a requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Método não permitido
    echo json_encode(['status' => 'error', 'message' => 'Método de requisição não permitido']);
    exit;
}

// Verificar se as extensões necessárias estão carregadas
if (!extension_loaded('json')) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Extensão JSON não está habilitada no PHP']);
    exit;
}

// Incluir arquivo de conexão com tratamento de erro
try {
    require_once 'Conexao.php';
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Erro ao carregar arquivo de conexão: ' . $e->getMessage()]);
    exit;
}

// Função para validar e sanitizar dados
function sanitizarDados($dados)
{
    if (is_array($dados)) {
        return array_map('sanitizarDados', $dados);
    }
    return htmlspecialchars(strip_tags(trim($dados)));
}

// Processar dados do pedido
try {
    // Validar dados recebidos
    if (!isset($_POST['total']) || !isset($_POST['itens'])) {
        throw new Exception('Dados do pedido incompletos');
    }

    $valorPedido = filter_var($_POST['total'], FILTER_VALIDATE_FLOAT);
    if ($valorPedido === false || $valorPedido <= 0) {
        throw new Exception('Valor do pedido inválido');
    }

    $itensPedido = json_decode(urldecode($_POST['itens']), true);
    if (json_last_error() !== JSON_ERROR_NONE || !is_array($itensPedido)) {
        throw new Exception('Formato dos itens do pedido inválido');
    }

    // Sanitizar itens do pedido
    $itensPedido = sanitizarDados($itensPedido);
    $dataPedido = date("Y-m-d");
    $horarioPedido = date("H:i:s");

    // Conectar ao banco de dados
    $conexao = conectar();
    if (!$conexao) {
        throw new Exception('Erro na conexão com o banco de dados');
    }

    // Preparar transação
    $conexao->beginTransaction();

    // Inserir dados na tabela de pedidos
    $sqlPedido = "INSERT INTO pedidos (data_pedido, horario_pedido, valor_pedido, itens_do_pedido) 
                  VALUES (:dataPedido, :horarioPedido, :valorPedido, :itensPedido)";

    $stmtPedido = $conexao->prepare($sqlPedido);
    if (!$stmtPedido) {
        throw new Exception('Erro ao preparar declaração SQL para o pedido');
    }

    $itensJson = json_encode($itensPedido);
    $stmtPedido->bindParam(':dataPedido', $dataPedido, PDO::PARAM_STR);
    $stmtPedido->bindParam(':horarioPedido', $horarioPedido, PDO::PARAM_STR);
    $stmtPedido->bindParam(':valorPedido', $valorPedido, PDO::PARAM_STR);
    $stmtPedido->bindParam(':itensPedido', $itensJson, PDO::PARAM_STR);

    if (!$stmtPedido->execute()) {
        throw new Exception('Erro ao registrar pedido: ' . implode(', ', $stmtPedido->errorInfo()));
    }

    // Obter ID do pedido inserido
    $pedidoId = $conexao->lastInsertId();

    // Inserir itens do pedido em uma tabela separada (opcional)
    $sqlItens = "INSERT INTO pedido_itens (pedido_id, produto_id, quantidade, preco_unitario) 
                 VALUES (:pedidoId, :produtoId, :quantidade, :precoUnitario)";

    $stmtItens = $conexao->prepare($sqlItens);
    if (!$stmtItens) {
        throw new Exception('Erro ao preparar declaração SQL para os itens');
    }

    foreach ($itensPedido as $item) {
        $produtoId = filter_var($item['id'], FILTER_VALIDATE_INT);
        $quantidade = filter_var($item['quantidade'], FILTER_VALIDATE_INT);
        $precoUnitario = filter_var($item['preco'], FILTER_VALIDATE_FLOAT);

        if ($produtoId === false || $quantidade === false || $precoUnitario === false) {
            throw new Exception('Dados do item inválidos');
        }

        $stmtItens->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
        $stmtItens->bindParam(':produtoId', $produtoId, PDO::PARAM_INT);
        $stmtItens->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmtItens->bindParam(':precoUnitario', $precoUnitario, PDO::PARAM_STR);

        if (!$stmtItens->execute()) {
            throw new Exception('Erro ao registrar item do pedido: ' . implode(', ', $stmtItens->errorInfo()));
        }
    }

    // Confirmar transação
    $conexao->commit();

    // Resposta de sucesso
    echo json_encode([
        'status' => 'success',
        'message' => 'Pedido registrado com sucesso!',
        'pedido_id' => $pedidoId,
        'data' => $dataPedido,
        'valor_total' => number_format($valorPedido, 2, ',', '.')
    ]);
} catch (Exception $e) {
    // Reverter transação em caso de erro
    if (isset($conexao)) {
        $conexao->rollBack();
    }

    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage(),
        'details' => (isset($itensJson) && json_last_error() !== JSON_ERROR_NONE) ? json_last_error_msg() : null
    ]);
} finally {
    // Fechar conexão
    if (isset($conexao)) {
        $conexao = null;
    }
}
