<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'estoque');

// Verifica se a conexão foi bem-sucedida
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Teste de Requisito Funcional - Adicionar Produto
$nome_produto = "Camiseta";
$quantidade = 100;
$preco_unitario = 20.99;

// Query SQL para inserir o novo produto no banco de dados
$sql = "INSERT INTO produtos (nome, quantidade, preco_unitario) VALUES ('$nome_produto', $quantidade, $preco_unitario)";

// Executa a query
if ($conn->query($sql) === TRUE) {
    echo "Teste de Requisito Funcional - Adicionar Produto: Novo produto adicionado com sucesso!<br>";
} else {
    echo "Erro ao adicionar novo produto: " . $conn->error . "<br>";
}

// Teste de Requisito Não Funcional - Desempenho de Consulta
$sql_consulta = "SELECT * FROM produtos";

// Executa a consulta e mede o tempo de execução
$start_time = microtime(true);
$result = $conn->query($sql_consulta);
$end_time = microtime(true);
$execution_time = $end_time - $start_time;

// Verifica se a consulta foi concluída dentro do tempo esperado
if ($execution_time < 1) {
    echo "Teste de Requisito Não Funcional - Desempenho de Consulta: Consulta de busca de produtos concluída em " . round($execution_time, 2) . " segundos. Teste passou!<br>";
} else {
    echo "Teste de Requisito Não Funcional - Desempenho de Consulta: Consulta de busca de produtos levou mais de 1 segundo para ser concluída. Teste falhou!<br>";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
