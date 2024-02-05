<?php
// Configurações de conexão com o banco de dados
$host = 'localhost'; // Endereço do servidor MySQL (geralmente 'localhost')
$dbname = 'graosdb'; // Nome do banco de dados
$username = 'root'; // Nome de usuário do banco de dados
$password = ''; // Senha do banco de dados

try {
    // Conectar ao banco de dados utilizando PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Configurar o PDO para lançar exceções em caso de erros
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Configurar o conjunto de caracteres para UTF-8
    $pdo->exec("SET NAMES 'utf8'");
    
    // Feedback no console do navegador
    echo '<script>console.log("Conexão com o banco de dados estabelecida com sucesso!");</script>';
} catch (PDOException $e) {
    // Em caso de erro na conexão, exibir mensagem de erro no console do navegador
    echo '<script>console.error("Erro ao conectar ao banco de dados: ' . $e->getMessage() . '");</script>';
    exit(1); // Encerra o script com código de erro
}
?>
