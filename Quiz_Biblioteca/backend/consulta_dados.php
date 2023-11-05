<?php
include 'conexao.php';
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

// Consulta os jogadores ordenando pela pontuação em ordem decrescente
$sql = "SELECT * FROM jogadores ORDER BY pontuacao DESC";
$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    $classificacao = 1;
    $data = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $updateclassificacao = "UPDATE jogadores SET classificacao = :classificacao WHERE id = :id";
        $stmt = $pdo->prepare($updateclassificacao);
        $stmt->bindParam(':classificacao', $classificacao, PDO::PARAM_INT);
        $stmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
        $stmt->execute();

        $data[] = $row; // Adiciona os dados ao array

        $classificacao++;
    }

    // Retorna os dados como JSON
} else {
    echo json_encode(array("message" => "Nenhum jogador encontrado."));
}

$pdo = null;
