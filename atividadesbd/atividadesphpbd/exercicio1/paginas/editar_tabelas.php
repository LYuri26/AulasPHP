<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados e funções CRUD
include '../gerenciamento/conexao.php';
include '../gerenciamento/crud.php';

// Verifica se o usuário está logado
if (!isset($_SESSION['nome'])) {
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../index.html");
    exit();
}

// Inicializa variáveis para armazenar os dados do fã e a mensagem de feedback
$id = $nome = $email = $data_nascimento = $cidade = $estado = $pais = '';
$mensagem = '';

// Verifica se foi recebido um ID válido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Obtém os dados do fã pelo ID
    $fan = getFanById($pdo, $id);

    // Verifica se encontrou o fã pelo ID
    if ($fan) {
        // Atribui os valores obtidos aos campos do formulário
        $nome = $fan['nome'];
        $email = $fan['email'];
        $data_nascimento = $fan['data_nascimento'];
        $cidade = $fan['cidade'];
        $estado = $fan['estado'];
        $pais = $fan['pais'];
    } else {
        // Se não encontrou, redireciona para a página de gerenciar_tabelas.php
        header("Location: gerenciar_tabelas.php");
        exit();
    }
}

// Processamento do formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    // Obtém os dados do formulário
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $data_nascimento = $_POST['data_nascimento'];
    $cidade = $_POST['cidade'];
    $estado = $_POST['estado'];
    $pais = $_POST['pais'];

    // Chama a função para editar o fã
    if (editarFan($pdo, $id, $nome, $email, $data_nascimento, $cidade, $estado, $pais)) {
        // Define a mensagem de sucesso
        $mensagem = 'Fã editado com sucesso!';
        // Redireciona para a página de gerenciar tabelas após a edição bem-sucedida
        header("Location: ./gerenciar_tabelas.php");
        exit();
    } else {
        // Define a mensagem de erro, se houver
        $mensagem = 'Erro ao editar o fã. Verifique os dados e tente novamente.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fã - Linkin Park Fans</title>
    <link rel="stylesheet" href="../estilo/editar_tabelas.css">
</head>

<body>
    <div class="container">
        <h2>Editar Fã</h2>

        <!-- Exibição da mensagem de feedback, se houver -->
        <?php if ($mensagem) : ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <!-- Formulário para editar o fã -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="acao" value="editar">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="form-cadastro">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome); ?>" required><br>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>
                <label for="data_nascimento">Data de Nascimento:</label>
                <input type="date" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($data_nascimento); ?>" required><br>
                <label for="cidade">Cidade:</label>
                <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($cidade); ?>"><br>
                <label for="estado">Estado:</label>
                <input type="text" id="estado" name="estado" value="<?php echo htmlspecialchars($estado); ?>"><br>
                <label for="pais">País:</label>
                <input type="text" id="pais" name="pais" value="<?php echo htmlspecialchars($pais); ?>" required><br>
                <button type="submit" class="btn-confirmar">Confirmar Edição</button>
            </div>
        </form>

        <!-- Voltar para a página de gerenciar tabelas -->
        <br>
        <a href="./gerenciar_tabelas.php" class="btn-voltar">Voltar para Gerenciar Tabelas</a>
    </div>
</body>

</html>