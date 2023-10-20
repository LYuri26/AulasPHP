<?php
session_start(); // Inicia a sessão PHP.

$servername = "localhost"; // Define o nome do servidor do banco de dados.
$username = "root"; // Define o nome de usuário do banco de dados.
$password = ""; // Define a senha do banco de dados.
$database = "saep_database"; // Define o nome do banco de dados.

$conn = mysqli_connect($servername, $username, $password, $database); // Conecta ao banco de dados usando MySQLi.

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error()); // Se a conexão falhar, exibe uma mensagem de erro e encerra o script.
}

if (!isset($_SESSION['login'])) {
    header("Location: index.php"); // Redireciona para a página de login se não houver uma sessão ativa.
    exit(); // Encerra o script.
}

$login = $_SESSION['login']; // Obtém o login do usuário a partir da sessão.

if (isset($_GET['numero'])) {
    $numero_atividade = $_GET['numero']; // Obtém o número da atividade a partir do parâmetro GET.

    $sql = "SELECT * FROM atividades WHERE numero='$numero_atividade'"; // Consulta SQL para obter os detalhes da atividade.
    $result = mysqli_query($conn, $sql); // Executa a consulta.

    if (!$result) {
        die("Erro na consulta SQL: " . mysqli_error($conn)); // Se houver erro na consulta, exibe uma mensagem de erro e encerra o script.
    }

    $atividade = mysqli_fetch_assoc($result); // Obtém os detalhes da atividade.
} else {
    header("Location: inicio.php"); // Se o parâmetro 'numero' não estiver definido, redireciona de volta para a lista de atividades.
    exit(); // Encerra o script.
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css"> <!-- Inclui um arquivo de estilo CSS. -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres da página. -->
    <title>Visualizar Atividade</title> <!-- Define o título da página. -->
</head>

<body>

    <div class="header">
        <h1>Bem-vindo, <?php echo $login; ?></h1> <!-- Exibe o nome do usuário logado. -->
        <a href="index.php">Sair</a> <!-- Link para fazer logout. -->
    </div>

    <div class="content">
        <h2>Detalhes da Atividade</h2>

        <?php if ($atividade) : ?> <!-- Verifica se a atividade foi encontrada. -->
            <p><strong>Número da Atividade:</strong> <?php echo $atividade['numero']; ?></p> <!-- Exibe o número da atividade. -->
            <p><strong>Nome da Atividade:</strong> <?php echo $atividade['nome']; ?></p> <!-- Exibe o nome da atividade. -->
            <p><strong>Funcionário:</strong> <?php echo $atividade['funcionario']; ?></p> <!-- Exibe o nome do funcionário. -->
            <p><strong>Detalhes:</strong> <?php echo $atividade['detalhes']; ?></p> <!-- Exibe os detalhes da atividade. -->
        <?php else : ?>
            <p>Atividade não encontrada.</p> <!-- Exibe uma mensagem se a atividade não for encontrada. -->
        <?php endif; ?>

        <a href="inicio.php">Voltar para a Lista de Atividades</a> <!-- Link para voltar para a lista de atividades. -->
    </div>
</body>

</html>
