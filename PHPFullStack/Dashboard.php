<?php
session_start(); // Inicia a sessão

include './db/Conexao.php'; // Inclui o arquivo de conexão

if (!isset($_SESSION['usuario'])) {
    session_destroy(); // Destroi a sessão
    header('Location: Index.php'); // Redireciona para a página de login se não houver sessão ativa
    exit();
}

$nomeUsuario = '';
$usuario = $_SESSION['usuario'];

try {
    $query = "SELECT nome FROM login WHERE usuario = :usuario";
    $stmt = $conexao->prepare($query);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->execute();

    $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($resultado) {
        $nomeUsuario = $resultado['nome'];
    }
} catch (PDOException $e) {
    // Lidar com possíveis erros
    echo "Erro: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" type="text/css" href="./css/Dashboard.css">
</head>

<body>
    <div class="header">
        <h2>Bem-vindo ao Dashboard, <?php echo $nomeUsuario; ?></h2>
        <a href="logout.php" class="sair-button">Sair</a>
    </div>
    <h3>Selecione uma opção:</h3>
    <div class="button-container">
        <a href="./funcionarios/Funcionarios.php" class="dashboard-button">Gerenciamento de Funcionários</a>
        <a href="./salarios/Salarios.php" class="dashboard-button">Gerenciamento de Salários</a>
        <a href="./logfuncionarios/LogFuncionarios.php" class="dashboard-button">Log Funcionários</a>
        <a href="./logsalarios/LogSalarios.php" class="dashboard-button">Log Salários</a>
    </div>
</body>

</html>