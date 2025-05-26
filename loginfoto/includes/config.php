<?php
session_start();

// Configurações do Banco de Dados
$db_host = 'localhost';
$db_name = 'login_system';
$db_user = 'root';
$db_pass = '';

// Configurações do Sistema
$basePath = '/login-system/';
$uploadDir = '../assets/uploads';
$defaultPhoto = '../assets/img/default-user.png';

// Conexão com o Banco de Dados
try {
    $pdo = new PDO(
        "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4",
        $db_user,
        $db_pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
