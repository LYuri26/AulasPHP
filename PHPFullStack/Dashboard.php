<?php
session_start(); // Inicia a sessão

include './DB/Conexao.php'; // Inclui o arquivo de conexão

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
</head>
<body>
    <h2>Bem-vindo ao Dashboard, <?php echo $nomeUsuario; ?></h2>
    <h3>Selecione uma opção:</h3>
    <ul>
        <li><a href="./Funcionarios/Funcionarios.php">Gerenciamento de Funcionários</a></li>
        <li><a href="Salarios.php">Histórico de Salários</a></li>
        <li><a href="logout.php">Sair</a></li>
    </ul>
</body>
</html>
