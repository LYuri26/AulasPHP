<?php
session_start();

include '../DB/Conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: Index.php');
    exit();
}

// Função para buscar todos os funcionários
function buscarFuncionarios($conexao)
{
    $query = "SELECT * FROM funcionarios";
    $stmt = $conexao->query($query);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Inserir funcionário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inserir'])) {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $departamento = $_POST['departamento'];

    $query = "INSERT INTO funcionarios (nome, cargo, departamento) VALUES (:nome, :cargo, :departamento)";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':departamento', $departamento);
    $stmt->execute();

    header('Location: Funcionarios.php');
    exit();
}

// Deletar funcionário
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM funcionarios WHERE id = :id";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: Funcionarios.php');
    exit();
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
                <a href="Funcionarios.php?delete=<?php echo $funcionario['id']; ?>">Deletar</a>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>
