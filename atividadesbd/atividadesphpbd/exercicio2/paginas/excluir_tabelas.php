<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
include '../gerenciamento/conexao.php'; // Adicionado: Inclui o arquivo de conexão com o banco de dados

// Inclui as funções CRUD
include '../gerenciamento/crud.php'; // Adicionado: Inclui o arquivo com funções CRUD

// Verifica se o usuário está logado
if (!isset($_SESSION['cantor'])) {
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../index.html");
    exit();
}

// Verifica se foi recebido um ID válido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
} else {
    // Se não houver ID válido, redireciona de volta para a página de gerenciar_tabelas.php
    header("Location: ./gerenciar_tabelas.php");
    exit();
}

// Obtém os dados do fã pelo ID
$musica = getMusicasById($pdo, $id); // Mudança: Chamada para função getMusicasById ao invés de getFanById

// Verifica se encontrou o fã pelo ID
if (!$musica) {
    // Se não encontrou, redireciona para a página de gerenciar_tabelas.php
    header("Location: ./gerenciar_tabelas.php");
    exit();
}

// Processamento do formulário de confirmação de exclusão
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirmacao'])) {
    if ($_POST['confirmacao'] === 'sim') {
        // Chama a função para excluir o fã
        if (excluirMusicas($pdo, $id)) { // Mudança: Chama a função excluirMusicas ao invés de excluirFan
            // Exclusão bem-sucedida, redireciona para a página de gerenciar_tabelas.php
            header("Location: gerenciar_tabelas.php");
            exit();
        } else {
            echo "Erro ao excluir a música.";
        }
    } elseif ($_POST['confirmacao'] === 'nao') {
        // Se escolher 'não', apenas redireciona para a página de gerenciar_tabelas.php
        header("Location: ./gerenciar_tabelas.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Fã - Linkin Park Músicas</title>
    <link rel="stylesheet" href="../estilo/excluir_tabelas.css">
</head>

<body>
    <div class="container">
        <h2>Excluir Fã</h2>

        <!-- Mostra os dados do fã e pergunta pela confirmação de exclusão -->
        <div class="dados-musica">
            <p><strong>Nome:</strong> <?php echo htmlspecialchars($musica['musica']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($musica['album']); ?></p>
            <p><strong>Data de Nascimento:</strong> <?php echo htmlspecialchars($musica['ano']); ?></p>
            <p><strong>Cidade:</strong> <?php echo htmlspecialchars($musica['descricao']); ?></p>
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
