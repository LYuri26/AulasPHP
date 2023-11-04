<?php

include 'conexao.php';

try {
    // Classificar jogadores por pontuação em ordem decrescente
    $classificarQuery = "SELECT * FROM jogadores ORDER BY pontuacao DESC";
    $stmt = $pdo->prepare($classificarQuery);
    $stmt->execute();
    $jogadores = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Atualizar classificação
    $classificacao = 1;
    foreach ($jogadores as $jogador) {
        $atualizarClassificacaoQuery = "UPDATE jogadores SET classificacao = :classificacao WHERE id = :id";
        $stmt = $pdo->prepare($atualizarClassificacaoQuery);
        $stmt->bindParam(':classificacao', $classificacao, PDO::PARAM_INT);
        $stmt->bindParam(':id', $jogador['id'], PDO::PARAM_INT);
        $stmt->execute();
        $classificacao++;
    }
} catch (PDOException $e) {
    die("Erro ao classificar jogadores: " . $e->getMessage());
}
