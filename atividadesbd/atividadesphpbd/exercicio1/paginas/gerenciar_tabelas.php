<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados e funções CRUD
include '../gerenciamento/conexao.php';
include '../gerenciamento/crud.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['nome'])) {
    header("Location: ../index.html");
    exit();
}

// Processamento do formulário de cadastro, se houver
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['acao'])) {
    $acao = $_POST['acao'];

    if ($acao == 'cadastrar') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $data_nascimento = $_POST['data_nascimento'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $pais = $_POST['pais'];

        if (cadastrarFan($pdo, $nome, $email, $data_nascimento, $cidade, $estado, $pais)) {
            $mensagem = "Fã cadastrado com sucesso!";
        } else {
            $mensagem = "Erro ao cadastrar o fã.";
        }
    }
}

// Obtém todos os fãs da tabela
$fas = getFans($pdo);
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Tabelas - Linkin Park Fans</title>
    <link rel="stylesheet" href="../estilo/gerenciar_tabelas.css">
</head>

<body>
    <div class="container">
        <h2>Gerenciar Tabelas</h2>

        <!-- Formulário para cadastrar novo fã -->
        <h3>Cadastrar Novo Fã</h3>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-cadastro">
            <input type="hidden" name="acao" value="cadastrar">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required><br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br>
            <label for="data_nascimento">Data de Nascimento:</label>
            <input type="date" id="data_nascimento" name="data_nascimento" required><br>
            <label for="cidade">Cidade:</label>
            <input type="text" id="cidade" name="cidade"><br>
            <label for="estado">Estado:</label>
            <input type="text" id="estado" name="estado"><br>
            <label for="pais">País:</label>
            <input type="text" id="pais" name="pais" required><br>
            <button type="submit" class="btn-cadastrar">Cadastrar</button>
        </form>

        <!-- Tabela de fãs existentes -->
        <h3>Fãs Cadastrados</h3>
        <table class="tabela-fas">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Data de Nascimento</th>
                    <th>Cidade</th>
                    <th>Estado</th>
                    <th>País</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($fas); $i++) : ?>
                    <tr>
                        <td><?php echo $fas[$i]['id']; ?></td>
                        <td><?php echo $fas[$i]['nome']; ?></td>
                        <td><?php echo $fas[$i]['email']; ?></td>
                        <td><?php echo $fas[$i]['data_nascimento']; ?></td>
                        <td><?php echo $fas[$i]['cidade']; ?></td>
                        <td><?php echo $fas[$i]['estado']; ?></td>
                        <td><?php echo $fas[$i]['pais']; ?></td>
                        <td>
                            <form action="./editar_tabelas.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $fas[$i]['id']; ?>">
                                <button type="submit" class="btn-editar">Editar</button>
                            </form>
                            <form action="./excluir_tabelas.php" method="post">
                                <input type="hidden" name="id" value="<?php echo $fas[$i]['id']; ?>">
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