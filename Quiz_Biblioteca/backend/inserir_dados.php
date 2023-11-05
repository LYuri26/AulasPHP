<?php

header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

include 'conexao.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = isset($_POST['nome']) ? $_POST['nome'] : null;
    $pontuacao = isset($_POST['pontuacao']) ? $_POST['pontuacao'] : null;

    if ($nome !== null && $pontuacao !== null) {
        try {
            $stmt = $pdo->prepare('INSERT INTO jogadores (nome, pontuacao) VALUES (:nome, :pontuacao)');
            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':pontuacao', $pontuacao);

            $stmt->execute();

            echo json_encode(array('status' => 'success'));
            exit();
        } catch (PDOException $e) {
            echo json_encode(array('status' => 'error', 'message' => 'Erro: ' . $e->getMessage()));
        }
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Parâmetros inválidos'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Método de requisição inválido'));
}

$pdo = null; // Fecha a conexão
