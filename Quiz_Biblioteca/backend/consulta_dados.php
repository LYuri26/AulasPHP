<?php
include 'conexao.php';
header("Access-Control-Allow-Origin: *"); // Permite requisições de qualquer origem

// Consulta os jogadores ordenando pela pontuação em ordem decrescente
$sql = "SELECT * FROM jogadores ORDER BY pontuacao DESC";
$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    $posicao = 1;
    $data = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        $updatePosicao = "UPDATE jogadores SET posicao = :posicao WHERE id = :id";
        $stmt = $pdo->prepare($updatePosicao);
        $stmt->bindParam(':posicao', $posicao, PDO::PARAM_INT);
        $stmt->bindParam(':id', $row['id'], PDO::PARAM_INT);
        $stmt->execute();

        $data[] = $row; // Adiciona os dados ao array

        $posicao++;
    }

    // Retorna os dados como JSON
    echo json_encode($data);
} else {
    echo json_encode(array("message" => "Nenhum jogador encontrado."));
}

$pdo = null;
