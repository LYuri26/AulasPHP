<?php
$host = 'localhost';
$dbname = 'RH';
$username = 'root';
$password = '';

try {
    $conexao = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<script>console.log('Conexão realizada com sucesso!');</script>";
} catch(PDOException $e) {
    echo "<script>console.error('Erro na conexão: " . $e->getMessage() . "');</script>";
}
?>
