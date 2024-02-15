<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'estoque');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Teste de Segurança - Injeção de SQL (com declarações preparadas)
$nome_produto = "Camiseta";
$quantidade = 10;
$preco_unitario = 20.99;

// Declaração preparada para inserção segura de dados
$stmt = $conn->prepare("INSERT INTO produtos (nome, quantidade, preco_unitario) VALUES (?, ?, ?)");

// Vincula os parâmetros à declaração preparada
$stmt->bind_param("sid", $nome_produto, $quantidade, $preco_unitario);

// Executa a declaração preparada
if ($stmt->execute()) {
    echo "Teste de Segurança - Injeção de SQL (com declarações preparadas): Produto adicionado com sucesso!<br>";
} else {
    echo "Erro ao adicionar produto: " . $conn->error . "<br>";
}

// Fecha a declaração preparada
$stmt->close();

// Fecha a conexão com o banco de dados
$conn->close();
?>
