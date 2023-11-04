<?php
include './conexao.php';

$nome = isset($_POST['nome']) ? $_POST['nome'] : null;
$pontuacao = isset($_POST['pontuacao']) ? $_POST['pontuacao'] : null;

if ($nome !== null && $pontuacao !== null) {
    try {
        $stmt = $pdo->prepare('INSERT INTO jogadores (nome, pontuacao) VALUES (:nome, :pontuacao)');
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':pontuacao', $pontuacao);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Dados inseridos com sucesso']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Erro ao inserir dados: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos']);
}

$pdo = null;
