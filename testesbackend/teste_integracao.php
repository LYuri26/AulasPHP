<?php
// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'estoque');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Teste de Integração - Consulta ao Banco de Dados
echo "Teste de Integração - Consulta ao Banco de Dados:<br>";

// Query SQL para selecionar todos os produtos
$sql = "SELECT * FROM produtos";

// Executa a consulta
$result = $conn->query($sql);

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Exibe os resultados
    while ($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Nome: " . $row["nome"] . " - Quantidade: " . $row["quantidade"] . " - Preço Unitário: " . $row["preco_unitario"] . "<br>";
    }
} else {
    echo "Nenhum produto encontrado.<br>";
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
