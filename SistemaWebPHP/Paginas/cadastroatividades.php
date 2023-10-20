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

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Verifica se a requisição foi feita via POST.
    $atividade_nome = $_POST['nome']; // Obtém o nome da atividade do formulário.
    $atividade_detalhes = $_POST['detalhes']; // Obtém os detalhes da atividade do formulário.

    // Monta a consulta SQL para inserir a nova atividade no banco de dados.
    $sql = "INSERT INTO atividades (nome, funcionario, detalhes) VALUES ('$atividade_nome', '$login', '$atividade_detalhes')";

    // Executa a consulta SQL.
    if (mysqli_query($conn, $sql)) {
        header("Location: inicio.php"); // Redireciona para a página inicial após o cadastro bem-sucedido.
    } else {
        echo "Erro ao cadastrar atividade: " . mysqli_error($conn); // Exibe mensagem de erro em caso de falha na consulta.
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css"> <!-- Inclui um arquivo de estilo CSS. -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres da página. -->
    <title>Cadastro de Atividade</title> <!-- Define o título da página. -->
</head>

<body>
    <form action="" method="post"> <!-- Formulário para cadastrar a atividade. O action está vazio, o que indica que o formulário será submetido para a própria página. -->
        Nome da Atividade: <input type="text" name="nome"><br> <!-- Campo para inserir o nome da atividade. -->
        Detalhes: <input type="text" name="detalhes"><br> <!-- Campo para inserir os detalhes da atividade. -->
        <input type="submit" value="Cadastrar"> <!-- Botão de envio do formulário. -->
    </form>
</body>

</html>
