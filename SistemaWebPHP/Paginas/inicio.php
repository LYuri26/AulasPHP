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

$login = $_SESSION['login'];

function listaratividades()
{
    global $conn, $login;

    $sql = "SELECT numero, funcionario, nome as atividade FROM atividades WHERE funcionario = '$login'";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Erro na consulta SQL: " . mysqli_error($conn));
    }

    $atividades = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $atividades[] = $row;
    }

    return $atividades;
}

$atividades = listaratividades();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css">
    <meta charset="UTF-8">
    <title>Página Principal do Funcionário</title>
</head>

<body>

    <div class="header">
        <h1>Bem-vindo, <?php echo $login; ?></h1>
        <a href="sair.php">Sair</a>
    </div>

    <div class="content">
        <h2>Cadastro de Atividades</h2>
        <a href="cadastroatividades.php">Cadastrar</a>

        <h2>Listagem de Atividades</h2>
        <table>
            <tr>
                <th>Número da Atividade</th>
                <th>Funcionário</th>
                <th>Atividade</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($atividades as $atividade) : ?>
                <tr>
                    <td><?php echo $atividade['numero']; ?></td>
                    <td><?php echo $atividade['funcionario']; ?></td>
                    <td><?php echo $atividade['atividade']; ?></td>
                    <td>
                        <form action="excluiratividade.php" method="post">
                            <input type="hidden" name="numero" value="<?php echo $atividade['numero']; ?>">
                            <input type="submit" value="Excluir">
                        </form>
                    </td>
                    <td><a href="visualizaratividade.php?numero=<?php echo $atividade['numero']; ?>">Visualizar</a></td>
                    <td><a href="editar.php?numero=<?php echo $atividade['numero']; ?>">Editar</a></td>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>