<?php
include './db/Conexao.php'; // Inclui o arquivo de conexão
include './db/Login.php'; // Inclui o arquivo de conexão
include './db/Tabelas.php'; // Inclui o arquivo de conexão
include './db/Triggers.php'; // Inclui o arquivo de conexão

session_start(); // Inicia a sessão

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $query = "SELECT * FROM login WHERE usuario = :usuario AND senha = :senha";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':senha', $senha);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $_SESSION['usuario'] = $resultado['usuario'];
        header('Location: Dashboard.php'); // Redireciona para a página do Dashboard após o login
        exit();
    } else {
        $erro = "Usuário ou senha inválidos";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Página de Login</title>
    <link rel="stylesheet" href="./css/index.css">
</head>

<body>
    <div class="login-container">
        <h2>Login</h2>
        <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
        <form method="POST" action="">
            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario">

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha">

            <input type="submit" value="Entrar">
        </form>
    </div>
</body>

</html>