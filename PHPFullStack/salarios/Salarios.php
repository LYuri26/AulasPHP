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

// Função para inserir salário
function inserirSalario($conexao, $idFuncionario, $salario, $dataReajuste, $tipoReajuste)
{
    $query = "INSERT INTO historico_salarios (id_funcionario, salario_atual, data_reajuste, tipo_reajuste) VALUES (:id_funcionario, :salario, :data_reajuste, :tipo_reajuste)";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':id_funcionario', $idFuncionario);
    $stmt->bindParam(':salario', $salario);
    $stmt->bindParam(':data_reajuste', $dataReajuste);
    $stmt->bindParam(':tipo_reajuste', $tipoReajuste);
    return $stmt->execute();
}

// Renderizar a página
$funcionarios = buscarFuncionarios($conexao);
$error = '';

// Inserir salário se o formulário for enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['inserir'])) {
    $idFuncionario = $_POST['id'];
    $salario = $_POST['salario'];
    $dataReajuste = $_POST['data_reajuste'];
    $tipoReajuste = $_POST['tipo_reajuste'];

    // Verificar se o ID do funcionário existe
    $idsFuncionarios = array_column($funcionarios, 'id');
    if (!in_array($idFuncionario, $idsFuncionarios)) {
        $error = "ID de funcionário inválido!";
    } else {
        $inserido = inserirSalario($conexao, $idFuncionario, $salario, $dataReajuste, $tipoReajuste);
        if ($inserido) {
            header('Location: Salarios.php');
            exit();
        } else {
            $error = "Erro ao inserir o salário!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Salários</title>
    <link rel="stylesheet" type="text/css" href="../css/Salarios.css">
</head>

<body>
    <div class="header">
        <h2>Gerenciamento de Salários</h2>
        <div class="button-container">
            <!-- Botão para voltar ao Dashboard -->
            <a class="voltar-button" href="../Dashboard.php">Voltar ao Dashboard</a>
            <!-- Botão para sair -->
            <a class="sair-button" href="../logout.php">Sair</a>
        </div>
    </div>
    <!-- Formulário para inserir salário -->
    <h3>Inserir Salário</h3>
    <form method="POST" action="">
        <label for="id">ID do Funcionário:</label>
        <input type="number" id="id" name="id" required>

        <label for="salario">Salário Atual:</label>
        <input type="number" id="salario" name="salario" step="0.01" required>

        <label for="data_reajuste">Data do Reajuste:</label>
        <input type="date" id="data_reajuste" name="data_reajuste" required>

        <label for="tipo_reajuste">Tipo do Reajuste:</label>
        <input type="text" id="tipo_reajuste" name="tipo_reajuste" required><br>

        <input class="insert-button" type="submit" name="inserir" value="Inserir">
    </form>

    <!-- Mensagem de erro -->
    <?php if (!empty($error)) : ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php endif; ?>

    <!-- Tabela de salários -->
    <h3>Tabela de Salários</h3>
    <table>
        <thead>
            <tr>
                <th>ID do Funcionário</th>
                <th>Salário Atual</th>
                <th>Data do Reajuste</th>
                <th>Tipo do Reajuste</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $query = "SELECT * FROM historico_salarios";
            $stmt = $conexao->query($query);
            $salarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($salarios as $salario) {
                echo "<tr>";
                echo "<td>" . $salario['id_funcionario'] . "</td>";
                echo "<td>" . "R$" . $salario['salario_atual'] . "</td>";
                echo "<td>" . $salario['data_reajuste'] . "</td>";
                echo "<td>" . $salario['tipo_reajuste'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

    <!-- Botões para editar e deletar -->
    <div class="button-container">
        <a class="edit-button" href="EditarSalario.php">Editar Salário</a>
        <a class="delete-button" href="DeletarSalario.php">Deletar Salário</a>
    </div>
</body>

</html>
