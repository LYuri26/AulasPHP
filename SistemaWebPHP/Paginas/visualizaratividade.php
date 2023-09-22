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

if (isset($_GET['numero'])) {
    $numero_atividade = $_GET['numero'];

    $sql = "SELECT * FROM atividades WHERE numero='$numero_atividade'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Erro na consulta SQL: " . mysqli_error($conn));
    }

    $atividade = mysqli_fetch_assoc($result);
} else {
    header("Location: inicio.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css">
    <meta charset="UTF-8">
    <title>Visualizar Atividade</title>
</head>

<body>

    <div class="header">
        <h1>Bem-vindo, <?php echo $login; ?></h1>
        <a href="index.php">Sair</a>
    </div>

    <div class="content">
        <h2>Detalhes da Atividade</h2>

        <?php if ($atividade) : ?>
            <p><strong>Número da Atividade:</strong> <?php echo $atividade['numero']; ?></p>
            <p><strong>Nome da Atividade:</strong> <?php echo $atividade['nome']; ?></p>
            <p><strong>Funcionário:</strong> <?php echo $atividade['funcionario']; ?></p>
            <p><strong>Detalhes:</strong> <?php echo $atividade['detalhes']; ?></p>
        <?php else : ?>
            <p>Atividade não encontrada.</p>
        <?php endif; ?>

        <a href="inicio.php">Voltar para a Lista de Atividades</a>
    </div>
</body>

</html>
