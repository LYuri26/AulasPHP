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
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/css/tabela_solicitacoes.css">
    <script src="../static/js/script.js"></script>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="bg-secondary text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Tabela de Solicitações</h2>
                <div class="d-flex gap-2">
                    <button onclick="confirmRedirect('principal')" class="btn btn-success">
                        Tela Inicial
                    </button>
                    <button onclick="confirmRedirect('login')" class="btn btn-success">
                        Sair
                    </button>
                </div>
            </div>
        </div>
    </header>

    <div class="container text-center my-3">
        <div class="bg-white p-3 rounded shadow-sm d-inline-block">
            <p class="mb-1"><strong>Usuário:</strong> <?php echo $usuario_nome; ?></p>
            <p class="mb-0"><strong>Cargo:</strong> <?php echo $usuario_cargo; ?></p>
        </div>
    </div>

    <main class="container my-4">
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead class="table-dark">
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
        </div>
    </main>

    <footer class="bg-secondary text-white py-3 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">Entre em contato:</p>
                    <p class="mb-1">Email: <a href="mailto:09113875@senaimgdocente.com.br"
                            class="text-white">09113875@senaimgdocente.com.br</a></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1">&copy; 2024 GrãosBR. Todos os direitos reservados.</p>
                    <p class="mb-0">Endereço: Praça Frei Eugênio, R. São Benedito, 85, Uberaba - MG, 38010-280</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>