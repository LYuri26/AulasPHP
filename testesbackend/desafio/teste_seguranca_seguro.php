<?php
require_once 'funcoes.php';

try {
    $pdo = conectarBanco();
    $id = intval($_GET['id'] ?? 0);

    $stmt = $pdo->prepare("SELECT * FROM produtos WHERE id = :id");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($produto) {
        echo "Produto: " . htmlspecialchars($produto['nome']) . " | Quantidade: " . $produto['quantidade'];
    } else {
        echo "Produto não encontrado.";
    }
} catch (Exception $e) {
    echo "Erro ao buscar produto: " . htmlspecialchars($e->getMessage());
}