<?php
// Parâmetro recebido do usuário (simulação de ataque de injeção de SQL)
$id_produto = $_GET['id'];

// Conexão com o banco de dados
$conn = new mysqli('localhost', 'root', '', 'estoque');

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Query SQL segura com declaração preparada
$stmt = $conn->prepare("SELECT * FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id_produto);
$stmt->execute();
$result = $stmt->get_result();

// Verifica se há resultados
if ($result->num_rows > 0) {
    // Exibe os resultados
    while ($row = $result->fetch_assoc()) {
        // Verifica se o produto é válido
        if ($row["id"] == $id_produto) {
            echo "ID: " . $row["id"] . " - Nome: " . $row["nome"] . " - Quantidade: " . $row["quantidade"] . " - Preço Unitário: " . $row["preco_unitario"] . "<br>";
        } else {
            echo "Produto inválido.<br>";
        }
    }
} else {
    echo "Nenhum produto encontrado.<br>";
}

// Fecha a conexão com o banco de dados
$stmt->close();
$conn->close();
?>
