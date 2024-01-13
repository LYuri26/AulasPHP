<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Log de Salários</title>
    <link rel="stylesheet" type="text/css" href="../css/LogSalarios.css">
</head>

<body>
    <div class="header">
        <h2>Log de Salários</h2>
        <div class="button-container">
            <!-- Botão para voltar ao Dashboard -->
            <a class="voltar-button" href="../Dashboard.php">Voltar ao Dashboard</a>
            <!-- Botão para sair -->
            <a class="sair-button" href="../logout.php">Sair</a>
        </div>
    </div>
    <!-- Tabela de Log de Salários -->
    <h3>Tabela de Log de Salários</h3>
    <table>
        <thead>
            <tr>
                <th>ID do Funcionário</th>
                <th>Data de Modificação</th>
                <th>Alteração</th>
                <th>Usuário</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include '../db/Conexao.php';

            // Query para buscar os registros da tabela log_historico_salarios
            $query = "SELECT * FROM log_historico_salarios";
            $stmt = $conexao->query($query);
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($logs as $log) {
                echo "<tr>";
                echo "<td>" . $log['id'] . "</td>";
                echo "<td>" . $log['data_modificacao'] . "</td>";
                echo "<td>" . $log['alteracao'] . "</td>";
                echo "<td>" . $log['usuario'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>