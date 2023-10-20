<?php
session_start(); // Inicia a sessão PHP.

$servername = "localhost"; // Define o nome do servidor do banco de dados.
$username = "root"; // Define o nome de usuário do banco de dados.
$password = ""; // Define a senha do banco de dados.
$database = "saep_database"; // Define o nome do banco de dados.

$conn = mysqli_connect($servername, $username, $password, $database); // Conecta ao banco de dados usando MySQLi.

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error()); // Se a conexão falhar, exibe uma mensagem de erro e encerra o script.
}

if (!isset($_SESSION['login'])) {
    header("Location: index.php"); // Redireciona para a página de login se não houver uma sessão ativa.
    exit(); // Encerra o script.
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['numero'])) {
    $numero = $_POST['numero']; // Obtém o número da atividade a ser excluída

    // Monta a consulta SQL para excluir a atividade do banco de dados
    $sql = "DELETE FROM atividades WHERE numero = $numero";

    // Executa a consulta SQL
    if (mysqli_query($conn, $sql)) {
        header("Location: inicio.php"); // Redireciona para a página inicial após a exclusão bem-sucedida
    } else {
        echo "Erro ao excluir atividade: " . mysqli_error($conn); // Exibe mensagem de erro em caso de falha na consulta
    }
} else {
    header("Location: inicio.php"); // Redireciona de volta para a página inicial se não houver um número de atividade válido
}
?>