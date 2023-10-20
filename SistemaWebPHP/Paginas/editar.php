<?php
$servername = "localhost"; // Nome do servidor do banco de dados
$username = "root"; // Nome de usuário do banco de dados
$password = ""; // Senha do banco de dados
$database = "saep_database"; // Nome do banco de dados

$conn = mysqli_connect($servername, $username, $password, $database); // Conexão ao banco de dados usando MySQLi

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error()); // Se a conexão falhar, exibe uma mensagem de erro
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_atividade'])) {
    $atividade_nome = $_POST['nome']; // Obtém o nome da atividade do formulário
    $atividade_funcionario = $_POST['funcionario']; // Obtém o funcionário associado à atividade do formulário
    $atividade_detalhes = $_POST['detalhes']; // Obtém os detalhes da atividade do formulário
    $numero = $_POST['numero']; // Obtém o número da atividade

    $sql = "UPDATE atividades SET nome = '$atividade_nome', funcionario = '$atividade_funcionario', detalhes = '$atividade_detalhes' WHERE numero = $numero";

    if (mysqli_query($conn, $sql)) {
        header("Location: inicio.php"); // Redireciona para a página inicial após a edição bem-sucedida
        exit();
    } else {
        echo "Erro ao editar atividade: " . mysqli_error($conn); // Exibe mensagem de erro em caso de falha na consulta
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['numero'])) {
    $numero = $_GET['numero']; // Obtém o número da atividade a ser editada

    $sql = "SELECT * FROM atividades WHERE numero = $numero"; // Consulta SQL para obter os detalhes da atividade
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $atividade = mysqli_fetch_assoc($result); // Obtém os detalhes da atividade
    } else {
        die("Erro na consulta SQL: " . mysqli_error($conn)); // Exibe mensagem de erro em caso de falha na consulta
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css"> <!-- Inclui um arquivo de estilo CSS -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres da página -->
    <title>Editar Atividade</title> <!-- Define o título da página -->
</head>

<body>
    <h1>Editar Atividade</h1> <!-- Título da página -->

    <form action="" method="post">
        <input type="hidden" name="numero" value="<?php echo $atividade['numero']; ?>"> <!-- Campo oculto com o número da atividade -->
        Nome da Atividade: <input type="text" name="nome" value="<?php echo $atividade['nome']; ?>"><br> <!-- Campo para o nome da atividade, com valor preenchido se houver uma atividade selecionada -->
        Funcionário: <input type="text" name="funcionario" value="<?php echo $atividade['funcionario']; ?>"><br> <!-- Campo para o nome do funcionário, com valor preenchido se houver uma atividade selecionada -->
        Detalhes: <input type="text" name="detalhes" value="<?php echo $atividade['detalhes']; ?>"><br> <!-- Campo para os detalhes da atividade, com valor preenchido se houver uma atividade selecionada -->
        <input type="submit" name="editar_atividade" value="Salvar Edições"> <!-- Botão para enviar o formulário -->
    </form>
</body>

</html>
