<?php
// Incluindo o arquivo de conexão com o banco de dados
include '../db/db_connect.php';

// Iniciando a sessão
session_start();

// Verificando se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    // Redirecionando para a página de login se o usuário não estiver logado
    header("Location: ../login.php");
    exit();
}

// Obtendo o nome e o cargo do usuário da sessão
$usuario_nome = $_SESSION['usuario_nome'];
$usuario_cargo = $_SESSION['usuario_cargo'];

// Função para sair da sessão
function logout()
{
    session_unset();
    session_destroy();
    header("Location: ../login.php");
    exit();
}

try {
    // Query para selecionar todas as solicitações
    $query = "SELECT * FROM solicitacoes";

    // Preparar e executar a query
    $statement = $pdo->query($query);

    // Obter todas as solicitações como um array associativo
    $solicitacoes = $statement->fetchAll(PDO::FETCH_ASSOC);

    // Exibir as solicitações como JSON no console do navegador
    echo '<script>';
    echo 'console.log("Solicitações: ", ' . json_encode($solicitacoes) . ');';
    echo '</script>';
} catch (PDOException $e) {
    // Em caso de erro, exibir mensagem de erro no console do navegador
    echo '<script>';
    echo 'console.error("Erro ao buscar solicitações: ' . $e->getMessage() . '");';
    echo '</script>';
}

// Verificando se o botão de sair foi clicado
if (isset($_POST['logout'])) {
    logout();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabela de Solicitações</title>
    <link rel="stylesheet" href="../static/css/tabela_solicitacoes.css">
    <script src="../static/js/script.js"></script>
</head>

<body>
    <header>
        <button id="sair" onclick="confirmRedirect('login')">Sair</button>
        <button onclick="confirmRedirect('principal')" id="sair">Tela Inicial</button>
        <h2>Tabela de Solicitações</h2>
    </header>
    <div>
        <p>Usuário: <?php echo $usuario_nome; ?></p>
        <p>Cargo: <?php echo $usuario_cargo; ?></p>
    </div>
    <table>
        <thead>
            <tr>
                <th>ID do Funcionário</th>
                <th>Nome do Material</th>
                <th>Quantidade</th>
                <th>Data da Solicitação</th>
                <th>Status da Solicitação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Loop através das solicitações e exibir cada uma como uma linha na tabela
            foreach ($solicitacoes as $solicitacao) {
                echo '<tr>';
                echo '<td>' . $solicitacao['funcionario_id'] . '</td>';
                echo '<td>' . $solicitacao['nome_material'] . '</td>';
                echo '<td>' . $solicitacao['quantidade'] . '</td>';
                echo '<td>' . $solicitacao['data_solicitacao'] . '</td>';
                echo '<td>' . $solicitacao['status_solicitacao'] . '</td>';
                echo '</tr>';
            }
            ?>
        </tbody>
    </table>
    <footer>
        <div class="contato">
            <p>Entre em contato:</p>
            <p>Email: <a href="mailto:09113875@senaimgdocente.com.br">09113875@senaimgdocente.com.br</a></p>
        </div>
        <div class="informacoes-adicionais">
            <p>&copy; 2024 GrãosBR. Todos os direitos reservados.</p>
            <p>Endereço: Praça Frei Eugênio, R. São Benedito, 85, Uberaba -
                MG, 38010-280</p>
        </div>
    </footer>
</body>

</html>