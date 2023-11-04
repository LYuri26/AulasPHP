<?php
include './DataBase/criar_tabela.php';

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <link rel="stylesheet" href="styles/menu.css">
    <link rel="stylesheet" href="styles/index.css">

</head>

<body>
    <div class="menu-container">
        <header>
            <img src="/Styles/Images/Senai.png" alt="Logo SENAI" class="logo-senai" />
        </header>
        <div class="menu-button-container">
            <a href="/questionario" class="menu-button">Questionário</a>
            <a href="/classificacao" class="menu-button">Classificação</a>
            <a href="/creditos" class="menu-button">Créditos</a>
        </div>
        <footer>
            Jogo desenvolvido pela turma de Desenvolvimento de Sistemas Trilhas de Futuro 02/2022.
        </footer>
    </div>
</body>

</html>