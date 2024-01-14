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

// Atualizar o salário se o formulário de edição for submetido
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar'])) {
    $idSalario = $_POST['id_salario'];
    $novoSalario = $_POST['novo_salario'];
    $novaDataReajuste = $_POST['nova_data_reajuste'];
    $novoTipoReajuste = $_POST['novo_tipo_reajuste'];

    // Atualizar os dados do salário no banco de dados
    $query = "UPDATE historico_salarios 
              SET salario_atual = :novo_salario, 
                  data_reajuste = :nova_data_reajuste, 
                  tipo_reajuste = :novo_tipo_reajuste 
              WHERE id = :id_salario";

    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':novo_salario', $novoSalario);
    $stmt->bindParam(':nova_data_reajuste', $novaDataReajuste);
    $stmt->bindParam(':novo_tipo_reajuste', $novoTipoReajuste);
    $stmt->bindParam(':id_salario', $idSalario);

    if ($stmt->execute()) {
        // Redirecionar após a atualização
        header('Location: Salarios.php');
        exit();
    } else {
        $error = "Erro ao atualizar o registro!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Editar Salário</title>
    <link rel="stylesheet" type="text/css" href="../css/EditarSalario.css">
</head>

<body>
    <div class="header">
        <h2>Editar Salário</h2>
        <div class="button-container">
            <!-- Botão para voltar ao Dashboard -->
            <a class="voltar-button" href="../Dashboard.php">Voltar ao Dashboard</a>
            <!-- Botão para sair -->
            <a class="sair-button" href="../logout.php">Sair</a>
        </div>
    </div>

    <!-- Formulário para pesquisar por ID -->
    <h3>Pesquisar por ID</h3>
    <form method="POST" id="formFuncionarioInicio" action="">
        <label for="id">ID do Salário:</label>
        <input type="number" id="id" name="id" required><br><br>
        <input type="submit" name="pesquisar" value="Pesquisar">
    </form>

    <!-- Exibir dados do salário para edição -->
    <?php if ($salario) : ?>
        <h3>Dados do Salário</h3>
        <form method="POST" id="formFuncionarioFim" action="">
            <!-- Campos de dados do salário -->
            <!-- Substitua esses campos pelos dados que deseja editar -->
            <input type="hidden" name="id_salario" value="<?php echo $salario['id']; ?>">
            Salário Atual: <input type="text" name="novo_salario" id="novo_salario" required value="<?php echo $salario['salario_atual']; ?>"><br><br>
            Data do Reajuste: <input type="date" name="nova_data_reajuste" id="nova_data_reajuste" readonly value="<?php echo $salario['data_reajuste']; ?>"><br><br>
            Tipo do Reajuste: <input type="text" name="novo_tipo_reajuste" id="novo_tipo_reajuste" required value="<?php echo $salario['tipo_reajuste']; ?>"><br><br>
            <!-- Botão para editar -->
            <input type="submit" name="editar" value="Editar">
        </form>
    <?php elseif ($error) : ?>
        <!-- Mensagem de erro -->
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <script src="../js/EditarSalario.js"></script>
</body>

</html>