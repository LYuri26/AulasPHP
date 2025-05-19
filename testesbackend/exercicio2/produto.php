<?php
include "conexao.php";

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id || $id <= 0) {
    echo "ID inválido.";
    exit;
}

$stmt = $conn->prepare("SELECT nome, preco FROM produtos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo "Produto: " . htmlspecialchars($row["nome"]) . "<br>";
    echo "Preço: R$ " . number_format($row["preco"], 2, ',', '.');
} else {
    echo "Produto não encontrado.";
}