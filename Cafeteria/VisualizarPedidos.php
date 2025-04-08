<?php
require_once 'db/Conexao.php';

$conn = conectar();
$stmt = $conn->query("SELECT * FROM pedidos ORDER BY data_pedido DESC, horario_pedido DESC");
$pedidos = $stmt->fetchAll();
fecharConexao($conn);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Code Brew Café</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="static/css/pedidos.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.html">Code Brew Café</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Cardápio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="VisualizarPedidos.php">Pedidos</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h1 class="text-center mb-4">Pedidos Registrados</h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Cliente</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Total</th>
                    <th>Itens</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                <tr>
                    <td><?= $pedido['id'] ?></td>
                    <td><?= htmlspecialchars($pedido['nome_cliente']) ?></td>
                    <td><?= date('d/m/Y', strtotime($pedido['data_pedido'])) ?></td>
                    <td><?= substr($pedido['horario_pedido'], 0, 5) ?></td>
                    <td>R$ <?= number_format($pedido['valor_total'], 2, ',', '.') ?></td>
                    <td>
                        <?php
                            $itens = json_decode($pedido['itens_pedido'], true);
                            foreach ($itens as $item) {
                                echo $item['quantidade'] . 'x Item #' . $item['id'] . '<br>';
                            }
                            ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>