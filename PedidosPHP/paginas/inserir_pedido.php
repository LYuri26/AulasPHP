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
        echo "Erro ao inserir pedido: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../static/css/inserir_pedido.css">
    <script src="../static/js/script.js"></script>
    <title>Inserir Pedido</title>
</head>

<body>
    <header>
        <button id="sair" onclick="confirmRedirect('login')">Sair</button>
        <button onclick="confirmRedirect('principal')" id="sair">Tela Inicial</button>
        <h2>Inserir Pedido</h2>
    </header>
    <div>
        <p>Usuário: <?php echo $usuario_nome; ?></p>
        <p>Cargo: <?php echo $usuario_cargo; ?></p>
    </div>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" onsubmit="return confirmSubmission()">
        <div>
            <label for="nome_material">Nome do Material:</label>
            <input type="text" id="nome_material" name="nome_material" required>
        </div>
        <div>
            <label for="quantidade">Quantidade:</label>
            <input type="number" id="quantidade" name="quantidade" required>
        </div>
        <div>
            <label for="data_solicitacao">Data da Solicitação:</label>
            <?php
            // Obtendo a data atual
            $data_atual = date('Y-m-d');
            ?>
            <input type="date" id="data_solicitacao" name="data_solicitacao" value="<?php echo $data_atual; ?>" required>
        </div>
        <div>
            <label for="status_solicitacao">Status da Solicitação:</label>
            <select id="status_solicitacao" name="status_solicitacao" required>
                <option value="entregue">Entregue</option>
                <option value="aguardando">Aguardando</option>
                <option value="em atraso">Em Atraso</option>
                <option value="cancelado">Cancelado</option>
            </select>
        </div>
        <button type="submit">Enviar</button>
    </form>
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