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

// Verificando se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capturando os dados do formulário
    $funcionario_id = $_SESSION['usuario_id'];
    $nome_material = $_POST['nome_material'];
    $quantidade = $_POST['quantidade'];
    $data_solicitacao = $_POST['data_solicitacao']; // Usando a data fornecida pelo usuário
    $status_solicitacao = $_POST['status_solicitacao'];

    try {
        // Query para inserir um novo pedido no banco de dados
        $query = "INSERT INTO solicitacoes (funcionario_id, nome_material, quantidade, data_solicitacao, status_solicitacao) VALUES (:funcionario_id, :nome_material, :quantidade, :data_solicitacao, :status_solicitacao)";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':funcionario_id', $funcionario_id, PDO::PARAM_INT);
        $statement->bindParam(':nome_material', $nome_material, PDO::PARAM_STR);
        $statement->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $statement->bindParam(':data_solicitacao', $data_solicitacao, PDO::PARAM_STR);
        $statement->bindParam(':status_solicitacao', $status_solicitacao, PDO::PARAM_STR);
        $statement->execute();

        // Redirecionando para a página de tabela de solicitações após a inserção bem-sucedida
        header("Location: tabela_solicitacoes.php");
        exit();
    } catch (PDOException $e) {
        // Em caso de erro, exibir mensagem de erro
        echo '<div class="alert alert-danger text-center">Erro ao inserir pedido: ' . $e->getMessage() . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../static/css/inserir_pedido.css">
    <script src="../static/js/script.js"></script>
    <title>Inserir Pedido</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <header class="bg-secondary text-white py-3">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0">Inserir Pedido</h2>
                <div class="d-flex gap-2">
                    <button onclick="confirmRedirect('principal')" class="btn btn-success">
                        Tela Inicial
                    </button>
                    <button onclick="confirmRedirect('login')" class="btn btn-success">
                        Sair
                    </button>
                </div>
            </div>
    </header>

    <div class="container text-center my-3">
        <div class="bg-white p-3 rounded shadow-sm d-inline-block">
            <p class="mb-1"><strong>Usuário:</strong> <?php echo $usuario_nome; ?></p>
            <p class="mb-0"><strong>Cargo:</strong> <?php echo $usuario_cargo; ?></p>
        </div>
    </div>

    <main class="container my-auto">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST"
                    onsubmit="return confirmSubmission()" class="bg-white p-4 rounded shadow">
                    <div class="mb-3">
                        <label for="nome_material" class="form-label">Nome do Material:</label>
                        <input type="text" class="form-control" id="nome_material" name="nome_material" required>
                    </div>
                    <div class="mb-3">
                        <label for="quantidade" class="form-label">Quantidade:</label>
                        <input type="number" class="form-control" id="quantidade" name="quantidade" required>
                    </div>
                    <div class="mb-3">
                        <label for="data_solicitacao" class="form-label">Data da Solicitação:</label>
                        <?php
                        // Obtendo a data atual
                        $data_atual = date('Y-m-d');
                        ?>
                        <input type="date" class="form-control" id="data_solicitacao" name="data_solicitacao"
                            value="<?php echo $data_atual; ?>" required>
                    </div>
                    <div class="mb-4">
                        <label for="status_solicitacao" class="form-label">Status da Solicitação:</label>
                        <select class="form-select" id="status_solicitacao" name="status_solicitacao" required>
                            <option value="entregue">Entregue</option>
                            <option value="aguardando">Aguardando</option>
                            <option value="em atraso">Em Atraso</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-secondary w-100 py-2">Enviar</button>
                </form>
            </div>
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