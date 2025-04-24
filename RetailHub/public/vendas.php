<?php
require_once '../backend/config/db.php';
require_once '../backend/clientes.php';
require_once '../backend/produtos.php';
require_once '../backend/vendas.php';

// Cadastro de venda
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cliente = $_POST['id_cliente'];
    $valor_total = $_POST['valor_total'];
    $conexao->exec("INSERT INTO vendas (id_cliente, data_venda, valor_total) VALUES ('$id_cliente', NOW(), '$valor_total')");
}

// Listando as vendas
$query = $conexao->query("SELECT * FROM vendas");
$vendas = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/vendas.css]" rel="stylesheet">
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
            <button type="submit" class="btn btn-primary">Registrar Venda</button>
        </form>

        <!-- Tabela de vendas realizadas -->
        <h3 class="mt-5">Vendas Realizadas</h3>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Cliente</th>
                    <th>Data</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($vendas as $venda): ?>
                    <tr>
                        <td><?= $venda['id'] ?></td>
                        <td><?= $venda['id_cliente'] ?></td>
                        <td><?= $venda['data_venda'] ?></td>
                        <td>R$ <?= number_format($venda['valor_total'], 2, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>