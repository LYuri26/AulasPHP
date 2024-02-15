<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'estoque');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Teste de Estresse - Simulação de Múltiplas Inserções
$inicio = microtime(true); // Inicia a contagem de tempo

// Número de inserções a serem simuladas
$num_insercoes = 1000;

for ($i = 1; $i <= $num_insercoes; $i++) {
    $nome_produto = "Produto " . $i;
    $quantidade = rand(1, 100); // Quantidade aleatória entre 1 e 100
    $preco_unitario = rand(10, 100); // Preço aleatório entre 10 e 100

    // Query SQL para inserir o novo produto no banco de dados
    $sql = "INSERT INTO produtos (nome, quantidade, preco_unitario) VALUES ('$nome_produto', $quantidade, $preco_unitario)";

    // Executa a query
    $conn->query($sql);
}

$fim = microtime(true); // Finaliza a contagem de tempo
$tempo_total = $fim - $inicio; // Calcula o tempo total de execução

echo "Teste de Estresse - Simulação de Múltiplas Inserções: $num_insercoes inserções realizadas em " . round($tempo_total, 2) . " segundos.<br>";

// Fecha a conexão com o banco de dados
$conn->close();
?>
