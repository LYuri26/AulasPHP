<?php
// Configurações de conexão com o banco de dados
$servername = "localhost"; // Nome do servidor MySQL
$username = "root"; // Nome de usuário do MySQL
$password = ""; // Senha do MySQL (vazia neste exemplo)
$dbname = "linkin_park_album"; // Nome do banco de dados mudado para "linkin_park_album"

// Tentativa de conexão com o banco de dados usando PDO
try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Configura o modo de erro para lançar exceções
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage()); // Em caso de erro, mostra a mensagem de erro
}
?>
