<?php

// Define as credenciais do banco de dados
$host = "localhost";
$dbname = "hospedagemypua";
$username = "root";
$password = "";

// Função para conectar ao banco de dados e retornar a conexão
function conexao() {
    global $host, $dbname, $username, $password;
    
    try {
        $conexao = new PDO("mysql:host=$host", $username, $password);
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Verifica se o banco de dados existe
        $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname';";
        $resultado = $conexao->query($query);

        // Se o banco de dados não existir, cria ele
        if ($resultado->rowCount() === 0) {
            $conexao->exec("CREATE DATABASE $dbname;");
        }

        // Conecta ao banco de dados especificado
        $conexao->exec("USE $dbname;");

        // Cria as tabelas se elas não existirem
        $queryUsuarios = "CREATE TABLE IF NOT EXISTS usuarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            perfil VARCHAR(255) NOT NULL
        );";
        $conexao->exec($queryUsuarios);

        $queryHospedagens = "CREATE TABLE IF NOT EXISTS hospedagens (
            id INT AUTO_INCREMENT PRIMARY KEY,
            data_check_in DATE NOT NULL,
            data_check_out DATE NOT NULL,
            numero_de_hospedes INT NOT NULL,
            tipo_de_acomodacao VARCHAR(255) NOT NULL,
            cliente_id INT NOT NULL
        );";
        $conexao->exec($queryHospedagens);

        $queryFuncionarios = "CREATE TABLE IF NOT EXISTS funcionarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            senha VARCHAR(255) NOT NULL,
            cargo VARCHAR(255) NOT NULL
        );";
        $conexao->exec($queryFuncionarios);

        return $conexao;
    } catch (PDOException $e) {
        die("Erro ao conectar ao banco de dados: " . $e->getMessage());
    }
}

// Retorna a conexão
return conexao();

?>
