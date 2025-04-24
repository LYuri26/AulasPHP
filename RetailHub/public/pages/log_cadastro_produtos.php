<?php
require_once '../../backend/config/db.php';
require_once '../../backend/clientes.php';
require_once '../../backend/produtos.php';
require_once '../../backend/vendas.php';
require_once '../../backend/itens_vendas.php';
require_once '../../backend/movimentacoes_estoque.php';

$query = $conexao->query("SELECT * FROM log_cadastro_produtos");
$logs = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Log de Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/logs.css" rel="stylesheet">

</head>

<body>
    <div class="container">
        <h1 class="text-center">Log de Cadastro de Produtos</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-primary">
                <tr>
                    <th>ID Log</th>
                    <th>ID Produto</th>
                    <th>Data/Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($logs as $log): ?>
                <tr>
                    <td><?= $log['id_log'] ?></td>
                    <td><?= $log['id_cadastro_produto'] ?></td>
                    <td><?= $log['timestamp'] ?></td>
                    <td><?= $log['acao_realizada'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>