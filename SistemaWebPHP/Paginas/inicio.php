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
    header("Location: index.php"); // Se não houver uma sessão de login, redireciona para o arquivo 'index.php'.
    exit(); // Encerra o script.
}

$login = $_SESSION['login']; // Armazena o nome de usuário da sessão em uma variável chamada $login.

function listaratividades()
{
    global $conn, $login; // Permite o uso das variáveis $conn e $login dentro desta função.

    $sql = "SELECT numero, funcionario, nome as atividade FROM atividades WHERE funcionario = '$login'"; // Define a consulta SQL.
    $result = mysqli_query($conn, $sql); // Executa a consulta no banco de dados.

    if (!$result) {
        die("Erro na consulta SQL: " . mysqli_error($conn)); // Se a consulta falhar, exibe uma mensagem de erro e encerra o script.
    }

    $atividades = []; // Cria um array vazio para armazenar as atividades.

    while ($row = mysqli_fetch_assoc($result)) {
        $atividades[] = $row; // Adiciona cada linha do resultado ao array de atividades.
    }

    return $atividades; // Retorna o array de atividades.
}

$atividades = listaratividades(); // Chama a função 'listaratividades' e armazena o resultado na variável $atividades.

?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="/Estilos/inicio.css"> <!-- Inclui um arquivo de estilo CSS -->
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres da página -->
    <title>Página Principal do Funcionário</title> <!-- Define o título da página -->
</head>

<body>

    <div class="header">
        <h1>Bem-vindo, <?php echo $login; ?></h1> <!-- Exibe o nome de usuário da sessão -->
        <a href="sair.php">Sair</a> <!-- Adiciona um link para 'sair.php' -->
    </div>

    <div class="content">
        <h2>Cadastro de Atividades</h2>
        <a href="cadastroatividades.php">Cadastrar</a> <!-- Adiciona um link para 'cadastroatividades.php' -->

        <h2>Listagem de Atividades</h2>
        <table>
            <tr>
                <th>Número da Atividade</th>
                <th>Funcionário</th>
                <th>Atividade</th>
                <th></th>
                <th></th>
            </tr>
            <?php foreach ($atividades as $atividade) : ?> <!-- Intera sobre as atividades -->
                <tr>
                    <td><?php echo $atividade['numero']; ?></td> <!-- Exibe o número da atividade -->
                    <td><?php echo $atividade['funcionario']; ?></td> <!-- Exibe o nome do funcionário -->
                    <td><?php echo $atividade['atividade']; ?></td> <!-- Exibe o nome da atividade -->
                    <td>
                        <form action="excluiratividade.php" method="post">
                            <input type="hidden" name="numero" value="<?php echo $atividade['numero']; ?>">
                            <input type="submit" value="Excluir">
                        </form> <!-- Cria um formulário para excluir atividade -->
                    </td>
                    <td><a href="visualizaratividade.php?numero=<?php echo $atividade['numero']; ?>">Visualizar</a></td> <!-- Adiciona um link para 'visualizaratividade.php' com um parâmetro 'numero' -->
                    <td><a href="editar.php?numero=<?php echo $atividade['numero']; ?>">Editar</a></td> <!-- Adiciona um link para 'editar.php' com um parâmetro 'numero' -->
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>
