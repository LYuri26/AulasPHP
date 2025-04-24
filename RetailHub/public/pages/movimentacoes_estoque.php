<?php
require_once '../../backend/config/db.php';
require_once '../../backend/clientes.php';
require_once '../../backend/produtos.php';
require_once '../../backend/vendas.php';
require_once '../../backend/itens_vendas.php';
require_once '../../backend/movimentacoes_estoque.php';

// Consulta SQL simplificada
$sql = "SELECT id, id_produto, quantidade, tipo_movimentacao, data_movimentacao FROM movimentacoes_estoque ORDER BY data_movimentacao DESC";

$resultado = $conexao->query($sql);
$movimentacoes = $resultado->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Movimentações de Estoque</title>
    <link href="../css/movimentacoes_estoque.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Movimentações de Estoque</h1>

        <?php if (count($movimentacoes) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>ID Produto</th>
                    <th>Quantidade</th>
                    <th>Tipo</th>
                    <th>Data</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($movimentacoes as $mov): ?>
                <tr>
                    <td><?= $mov['id'] ?></td>
                    <td><?= $mov['id_produto'] ?></td>
                    <td><?= $mov['quantidade'] ?></td>
                    <td class="<?= $mov['tipo_movimentacao'] === 'entrada' ? 'entrada' : 'saida' ?>">
                        <?= ucfirst($mov['tipo_movimentacao']) ?>
                    </td>
                    <td><?= date('d/m/Y H:i:s', strtotime($mov['data_movimentacao'])) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="alert">Nenhuma movimentação registrada.</div>
        <?php endif; ?>
    </div>
</body>

</html>