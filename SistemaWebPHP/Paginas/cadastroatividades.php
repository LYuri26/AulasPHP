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

$login = $_SESSION['login'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $atividade_nome = $_POST['nome'];
    $atividade_funcionario = $_POST['funcionario'];
    $atividade_detalhes = $_POST['detalhes'];

    $sql = "INSERT INTO atividades (nome, funcionario, detalhes) VALUES ('$atividade_nome', '$atividade_funcionario', '$atividade_detalhes')";

    if (mysqli_query($conn, $sql)) {
        header("Location: inicio.php");
    } else {
        echo "Erro ao cadastrar atividade: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Atividade</title>
</head>

<body>
    <form action="" method="post">
        Nome da Atividade: <input type="text" name="nome"><br>
        Funcionário: <input type="text" name="funcionario"><br>
        Detalhes: <input type="text" name="detalhes"><br>
        <input type="submit" value="Cadastrar">
    </form>
</body>

</html>
