<?php
$host = "localhost"; // Define o nome do host do banco de dados.
$user = "root"; // Define o nome de usuário do banco de dados.
$password = ""; // Define a senha do banco de dados.
$database = "saep_database"; // Define o nome do banco de dados.

$conn = mysqli_connect($host, $user, $password, $database); // Conecta ao banco de dados usando MySQLi.

if (!$conn) {
    die("Erro de conexão:" . mysqli_connect_error()); // Se a conexão falhar, exibe uma mensagem de erro e encerra o script.
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Obtém o valor do campo de e-mail do formulário.
    $senha = $_POST['senha']; // Obtém o valor do campo de senha do formulário.
    $sql = "SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'"; // Consulta SQL para verificar se o e-mail e a senha correspondem a um usuário.
    $result = mysqli_query($conn, $sql); // Executa a consulta no banco de dados.

    if (mysqli_num_rows($result) > 0) { // Verifica se o resultado da consulta retornou algum registro.
        $user = mysqli_fetch_assoc($result); // Obtém os dados do usuário.
        session_start(); // Inicia a sessão.
        $_SESSION['id'] = $user['id']; // Armazena o ID do usuário na sessão.
        $_SESSION['login'] = $user['login']; // Armazena o nome de usuário na sessão.
        header("Location: inicio.php"); // Redireciona para a página inicial.
        exit(); // Encerra o script após o redirecionamento.
    } else {
        echo "E-mail ou senha incorretos!"; // Se as credenciais estiverem incorretas, exibe uma mensagem de erro.
    }
}

mysqli_close($conn); // Fecha a conexão com o banco de dados.
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css"> <!-- Inclui um arquivo de estilo CSS. -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres da página. -->
    <title>Login</title> <!-- Define o título da página. -->
</head>

<body>
    <form action="index.php" method="post"> <!-- Cria um formulário que envia os dados para a própria página (index.php) usando o método POST. -->
        <input type="text" name="email" placeholder="E-mail"> <!-- Campo de entrada para o e-mail. -->
        <input type="password" name="senha" placeholder="Senha"> <!-- Campo de entrada para a senha. -->
        <input type="submit" value="Entrar"> <!-- Botão de submissão do formulário. -->
    </form>
</body>

</html>