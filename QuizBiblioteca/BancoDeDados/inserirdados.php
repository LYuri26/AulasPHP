<?php

include 'conexao.php';

try {
    $inserirDadosQuery = "INSERT INTO jogadores (nome, pontuacao, classificacao) VALUES (:nome, :pontuacao, 0)";
    $stmt = $pdo->prepare($inserirDadosQuery);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':pontuacao', $pontuacao, PDO::PARAM_INT);
    $stmt->execute();
} catch (PDOException $e) {
    die("Erro ao inserir dados: " . $e->getMessage());
}
