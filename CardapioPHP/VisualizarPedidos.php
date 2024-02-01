<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8"> <!-- Define a codificação de caracteres -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Define a escala inicial para dispositivos móveis -->
    <title>Visualizar Pedidos</title> <!-- Título da página -->
    <link rel="stylesheet" type="text/css" href="./static/css/VisualizarPedidos.css"> <!-- Inclui o arquivo de estilo CSS -->
</head>

<body>
    <h2>Lista de Pedidos</h2> <!-- Título da seção -->
    <div id="tabela-pedidos">
        <table>
            <tr>
                <th>ID</th> <!-- Cabeçalho da coluna -->
                <th>Data do Pedido</th> <!-- Cabeçalho da coluna -->
                <th>Total</th> <!-- Cabeçalho da coluna -->
                <th>Itens</th> <!-- Cabeçalho da coluna -->
            </tr>

            <?php
            include './db/Conexao.php'; // Inclui o arquivo de conexão com o banco de dados

            // Conectar ao banco de dados
            $conexao = conectar(); // Chama a função conectar() do arquivo Conexao.php

            // Verificar a conexão
            if (!$conexao) { // Verifica se a conexão foi bem sucedida
                die("Erro na conexão com o banco de dados."); // Encerra o script se houver erro na conexão
            }

            // Consultar dados da tabela de pedidos
            $sql = "SELECT * FROM pedidos"; // Query SQL para selecionar todos os registros da tabela de pedidos
            $result = $conexao->query($sql); // Executa a query SQL

            if ($result->rowCount() > 0) { // Verifica se existem registros retornados pela consulta
                // Exibir dados na tabela
                foreach ($result as $row) { // Loop para percorrer os registros retornados
                    echo '<tr>'; // Inicia uma nova linha na tabela
                    echo '<td>' . $row['id'] . '</td>'; // Exibe o ID do pedido na coluna correspondente
                    echo '<td>' . $row['data_pedido'] . '</td>'; // Exibe a data do pedido na coluna correspondente
                    echo '<td>' . number_format($row['valor_pedido'], 2, ',', '.') . '</td>'; // Exibe o total do pedido formatado com duas casas decimais e separador de milhares
                    echo '<td>' . ajustarItensPedido($row['itens_do_pedido']) . '</td>'; // Chama a função ajustarItensPedido para formatar e exibir os itens do pedido na coluna correspondente
                    echo '</tr>'; // Fecha a linha na tabela
                }
            } else {
                echo '<tr><td colspan="4">Nenhum pedido encontrado.</td></tr>'; // Se não houver registros na tabela, exibe uma mensagem de aviso ocupando todas as colunas
            }

            // Fechar a conexão
            fecharConexao($conexao); // Chama a função fecharConexao para fechar a conexão com o banco de dados

            // Função para formatar os itens do pedido
            function ajustarItensPedido($itensDoPedido)
            {
                $itens = json_decode($itensDoPedido, true); // Decodifica a string JSON para um array associativo

                $itensFormatados = array_map(function ($item) { // Aplica uma função de formatação em cada item do array
                    return $item['quantidade'] . 'x ' . $item['nome'] . ' - R$ ' . number_format($item['preco'], 2, ',', ''); // Formata o item do pedido
                }, $itens);

                return implode('<br>', $itensFormatados); // Une os itens formatados em uma única string separada por quebras de linha
            }
            ?>
        </table>
    </div>
</body>

</html>