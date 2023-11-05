<?php
include 'conexao.php';
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem


try {
    $sql = "CREATE TABLE IF NOT EXISTS jogadores (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(50) NOT NULL,
        pontuacao INT(6) NOT NULL,
        posicao INT(6) UNSIGNED
    )";

    $pdo->exec($sql);
    echo "Tabela criada com sucesso ou já existente!";
} catch (PDOException $e) {
    echo "Erro ao criar tabela: " . $e->getMessage();
}
