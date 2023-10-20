<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "saep_database";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
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
