<?php
require_once '../../backend/config/db.php';
require_once '../../backend/clientes.php';
require_once '../../backend/produtos.php';
require_once '../../backend/itens_vendas.php';
require_once '../../backend/movimentacoes_estoque.php';

// Cadastro de venda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $valor_total = $_POST['valor_total'];

    // Inserir a venda na tabela 'vendas'
    $stmt = $conexao->prepare("INSERT INTO vendas (id_cliente, data_venda, valor_total) VALUES (?, NOW(), ?)");
    $stmt->execute([$id_cliente, $valor_total]);
    $id_venda = $conexao->lastInsertId();  // Obtém o ID da última venda inserida

    // Inserir os itens de venda na tabela 'itens_vendas'
    $produtos = $_POST['id_produto'];
    $quantidades = $_POST['quantidade'];
    $precos_unitarios = $_POST['preco_unitario'];

    foreach ($produtos as $index => $id_produto) {
        $quantidade = $quantidades[$index];
        $preco_unitario = $precos_unitarios[$index];

        // Inserir item de venda
        $stmt_item = $conexao->prepare("INSERT INTO itens_vendas (id_venda, id_produto, quantidade, preco_unitario) VALUES (?, ?, ?, ?)");
        $stmt_item->execute([$id_venda, $id_produto, $quantidade, $preco_unitario]);

        // Movimentar o estoque
        $stmt_estoque = $conexao->prepare("INSERT INTO movimentacoes_estoque (id_produto, quantidade, tipo_movimentacao) VALUES (?, ?, 'saída')");
        $stmt_estoque->execute([$id_produto, $quantidade]);
    }
}

// Listando as vendas e detalhes dos produtos
$query = $conexao->query("
    SELECT v.id, v.id_cliente, v.data_venda, v.valor_total, c.nome AS cliente_nome, 
           p.nome AS produto_nome, iv.quantidade, iv.preco_unitario
    FROM vendas v
    JOIN cadastro_clientes c ON v.id_cliente = c.id
    JOIN itens_vendas iv ON v.id = iv.id_venda
    JOIN cadastro_produtos p ON iv.id_produto = p.id
");
$vendas = $query->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/vendas.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Vendas Realizadas</h1>

        <!-- Formulário de venda -->
        <form method="POST">
            <div class="mb-3">
                <label for="id_cliente" class="form-label">Cliente</label>
                <input type="number" class="form-control" id="id_cliente" name="id_cliente" required>
            </div>
            <div class="mb-3">
                <label for="valor_total" class="form-label">Valor Total</label>
                <input type="number" class="form-control" id="valor_total" name="valor_total" required>
            </div>

            <!-- Itens de venda -->
            <div id="itens-venda">
                <div class="mb-3">
                    <label for="id_produto_1" class="form-label">Produto</label>
                    <input type="number" class="form-control" id="id_produto_1" name="id_produto[]" required>
                </div>
                <div class="mb-3">
                    <label for="quantidade_1" class="form-label">Quantidade</label>
                    <input type="number" class="form-control" id="quantidade_1" name="quantidade[]" required>
                </div>
                <div class="mb-3">
                    <label for="preco_unitario_1" class="form-label">Preço Unitário</label>
                    <input type="number" class="form-control" id="preco_unitario_1" name="preco_unitario[]" required>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Registrar Venda</button>
        </form>

        <!-- Tabela de vendas realizadas -->
        <h3 class="mt-5">Vendas Realizadas</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Venda</th>
                    <th>Cliente</th>
                    <th>Data da Venda</th>
                    <th>Valor Total</th>
                    <th>Produto</th>
                    <th>Quantidade</th>
                    <th>Preço Unitário</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $venda): ?>
                <tr>
                    <td><?= $venda['id'] ?></td>
                    <td><?= $venda['cliente_nome'] ?></td>
                    <td><?= $venda['data_venda'] ?></td>
                    <td>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
                    <td><?= $venda['produto_nome'] ?></td>
                    <td><?= $venda['quantidade'] ?></td>
                    <td>R$ <?= number_format($venda['preco_unitario'], 2, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>