<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Exemplo PHP Completo</title>
</head>

<body>
    <h2>Cadastro de Aluno</h2>
    <form action="processa.php" method="post">
        Nome: <input type="text" name="nome"><br><br>
        Idade: <input type="number" name="idade"><br><br>
        Nota 1: <input type="number" name="nota1" step="0.01"><br><br>
        Nota 2: <input type="number" name="nota2" step="0.01"><br><br>
        <input type="submit" value="Enviar">
    </form>
</body>

</html>