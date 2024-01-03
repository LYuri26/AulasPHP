<?php
include './DB/Conexao.php'; // Inclui o arquivo de conexão
include './DB/Login.php'; // Inclui o arquivo de conexão
include './DB/Tabelas.php'; // Inclui o arquivo de conexão

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
</head>
<body>
    <h2>Login</h2>
    <?php if (isset($erro)) echo "<p>$erro</p>"; ?>
    <form method="POST" action="">
        <label for="usuario">Usuário:</label><br>
        <input type="text" id="usuario" name="usuario"><br><br>
        
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha"><br><br>
        
        <input type="submit" value="Entrar">
    </form>
</body>
</html>
