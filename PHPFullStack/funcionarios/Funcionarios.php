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

// Função para inserir um novo funcionário
function inserirFuncionario($conexao, $nome, $cargo, $departamento)
{
    $query = "INSERT INTO funcionarios (nome, cargo, departamento) VALUES (:nome, :cargo, :departamento)";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':departamento', $departamento);
    return $stmt->execute();
}

// Verificar se o formulário foi submetido para inserir um novo funcionário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inserir'])) {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $departamento = $_POST['departamento'];

    if (inserirFuncionario($conexao, $nome, $cargo, $departamento)) {
        header('Location: Funcionarios.php');
        exit();
    } else {
        echo "Erro ao inserir o funcionário!";
    }
}

// Renderizar a página
$funcionarios = buscarFuncionarios($conexao);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Funcionários</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
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
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>Cargo</th>
                <th>Departamento</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($funcionarios as $funcionario) : ?>
                <tr>
                    <td><?php echo $funcionario['nome']; ?></td>
                    <td><?php echo $funcionario['cargo']; ?></td>
                    <td><?php echo $funcionario['departamento']; ?></td>
                    <td>
                        <a href="EditarFuncionario.php?id=<?php echo $funcionario['id']; ?>">Editar</a> |
                        <a href="DeletarFuncionario.php?id=<?php echo $funcionario['id']; ?>">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>
