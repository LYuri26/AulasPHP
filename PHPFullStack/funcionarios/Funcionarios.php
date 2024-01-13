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

    // Verifica se os campos não estão vazios
    if (!empty($nome) && !empty($cargo) && !empty($departamento)) {
        if (inserirFuncionario($conexao, $nome, $cargo, $departamento)) {
            header('Location: Funcionarios.php');
            exit();
        } else {
            $mensagemErro = "Erro ao inserir o funcionário!";
        }
    } else {
        $mensagemErro = "Por favor, preencha todos os campos.";
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
    <link rel="stylesheet" type="text/css" href="../css/Funcionarios.css">
</head>

<body>
    <div class="header">
        <h2>Gerenciamento de Funcionários</h2>
        <div class="button-container">
            <!-- Botão para voltar ao Dashboard -->
            <a class="voltar-button" href="../Dashboard.php">Voltar ao Dashboard</a>
            <!-- Botão para sair -->
            <a class="sair-button" href="../logout.php">Sair</a>
        </div>
    </div>

    <!-- Formulário para inserir novo funcionário -->
    <div class="form-container">
        <h3>Inserir Funcionário</h3>
        <?php if (isset($mensagemErro)) : ?>
            <p style="color: red;"><?php echo $mensagemErro; ?></p>
        <?php endif; ?>
        <form id="formFuncionario" method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br><br>

            <label for="cargo">Cargo:</label>
            <input type="text" id="cargo" name="cargo" required><br><br>

            <label for="departamento">Departamento:</label>
            <input type="text" id="departamento" name="departamento" required><br><br>

            <input class="insert-button" type="submit" name="inserir" value="Inserir">
        </form>
    </div>

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
                        <a class="edit-button" href="EditarFuncionario.php?id=<?php echo $funcionario['id']; ?>">Editar</a>
                        <a class="delete-button" href="DeletarFuncionario.php?id=<?php echo $funcionario['id']; ?>">Deletar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="../js/Funcionarios.js"></script>
</body>

</html>