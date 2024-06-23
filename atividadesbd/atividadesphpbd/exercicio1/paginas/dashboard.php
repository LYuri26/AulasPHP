<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['nome'])) {
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Linkin Park Fans</title>
    <link rel="stylesheet" href="../estilo/dashboard.css">
</head>

<body>
    <div class="container">
        <h2>Bem-vindo ao Dashboard!</h2>
        <p>Olá, <?php echo htmlspecialchars($_SESSION['nome']); ?>!</p>
        <p>Aqui você pode acessar suas informações e configurações.</p>
        <a href="./gerenciar_tabelas.php" class="btn">Gerenciar Tabelas</a>
        <br><br>
        <a href="../gerenciamento/logout.php" class="btn btn-logout">Sair</a>
    </div>
</body>

</html>