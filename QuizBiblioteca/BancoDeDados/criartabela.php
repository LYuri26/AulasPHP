<?php

include 'conexao.php';

try {
    // Criar a tabela jogadores se ela não existir
    $createTableQuery = "CREATE TABLE IF NOT EXISTS jogadores (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255),
        pontuacao INT,
        classificacao INT
    )";
    $pdo->exec($createTableQuery);
} catch (PDOException $e) {
    die("Erro ao criar tabela: " . $e->getMessage());
}
