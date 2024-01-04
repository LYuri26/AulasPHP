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

    header('Location: Funcionarios.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Confirmação de Exclusão</title>
</head>

<body>
    <h2>Confirmação de Exclusão</h2>

    <p>Você tem certeza que deseja excluir o funcionário <?php echo $funcionario['nome']; ?>?</p>

    <form method="POST" action="">
        <input type="submit" name="confirmar" value="Confirmar">
        <a href="Funcionarios.php">Cancelar</a>
    </form>
</body>

</html>
