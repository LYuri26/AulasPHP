<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados e funções CRUD
include '../gerenciamento/conexao.php'; // Adicionado: Inclui o arquivo de conexão com o banco de dados
include '../gerenciamento/crud.php'; // Adicionado: Inclui o arquivo com funções CRUD

// Verifica se o usuário está logado
if (!isset($_SESSION['cantor'])) { // Mudança: Condição alterada para verificar 'cantor' na sessão
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../index.html");
    exit();
}

// Inicializa variáveis para armazenar os dados da música e a mensagem de feedback
$id = $musica = $album = $ano = $descricao = ''; // Adicionado: Inicializa variáveis para os dados da música
$mensagem = '';
// Verifica se foi recebido um ID válido via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];

    // Obtém os dados da música pelo ID
    $musicas = getMusicasById($pdo, $id); // Mudança: Chamada para obter dados da música pelo ID

    // Verifica se encontrou a música pelo ID
    if ($musicas) {
        // Atribui os valores obtidos aos campos do formulário
        $musica = $musicas['musica'];
        $album = $musicas['album'];
        $ano = $musicas['ano'];
        $descricao = $musicas['descricao'];
    } else {
        // Se não encontrou, redireciona para a página de gerenciar_tabelas.php
        header("Location: ./gerenciar_tabelas.php");
        exit();
    }
}

// Processamento do formulário de edição
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao']) && $_POST['acao'] == 'editar') {
    // Obtém os dados do formulário
    $id = $_POST['id'];
    $musica = $_POST['musica'];
    $album = $_POST['album'];
    $ano = $_POST['ano'];
    $descricao = $_POST['descricao'];

    // Chama a função para editar a música
    if (editarMusicas($pdo, $id, $musica, $album, $ano, $descricao)) {
        // Define a mensagem de sucesso
        $mensagem = 'Música editada com sucesso!';
        // Redireciona para a página de gerenciar tabelas após a edição bem-sucedida
        header("Location: ./gerenciar_tabelas.php");
        exit();
    } else {
        // Define a mensagem de erro, se houver
        $mensagem = 'Erro ao editar a música. Verifique os dados e tente novamente.';
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar música - Linkin Park músicas</title>
    <link rel="stylesheet" href="../estilo/editar_tabelas.css">
</head>

<body>
    <div class="container">
        <h2>Editar música</h2>

        <!-- Exibição da mensagem de feedback, se houver -->
        <?php if (!empty($mensagem)) : ?>
            <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div> <!-- Exibe a mensagem de feedback após a edição da música -->
        <?php endif; ?>

        <!-- Formulário para editar a música -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="hidden" name="acao" value="editar"> <!-- Campo oculto para indicar a ação de edição -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>"> <!-- Campo oculto com o ID da música -->
            <div class="form-cadastro">
                <label for="musica">Música:</label>
                <input type="text" id="musica" name="musica" value="<?php echo htmlspecialchars($musica); ?>" required><br> <!-- Campo para editar o nome da música -->
                <label for="album">Álbum:</label>
                <input type="text" id="album" name="album" value="<?php echo htmlspecialchars($album); ?>" required><br> <!-- Campo para editar o álbum da música -->
                <label for="ano">Ano:</label>
                <input type="date" id="ano" name="ano" value="<?php echo htmlspecialchars($ano); ?>" required><br> <!-- Campo para editar o ano de lançamento da música -->
                <label for="descricao">Descrição:</label>
                <input type="text" id="descricao" name="descricao" value="<?php echo htmlspecialchars($descricao); ?>"><br> <!-- Campo para editar a descrição da música -->
                <button type="submit" class="btn-confirmar">Confirmar Edição</button> <!-- Botão para confirmar a edição da música -->
            </div>
        </form>

        <!-- Voltar para a página de gerenciar tabelas -->
        <br>
        <a href="./gerenciar_tabelas.php" class="btn-voltar">Voltar para Gerenciar Tabelas</a> <!-- Link para voltar à página de gerenciamento de tabelas -->
    </div>
</body>

</html>