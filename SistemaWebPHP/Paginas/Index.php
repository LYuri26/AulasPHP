<?php

// Cria as variáveis de conexão com o banco de dados
$host = "localhost";
$user = "root";
$password = "";
$database = "saep_database";

// Conecta-se ao banco de dados
$conn = mysqli_connect($host, $user, $password, $database);

// Verifica se a conexão foi bem-sucedida
if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// Cria a tabela "usuarios" se ela não existir
$sql = "CREATE TABLE IF NOT EXISTS usuarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    login VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);";

$result = mysqli_query($conn, $sql);

// Verifica se a tabela foi criada com sucesso
if (!$result) {
    die("Erro ao criar a tabela: " . mysqli_error($conn));
}

// Exibe o formulário de login
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <form action="Index.php" method="post">
        <input type="text" name="login" placeholder="Login">
        <input type="password" name="senha" placeholder="Senha">
        <input type="submit" value="Entrar">
    </form>
</body>
</html>

<?php

// Verifica se o formulário foi enviado
if (isset($_POST['login']) && isset($_POST['senha'])) {

    // Obtém os valores do formulário
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    // Cria a consulta SQL
    $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha = '$senha'";

    // Executa a consulta SQL
    $result = mysqli_query($conn, $sql);

    // Verifica se o usuário foi encontrado
    if (mysqli_num_rows($result) > 0) {

        // Cria uma sessão para o usuário
        $user = mysqli_fetch_assoc($result);
        session_start();
        $_SESSION['id'] = $user['id'];
        $_SESSION['login'] = $user['login'];

        // Redireciona o usuário para a página principal
        header("Location: Inicio.html");

    } else {

        // Exibe uma mensagem de erro
        echo "Login e/ou senha inválidos.";

    }

}

// Fecha a conexão com o banco de dados
mysqli_close($conn);

?>
