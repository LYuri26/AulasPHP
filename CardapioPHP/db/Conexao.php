<?php

function conectar()
{
    $host = "localhost";
    $user = "root";
    $password = "";
    $db = "lanchonete";

    try {
        $conexao = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);

        // Configura para lançar exceções em caso de erros
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conexao;
    } catch (PDOException $e) {
        echo "<script>console.error('Erro na conexão com o banco de dados: " . $e->getMessage() . "');</script>";
        return null;
    }
}

function fecharConexao($conexao)
{
    if ($conexao) {
        $conexao = null;
    }
}
