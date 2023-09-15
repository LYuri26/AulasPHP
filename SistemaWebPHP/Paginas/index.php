<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "saep_database";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Erro de conexão:" . mysqli_connect_error());
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/estilos.css"> <!-- Caminho para o arquivo CSS -->
    <meta charset="UTF-8">
    <title>Login</title>
</head>

<body>
    <form action="index.php" method="post">
        <input type="text" name="login" placeholder="Login">
        <input type="password" name="senha" placeholder="Senha">        
        <input type="submit" value="Entrar">
    </form>
</body>

</html>

<?php
if (isset($_POST['login'])&& isset($_POST['senha'])){
    $login = $_POST['login'];
    $senha = $_POST['senha'];
    $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result)>0){
        $user = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['id'] = $user ['id'];
        $_SESSION['login'] = $user ['login'];

        header("Location: inicio.php");
    } else {
        echo "Login ou senha incorretos!";
    }
} 
mysqli_close($conn);
?>
