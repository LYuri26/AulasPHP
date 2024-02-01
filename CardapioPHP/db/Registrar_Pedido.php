<?php
include 'Conexao.php'; // Inclui o arquivo de conexão com o banco de dados

// Receber dados do pedido
$dataPedido = date("Y-m-d"); // Obtém a data atual no formato "ano-mês-dia"
$horarioPedido = date("H:i:s"); // Obtém o horário atual no formato "hora:minuto:segundo"
$valorPedido = $_POST['total']; // Obtém o valor total do pedido enviado via POST
$itensPedido = json_decode(urldecode($_POST['itens']), true); // Decodifica os itens do pedido de JSON para array associativo

// Conectar ao banco de dados
$conexao = conectar(); // Chama a função conectar() do arquivo Conexao.php para estabelecer a conexão

// Verificar se a conexão foi bem-sucedida
if (!$conexao) {
    echo json_encode(array('status' => 'error', 'message' => 'Erro na conexão com o banco de dados.')); // Envia uma resposta JSON indicando um erro de conexão
    exit; // Encerra o script PHP
}

// Inserir dados na tabela de pedidos
$sql = "INSERT INTO pedidos (data_pedido, horario_pedido, valor_pedido, itens_do_pedido) VALUES (:dataPedido, :horarioPedido, :valorPedido, :itensPedido)"; // SQL para inserir um novo pedido na tabela
$stmt = $conexao->prepare($sql); // Prepara a declaração SQL para execução

if ($stmt) { // Verifica se a preparação da declaração foi bem-sucedida
    $stmt->bindParam(':dataPedido', $dataPedido); // Associa o parâmetro :dataPedido ao valor da variável $dataPedido
    $stmt->bindParam(':horarioPedido', $horarioPedido); // Associa o parâmetro :horarioPedido ao valor da variável $horarioPedido
    $stmt->bindParam(':valorPedido', $valorPedido); // Associa o parâmetro :valorPedido ao valor da variável $valorPedido
    $stmt->bindParam(':itensPedido', json_encode($itensPedido)); // Associa o parâmetro :itensPedido ao valor da variável $itensPedido convertida para JSON

    // Executar a inserção
    if ($stmt->execute()) { // Executa a declaração SQL preparada
        // Enviar uma resposta de sucesso para o JavaScript
        echo json_encode(array('status' => 'success', 'message' => 'Pedido registrado com sucesso!')); // Envia uma resposta JSON indicando o sucesso da operação
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Erro ao executar a declaração SQL.')); // Envia uma resposta JSON indicando um erro ao executar a declaração SQL
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Erro ao preparar a declaração SQL.')); // Envia uma resposta JSON indicando um erro ao preparar a declaração SQL
}

// Fechar a conexão com o banco de dados (o PDO não possui um método 'close')
$conexao = null; // Fecha a conexão com o banco de dados
