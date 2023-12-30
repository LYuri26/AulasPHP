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

    echo "Tabela 'login' criada com sucesso!<br>";

    // Inserção de três usuários
    $inserirUsuarios = $conexao->prepare("INSERT INTO login (usuario, nome, senha, email) VALUES (?, ?, ?, ?)");

    $usuarios = [
        ["usuario1", "Nome 1", "senha1", "email1@example.com"],
        ["usuario2", "Nome 2", "senha2", "email2@example.com"],
        ["usuario3", "Nome 3", "senha3", "email3@example.com"]
    ];

    foreach ($usuarios as $usuario) {
        $inserirUsuarios->execute($usuario);
        echo "Usuário inserido com sucesso!<br>";
    }
} catch(PDOException $e) {
    echo "Erro ao criar a tabela ou inserir usuários: " . $e->getMessage();
}
?>
