<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
include '../gerenciamento/conexao.php';
// Inclui as funções CRUD
include '../gerenciamento/crud.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['nome'])) {
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../index.html");
    exit();
}

// Verifica se foi recebido um ID válido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    // Se não houver ID válido, redireciona de volta para a página de gerenciar_tabelas.php
    header("Location: gerenciar_tabelas.php");
    exit();
}

// Obtém os dados do fã pelo ID
$fan = getFanById($pdo, $id);

// Verifica se encontrou o fã pelo ID
if (!$fan) {
    // Se não encontrou, redireciona para a página de gerenciar_tabelas.php
    header("Location: gerenciar_tabelas.php");
    exit();
}

// Processamento do formulário de confirmação de exclusão
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmacao'])) {
    if ($_POST['confirmacao'] === 'sim') {
        // Chama a função para excluir o fã
        if (excluirFan($pdo, $id)) {
            // Exclusão bem-sucedida, redireciona para a página de gerenciar_tabelas.php
            header("Location: gerenciar_tabelas.php");
            exit();
        } else {
            echo "Erro ao excluir o fã.";
        }
    } elseif ($_POST['confirmacao'] === 'nao') {
        // Se escolher 'não', apenas redireciona para a página de gerenciar_tabelas.php
        header("Location: gerenciar_tabelas.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Fã - Linkin Park Fans</title>
    <link rel="stylesheet" href="../estilo/excluir_tabelas.css">
</head>

<body>
    <div class="container">
        <h2>Excluir Fã</h2>

        <!-- Mostra os dados do fã e pergunta pela confirmação de exclusão -->
        <div class="dados-fa">
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($fan['nome']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($fan['email']); ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($fan['data_nascimento']); ?></p>
            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($fan['cidade']); ?></p>
            <p><strong>Estado:</strong> <?php echo htmlspecialchars($fan['estado']); ?></p>
            <p><strong>País:</strong> <?php echo htmlspecialchars($fan['pais']); ?></p>
        </div>

        <!-- Formulário para confirmar a exclusão -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <button type="submit" name="confirmacao" value="sim" class="btn-excluir">Sim, Excluir</button>
            <button type="submit" name="confirmacao" value="nao" class="btn-cancelar">Não, Cancelar</button>
        </form>

        <!-- Voltar para a página de gerenciar tabelas -->
        <br>
        <a href="./gerenciar_tabelas.php" class="btn-voltar">Voltar para Gerenciar Tabelas</a>
    </div>
</body>

</html>