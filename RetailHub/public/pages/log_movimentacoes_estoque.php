<?php
require_once '../../backend/config/db.php';
require_once '../../backend/clientes.php';
require_once '../../backend/produtos.php';
require_once '../../backend/vendas.php';
require_once '../../backend/itens_vendas.php';
require_once '../../backend/movimentacoes_estoque.php';

$query = $conexao->query("SELECT * FROM log_movimentacoes_estoque ORDER BY timestamp DESC");
$logs = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Log de Movimentações de Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/logs.css" rel="stylesheet">

</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Log de Movimentações de Estoque</h1>

        <?php if (count($logs) > 0): ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>ID Log</th>
                        <th>ID Movimentação</th>
                        <th>Data/Hora</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($logs as $log): ?>
                    <tr>
                        <td><?= $log['id_log'] ?></td>
                        <td><?= $log['id_movimentacao_estoque'] ?></td>
                        <td><?= date('d/m/Y H:i:s', strtotime($log['timestamp'])) ?></td>
                        <td><span class="badge bg-secondary"><?= ucfirst($log['acao_realizada']) ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="alert alert-warning text-center">Nenhum log de movimentação encontrado.</div>
        <?php endif; ?>
    </div>
</body>

</html>