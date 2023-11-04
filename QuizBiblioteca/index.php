<!DOCTYPE html>
<html>

<head>
    <title>Menu</title>
</head>

<body>

    <?php
    include './BancoDeDados/criartabela.php'; // Chama a criação da tabela automaticamente ao carregar a página
    ?>

    <h1>Menu</h1>

    <form action="./Paginas/quiz.php">
        <input type="submit" value="Quiz">
    </form>

    <form action="./Paginas/classificacao.php">
        <input type="submit" value="Classificação">
    </form>

    <form action="./Paginas/classificacao.php">
        <input type="submit" value="Créditos">
    </form>

</body>

</html>