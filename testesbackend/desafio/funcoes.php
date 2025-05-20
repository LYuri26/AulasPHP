<?php
function conectarBanco()
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=estoque", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        throw new Exception("Erro na conexão: " . $e->getMessage());
    }
}

function inserirProduto($pdo, $nome, $qtd)
{
    if (empty($nome) || !is_numeric($qtd) || $qtd <= 0) {
        throw new Exception("Dados inválidos.");
    }

    $stmt = $pdo->prepare("INSERT INTO produtos (nome, quantidade) VALUES (:nome, :quantidade)");
    $stmt->bindParam(":nome", $nome);
    $stmt->bindParam(":quantidade", $qtd);
    $stmt->execute();

    return $pdo->lastInsertId();
}