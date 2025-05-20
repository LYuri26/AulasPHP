<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'estoque');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Teste de Tratamento de Erros - Inserção de Dados Inválidos
$nome_produto = "Camiseta";
$quantidade = -10; // Quantidade inválida
$preco_unitario = 20.99;

// Query SQL para inserir o novo produto no banco de dados
$sql = "INSERT INTO produtos (nome, quantidade, preco_unitario) VALUES ('$nome_produto', $quantidade, $preco_unitario)";

// Executa a query
if ($conn->query($sql) === TRUE) {
    echo "Teste de Tratamento de Erros - Inserção de Dados Inválidos: Produto adicionado com sucesso!<br>";
} else {
    echo "Erro ao adicionar produto: " . $conn->error . "<br>";
}

// Teste de Tratamento de Erros - Consulta SQL Inválida
$sql_consulta = "SELECT * FROM produtos WHERE id = 'abc'"; // Consulta SQL inválida

// Executa a consulta
$result = $conn->query($sql_consulta);

// Verifica se houve erro na consulta
if ($result === FALSE) {
    echo "Teste de Tratamento de Erros - Consulta SQL Inválida: Erro na consulta.<br>";
} else {
    echo "Teste de Tratamento de Erros - Consulta SQL Inválida: Consulta realizada com sucesso.<br>";
}

// Fecha a conexão com o banco de dados
$conn->close();