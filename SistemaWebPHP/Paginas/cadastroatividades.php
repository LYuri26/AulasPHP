<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "saep_database";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

if (!isset($_SESSION['login'])) {
    header("Location: index.php"); // Redireciona para a página de login se não houver uma sessão ativa
    exit();
}

$login = $_SESSION['login']; // Obtém o login do usuário a partir da sessão

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se a requisição foi feita via POST
    $atividade_nome = $_POST['nome']; // Obtém o nome da atividade do formulário
    $atividade_detalhes = $_POST['detalhes']; // Obtém os detalhes da atividade do formulário

    // Monta a consulta SQL para inserir a nova atividade no banco de dados
    $sql = "INSERT INTO atividades (nome, funcionario, detalhes) VALUES ('$atividade_nome', '$login', '$atividade_detalhes')";

    // Executa a consulta SQL
    if (mysqli_query($conn, $sql)) {
        header("Location: inicio.php"); // Redireciona para a página inicial após o cadastro bem-sucedido
    } else {
        echo "Erro ao cadastrar atividade: " . mysqli_error($conn); // Exibe mensagem de erro em caso de falha na consulta
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css">
    <meta charset="UTF-8">
    <title>Cadastro de Atividade</title>
</head>

<body>
    <form action="" method="post"> <!-- Formulário para cadastrar a atividade -->
        Nome da Atividade: <input type="text" name="nome"><br> <!-- Campo para inserir o nome da atividade -->
        Detalhes: <input type="text" name="detalhes"><br> <!-- Campo para inserir os detalhes da atividade -->
        <input type="submit" value="Cadastrar"> <!-- Botão de envio do formulário -->
    </form>
</body>

</html>