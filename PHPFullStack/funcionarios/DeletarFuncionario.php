<?php
session_start();

include '../db/Conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../Index.php');
    exit();
}

// Verificar se o ID foi recebido
if (!isset($_GET['id'])) {
    header('Location: Funcionarios.php');
    exit();
}

$id = $_GET['id'];

// Obter informações do funcionário pelo ID
$query = "SELECT nome FROM funcionarios WHERE id = :id";
$stmt = $conexao->prepare($query);
$stmt->bindParam(':id', $id);
$stmt->execute();
$funcionario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$funcionario) {
    header('Location: Funcionarios.php');
    exit();
}

// Se o formulário de confirmação foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    // Deletar o funcionário
    $queryDelete = "DELETE FROM funcionarios WHERE id = :id";
    $stmtDelete = $conexao->prepare($queryDelete);
    $stmtDelete->bindParam(':id', $id);
    $stmtDelete->execute();

    header('Location:Funcionarios.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Confirmação de Exclusão</title>
    <link rel="stylesheet" type="text/css" href="../css/DeletarFuncionario.css">
</head>

<body>
    <div class="header">
        <h2>Confirmação de Exclusão</h2>
        <div class="button-container">
            <!-- Botão para voltar ao Dashboard -->
            <a class="voltar-button" href="../Dashboard.php">Voltar ao Dashboard</a>
            <!-- Botão para sair -->
            <a class="sair-button" href="../logout.php">Sair</a>
        </div>
    </div>

    <p>Você tem certeza que deseja excluir o funcionário <?php echo $funcionario['nome']; ?>?</p>

    <form method="POST" action="">
        <input type="submit" name="confirmar" value="Confirmar">
        <!-- Botão Cancelar -->
        <button class="cancelar-button" type="button" onclick="window.location.href='Funcionarios.php'">Cancelar</button>
    </form>
</body>

</html>