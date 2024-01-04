<?php
session_start();

include '../db/Conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../Index.php');
    exit();
}

// Função para buscar todos os funcionários
function buscarFuncionarios($conexao)
{
    $query = "SELECT * FROM funcionarios";
    $stmt = $conexao->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Renderizar a página
$funcionarios = buscarFuncionarios($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Funcionários</title>
</head>

<body>
    <h2>Gerenciamento de Funcionários</h2>

    <!-- Botão para voltar ao Dashboard -->
    <a href="../Dashboard.php">Voltar ao Dashboard</a>
    <!-- Botão para sair -->
    <a href="logout.php">Sair</a>

    <!-- Formulário para inserir novo funcionário -->
    <h3>Inserir Funcionário</h3>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome"><br><br>

        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo"><br><br>

        <label for="departamento">Departamento:</label>
        <input type="text" id="departamento" name="departamento"><br><br>

        <input type="submit" name="inserir" value="Inserir">
    </form>

    <!-- Lista de funcionários -->
    <h3>Lista de Funcionários</h3>
    <ul>
        <?php foreach ($funcionarios as $funcionario) : ?>
            <li>
                <?php echo $funcionario['nome']; ?> -
                <a href="EditarFuncionario.php?id=<?php echo $funcionario['id']; ?>">Editar</a> |
                <a href="DeletarFuncionario.php?id=<?php echo $funcionario['id']; ?>">Deletar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>
