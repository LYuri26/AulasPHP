<?php
// Inicia a sessão e conecta ao banco de dados
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$database = "saep_database";

$conn = mysqli_connect($servername, $username, $password, $database);

if (!$conn) {
    die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
}

// Verifica se o usuário está autenticado
if (!isset($_SESSION['login'])) {
    header("Location: Index.php"); // Redireciona para a página de login
    exit();
}

$login = $_SESSION['login'];

// Função para listar atividades (dados estáticos)
function listarAtividades()
{
    return [
        ['numero' => 1, 'nome' => 'Atividade 1'],
        ['numero' => 2, 'nome' => 'Atividade 2'],
        ['numero' => 3, 'nome' => 'Atividade 3']
    ];
}

$atividades = listarAtividades();

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Página Principal do Funcionário</title>
    <link rel="stylesheet" href="/Estilos/Estilos.css"> 
</head>

<body>

    <div class="header">
        <h1>Bem-vindo, <?php echo $login; ?></h1>
        <a href="Index.php">Sair</a>
    </div>

    <div class="content">
        <h2>Cadastro de Atividades</h2>
        <a href="cadastro_atividades.php">Acessar</a> <!-- Adicionar função depois -->

        <h2>Listagem de Atividades</h2>
        <table>
            <tr>
                <th>Número da Atividade</th>
                <th>Nome da Atividade</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($atividades as $atividade) : ?>
                <tr>
                    <td><?php echo $atividade['numero']; ?></td>
                    <td><?php echo $atividade['nome']; ?></td>
                    <td><button onclick="excluirAtividade(<?php echo $atividade['numero']; ?>)">Excluir</button></td>
                    <td><button onclick="visualizarAtividade(<?php echo $atividade['numero']; ?>)">Visualizar</button></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>