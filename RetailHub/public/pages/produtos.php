<?php
require_once '../../backend/config/db.php';
require_once '../../backend/clientes.php';
require_once '../../backend/produtos.php';
require_once '../../backend/vendas.php';
require_once '../../backend/itens_vendas.php';
require_once '../../backend/movimentacoes_estoque.php';

// Cadastro de produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $preco = $_POST['preco'];
    $quantidade = $_POST['quantidade'];

    // Inserir produto
    $stmt = $conexao->prepare("INSERT INTO cadastro_produtos (nome, descricao, preco, quantidade_estoque) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nome, $descricao, $preco, $quantidade]);
}

// Listando os produtos cadastrados
$query = $conexao->query("SELECT * FROM cadastro_produtos");
$produtos = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/produtos.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center">Cadastro de Produtos</h1>

        <!-- Formulário de cadastro -->
        <form method="POST">
            <div class="mb-3">
                <label for="nome" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="descricao" class="form-label">Descrição</label>
                <textarea class="form-control" id="descricao" name="descricao" required></textarea>
            </div>
            <div class="mb-3">
                <label for="preco" class="form-label">Preço</label>
                <input type="number" class="form-control" id="preco" name="preco" required>
            </div>
            <div class="mb-3">
                <label for="quantidade" class="form-label">Quantidade em Estoque</label>
                <input type="number" class="form-control" id="quantidade" name="quantidade" required>
            </div>
            <button type="submit" class="btn btn-primary">Cadastrar</button>
        </form>

        <!-- Tabela de produtos cadastrados -->
        <h3 class="mt-5">Produtos Cadastrados</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produtos as $produto): ?>
                <tr>
                    <td><?= $produto['id'] ?></td>
                    <td><?= $produto['nome'] ?></td>
                    <td><?= $produto['descricao'] ?></td>
                    <td>R$ <?= number_format($produto['preco'], 2, ',', '.') ?></td>
                    <td><?= $produto['quantidade_estoque'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>