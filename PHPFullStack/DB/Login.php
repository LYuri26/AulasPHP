<?php
include 'Conexao.php'; // Inclui o arquivo de conexão

try {
    // Query para criar a tabela 'login'
    $query = "CREATE TABLE IF NOT EXISTS login (
        id INT AUTO_INCREMENT PRIMARY KEY,
        usuario VARCHAR(50) NOT NULL,
        nome VARCHAR(100) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        email VARCHAR(100) NOT NULL
    )";

    // Executar a query
    $conexao->exec($query);
    echo "<script>console.log('Tabela login criada com sucesso!');</script>";

} catch(PDOException $e) {
    echo "<script>console.error('Erro ao criar a tabela." . $e->getMessage() . "');</script>";
}
?>
