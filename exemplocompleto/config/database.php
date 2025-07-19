<?php
// Configurações do banco de dados
define('DB_HOST', 'localhost');
define('DB_USER', 'root');  // Usuário criado no SQL
define('DB_PASS', ''); // Senha definida no SQL
define('DB_NAME', 'cadastro_usuarios');

// Conexão com MySQL usando PDO
try {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Funções úteis para o banco de dados
function executeQuery($sql, $params = [])
{
    global $pdo;
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    } catch (PDOException $e) {
        die("Erro na query: " . $e->getMessage());
    }
}

function fetchAll($sql, $params = [])
{
    return executeQuery($sql, $params)->fetchAll();
}

function fetchOne($sql, $params = [])
{
    return executeQuery($sql, $params)->fetch();
}
