<?php
function conectar()
{
    $host = "localhost";
    $dbname = "codebrew_cafe";
    $username = "root";
    $password = "";

    try {
        // Conecta ao banco de dados específico
        $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Erro na conexão: " . $e->getMessage());
    }
}

function fecharConexao($conn)
{
    $conn = null;
}