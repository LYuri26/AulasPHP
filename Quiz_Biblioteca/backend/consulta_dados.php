<?php
include 'conexao.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
    }
} catch (PDOException $e) {
    echo "Erro ao conectar ao banco de dados: " . $e->getMessage();
}
?>
