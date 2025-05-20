<?php
require_once 'funcoes.php';

try {
    $nome = trim($_POST['produto'] ?? '');
    $quantidade = intval($_POST['quantidade'] ?? 0);

    $pdo = conectarBanco();
    $id = inserirProduto($pdo, $nome, $quantidade);

    echo "Produto cadastrado com sucesso! ID: $id";
} catch (Exception $e) {
    echo "Erro ao cadastrar produto: " . htmlspecialchars($e->getMessage());
}