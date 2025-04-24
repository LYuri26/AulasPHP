<?php
$host = 'localhost';
$banco = 'retailhub';
$usuario = 'root';
$senha = '';

try {
    // Criando a conexão
    $conexao = new PDO("mysql:host=$host", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criação do banco de dados
    $conexao->exec("CREATE DATABASE IF NOT EXISTS $banco CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conexao->exec("USE $banco");

    //echo "Conectado ao banco de dados com sucesso.";
} catch (PDOException $erro) {
    echo "Erro: " . $erro->getMessage();
}
