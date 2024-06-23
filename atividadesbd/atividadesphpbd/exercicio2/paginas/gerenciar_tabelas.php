<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados e funções CRUD
include '../gerenciamento/conexao.php';
include '../gerenciamento/crud.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['cantor'])) {
    // Usuário não está logado, redireciona para a página de login
    header("Location: ../index.html");
    exit();
}

// Processamento do formulário de cadastro, se houver
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    if ($acao == 'cadastrar') {
        // Obtém os dados do formulário
        $musica = $_POST['musica']; // Alteração: Nome da variável alterado de $nome para $musica
        $album = $_POST['album']; // Alteração: Nome da variável alterado de $email para $album
        $ano = $_POST['ano']; // Nome da variável manteve-se o mesmo
        $descricao = $_POST['descricao']; // Nome da variável manteve-se o mesmo

        // Chama a função para cadastrar a música
        if (cadastrarMusicas($pdo, $musica, $album, $ano, $descricao)) { // Mudança: Função alterada de cadastrarFan para cadastrarMusicas
            $mensagem = "Música cadastrada com sucesso!"; // Mensagem de sucesso manteve-se o mesmo
        } else {
            $mensagem = "Erro ao cadastrar a música."; // Mensagem de erro manteve-se o mesmo
        }
    }
}

// Obtém todas as músicas da tabela
$musicas = getMusicas($pdo); // Alteração: Nome da variável alterado de $fas para $musicas
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tabelas - Linkin Park Músicas</title>
    <link rel="stylesheet" href="../estilo/gerenciar_tabelas.css">
</head>

<body>
    <div class="container">
        <h2>Gerenciar Tabelas</h2>

        <!-- Formulário para cadastrar nova música -->
        <h3>Cadastrar Nova Música</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-cadastro">
            <input type="hidden" name="acao" value="cadastrar">
            <label for="musica">Música:</label>
            <input type="text" id="musica" name="musica" required><br>
            <label for="album">Album:</label>
            <input type="text" id="album" name="album" required><br>
            <label for="ano">Ano:</label>
            <input type="date" id="ano" name="ano" required><br>
            <label for="descricao">Descrição:</label> <!-- Correção: Corrigido o nome do campo para "Descrição" -->
            <input type="text" id="descricao" name="descricao"><br>
            <button type="submit" class="btn-cadastrar">Cadastrar</button>
        </form>

        <!-- Tabela de Músicas cadastradas -->
        <h3>Músicas Cadastradas</h3>
        <table class="tabela-musica">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Música</th>
                    <th>Álbum</th> <!-- Alteração: Corrigido o nome do cabeçalho para "Álbum" -->
                    <th>Ano</th>
                    <th>Descrição</th> <!-- Alteração: Corrigido o nome do cabeçalho para "Descrição" -->
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($musicas); $i++) : ?>
                    <tr>
                        <td><?php echo $musicas[$i]['id']; ?></td>
                        <td><?php echo $musicas[$i]['musica']; ?></td>
                        <td><?php echo $musicas[$i]['album']; ?></td>
                        <td><?php echo $musicas[$i]['ano']; ?></td>
                        <td><?php echo $musicas[$i]['descricao']; ?></td>
                        <td>
                            <!-- Formulário para editar a música -->
                            <form action="./editar_tabelas.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $musicas[$i]['id']; ?>">
                                <button type="submit" class="btn-editar">Editar</button>
                            </form>
                            <!-- Formulário para excluir a música -->
                            <form action="./excluir_tabelas.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $musicas[$i]['id']; ?>">
                                <button type="submit" class="btn-excluir">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endfor; ?>
            </tbody>
        </table>

        <!-- Exibição da mensagem de feedback -->
        <?php if (isset($mensagem)) : ?>
            <div class="mensagem"><?php echo $mensagem; ?></div>
        <?php endif; ?>

        <br>
        <a href="./dashboard.php" class="btn-voltar">Voltar para o Dashboard</a>
    </div>
</body>

</html>