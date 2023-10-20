<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "saep_database";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erro de conexão:" . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];
        header("Location: inicio.php");
        exit(); // É uma boa prática encerrar o script após redirecionar
    } else {
        echo "E-mail ou senha incorretos!";
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css">
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <form action="index.php" method="post">
        <input type="text" name="email" placeholder="E-mail"> <!-- Campo de e-mail -->
        <input type="password" name="senha" placeholder="Senha">
        <input type="submit" value="Entrar">
    </form>
</body>

</html>