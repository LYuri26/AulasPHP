<?php

// Define as credenciais do banco de dados
$host = "localhost";
$dbname = "hospedagemypua";
$username = "root";
$password = "";

// Conecta ao banco de dados
try {
  $conexao = new PDO("mysql:host=$host", $username, $password);
  $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}

// Verifica se o banco de dados existe
$query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = 'hospedagemypua';";
$resultado = $conexao->query($query);

// Se o banco de dados não existir, cria ele
if ($resultado->rowCount() === 0) {
  $query = "CREATE DATABASE hospedagemypua;";
  $conexao->exec($query);
}

// Conecta ao banco de dados
$conexao->exec("USE hospedagemypua;");

// Cria as tabelas

// Cria a tabela Usuarios
$query = "CREATE TABLE IF NOT EXISTS usuarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  perfil VARCHAR(255) NOT NULL
);";
$conexao->exec($query);

// Cria a tabela Hospedagens
$query = "CREATE TABLE IF NOT EXISTS hospedagens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  data_check_in DATE NOT NULL,
  data_check_out DATE NOT NULL,
  numero_de_hospedes INT NOT NULL,
  tipo_de_acomodacao VARCHAR(255) NOT NULL,
  cliente_id INT NOT NULL
);";
$conexao->exec($query);

// Cria a tabela Funcionarios
$query = "CREATE TABLE IF NOT EXISTS funcionarios (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL UNIQUE,
  senha VARCHAR(255) NOT NULL,
  cargo VARCHAR(255) NOT NULL
);";
$conexao->exec($query);

// Retorna a conexão
return $conexao;

?>
