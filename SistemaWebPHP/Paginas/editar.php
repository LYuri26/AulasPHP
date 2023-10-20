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
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['numero'])) {
    $numero = $_GET['numero']; // Obtém o número da atividade a ser editada

    // Monta a consulta SQL para obter os detalhes da atividade
    $sql = "SELECT * FROM atividades WHERE numero = $numero";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $atividade = mysqli_fetch_assoc($result); // Obtém os detalhes da atividade
    } else {
        die("Erro na consulta SQL: " . mysqli_error($conn)); // Exibe mensagem de erro em caso de falha na consulta
    }
} else {
    header("Location: inicio.php"); // Redireciona de volta para a página inicial se não houver um número de atividade válido
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['editar_atividade'])) {
    $atividade_nome = $_POST['nome']; // Obtém o nome da atividade do formulário
    $atividade_funcionario = $_POST['funcionario']; // Obtém o funcionário associado à atividade do formulário
    $atividade_detalhes = $_POST['detalhes']; // Obtém os detalhes da atividade do formulário

    // Monta a consulta SQL para editar a atividade no banco de dados
    $sql = "UPDATE atividades SET nome = '$atividade_nome', funcionario = '$atividade_funcionario', detalhes = '$atividade_detalhes' WHERE numero = $numero";

    // Executa a consulta SQL
    if (mysqli_query($conn, $sql)) {
        header("Location: inicio.php"); // Redireciona para a página inicial após a edição bem-sucedida
    } else {
        echo "Erro ao editar atividade: " . mysqli_error($conn); // Exibe mensagem de erro em caso de falha na consulta
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css">
    <meta charset="UTF-8">
    <title>Editar Atividade</title>
</head>

<body>
    <h1>Editar Atividade</h1>

    <form action="" method="post">
        Nome da Atividade: <input type="text" name="nome" value="<?php echo $atividade['nome']; ?>"><br>
        Funcionário: <input type="text" name="funcionario" value="<?php echo $atividade['funcionario']; ?>"><br>
        Detalhes: <input type="text" name="detalhes" value="<?php echo $atividade['detalhes']; ?>"><br>
        <input type="submit" name="editar_atividade" value="Salvar Edições">
    </form>
</body>

</html>