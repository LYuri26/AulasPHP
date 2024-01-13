<?php
session_start();

include '../db/Conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../Index.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: Funcionarios.php');
    exit();
}

$id = $_GET['id'];

// Buscar informações do funcionário pelo ID
$query = "SELECT * FROM funcionarios WHERE id = :id";
$stmt = $conexao->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    header('Location: Funcionarios.php');
    exit();
}

// Atualizar informações do funcionário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $cargo = $_POST['cargo'];
    $departamento = $_POST['departamento'];

    $query = "UPDATE funcionarios SET nome = :nome, cargo = :cargo, departamento = :departamento WHERE id = :id";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':nome', $nome);
    $stmt->bindParam(':cargo', $cargo);
    $stmt->bindParam(':departamento', $departamento);
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    header('Location: Funcionarios.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" type="text/css" href="../css/EditarFuncionario.css">
</head>

<body>
    <div class="header">
        <h2>Editar Funcionário</h2>
        <div class="button-container">
            <!-- Botão para voltar ao Dashboard -->
            <a class="voltar-button" href="../Dashboard.php">Voltar ao Dashboard</a>
            <!-- Botão para sair -->
            <a class="sair-button" href="../logout.php">Sair</a>
        </div>
    </div>

    <!-- Formulário para atualizar informações do funcionário -->
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" value="<?php echo $funcionario['nome']; ?>"><br><br>

        <label for="cargo">Cargo:</label>
        <input type="text" id="cargo" name="cargo" value="<?php echo $funcionario['cargo']; ?>"><br><br>

        <label for="departamento">Departamento:</label>
        <input type="text" id="departamento" name="departamento" value="<?php echo $funcionario['departamento']; ?>"><br><br>

        <input type="submit" name="atualizar" value="Atualizar">
    </form>

</body>

</html>