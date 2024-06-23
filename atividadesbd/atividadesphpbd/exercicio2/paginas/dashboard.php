<?php
// Inicia a sessão
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['cantor'])) { // Verifica a chave 'cantor' na sessão
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../index.html"); // Redireciona o usuário para a página de login
    exit(); // Termina a execução do script após o redirecionamento
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Linkin Park Músicas</title> <!-- Título da página para o contexto de músicas -->
    <link rel="stylesheet" href="../estilo/dashboard.css"> <!-- Inclui o arquivo de estilo CSS -->
</head>

<body>
    <div class="container">
        <h2>Bem-vindo ao Dashboard!</h2> <!-- Título principal da página -->
        <p>Olá, <?php echo htmlspecialchars($_SESSION['cantor']); ?>!</p> <!-- Exibe o nome do 'cantor' da sessão de forma segura -->
        <p>Aqui você pode acessar suas informações e configurações.</p> <!-- Descrição do que o usuário pode fazer no dashboard -->
        <a href="./gerenciar_tabelas.php" class="btn">Gerenciar Tabelas</a> <!-- Link para gerenciar tabelas -->
        <br><br>
        <a href="../gerenciamento/logout.php" class="btn btn-logout">Sair</a> <!-- Link para efetuar logout -->
    </div>
</body>

</html>