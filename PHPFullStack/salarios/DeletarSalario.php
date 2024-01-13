<?php
session_start();

include '../db/Conexao.php';

if (!isset($_SESSION['usuario'])) {
    header('Location: ../Index.php');
    exit();
}

$error = '';
$salario = null;

// Verificar se o formulário foi submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesquisar'])) {
    $id = $_POST['id'];

    // Buscar o salário pelo ID
    $query = "SELECT * FROM historico_salarios WHERE id = :id";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $salario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$salario) {
        $error = "Nenhum registro encontrado para o ID informado!";
    }
}

// Deletar o salário se o formulário de exclusão for submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirmar'])) {
    $idSalario = $_POST['id_salario'];

    // Excluir o registro do salário do banco de dados
    $query = "DELETE FROM historico_salarios WHERE id = :id_salario";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':id_salario', $idSalario);

    if ($stmt->execute()) {
        // Redirecionar após a exclusão
        header('Location: Salarios.php');
        exit();
    } else {
        $error = "Erro ao excluir o registro!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Deletar Salário</title>
    <link rel="stylesheet" type="text/css" href="../css/DeletarSalario.css">
</head>

<body>
    <div class="header">
        <h2>Deletar Salário</h2>
        <div class="button-container">
            <!-- Botão para voltar ao Dashboard -->
            <a class="voltar-button" href="../Dashboard.php">Voltar ao Dashboard</a>
            <!-- Botão para sair -->
            <a class="sair-button" href="../logout.php">Sair</a>
        </div>
    </div>
    <!-- Formulário para pesquisar por ID -->
    <h3>Pesquisar por ID</h3>
    <form method="POST" action="">
        <label for="id">ID do Salário:</label>
        <input type="number" id="id" name="id" required><br><br>
        <input type="submit" name="pesquisar" value="Pesquisar">
    </form>

    <!-- Exibir dados do salário para exclusão -->
    <?php if ($salario) : ?>
        <h3>Dados do Salário</h3>
        <form method="POST" action="">
            <!-- Campos de dados do salário -->
            <input type="hidden" name="id_salario" value="<?php echo $salario['id']; ?>">
            Salário Atual: <?php echo $salario['salario_atual']; ?><br><br>
            Data do Reajuste: <?php echo $salario['data_reajuste']; ?><br><br>
            Tipo do Reajuste: <?php echo $salario['tipo_reajuste']; ?><br><br>
            <!-- Botões para confirmar ou cancelar a exclusão -->
            <input type="submit" name="confirmar" value="Confirmar Exclusão">
            <button class="cancelar-button" type="button" onclick="window.location.href='Salarios.php'">Cancelar</button>

        </form>
    <?php elseif ($error) : ?>
        <!-- Mensagem de erro -->
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

</body>

</html>