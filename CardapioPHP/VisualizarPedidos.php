<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visualizar Pedidos</title>
    <link rel="stylesheet" type="text/css" href="./static/css/VisualizarPedidos.css">
</head>

<body>
    <h2>Lista de Pedidos</h2>
    <div id="tabela-pedidos">
        <table>
            <tr>
                <th>ID</th>
                <th>Data do Pedido</th>
                <th>Total</th>
                <th>Itens</th>
            </tr>

            <?php
            include './db/Conexao.php';

            // Conectar ao banco de dados
            $conexao = conectar();

            // Verificar a conexão
            if (!$conexao) {
                die("Erro na conexão com o banco de dados.");
            }

            // Consultar dados da tabela de pedidos
            $sql = "SELECT * FROM pedidos";
            $result = $conexao->query($sql);

            if ($result->rowCount() > 0) {
                // Exibir dados na tabela
                foreach ($result as $row) {
                    echo '<tr>';
                    echo '<td>' . $row['id'] . '</td>';
                    echo '<td>' . $row['data_pedido'] . '</td>';
                    echo '<td>' . number_format($row['valor_pedido'], 2, ',', '.') . '</td>'; // Exibir apenas duas casas decimais
                    echo '<td>' . ajustarItensPedido($row['itens_do_pedido']) . '</td>'; // Ajustar os itens do pedido
                    echo '</tr>';
                }
            } else {
                echo '<tr><td colspan="4">Nenhum pedido encontrado.</td></tr>';
            }

            // Fechar a conexão
            fecharConexao($conexao);

            function ajustarItensPedido($itensDoPedido)
            {
                $itens = json_decode($itensDoPedido, true);

                $itensFormatados = array_map(function ($item) {
                    return $item['quantidade'] . 'x ' . $item['nome'] . ' - R$ ' . number_format($item['preco'], 2, ',', '');
                }, $itens);

                return implode('<br>', $itensFormatados);
            }
            ?>
        </table>
    </div>
</body>

</html>