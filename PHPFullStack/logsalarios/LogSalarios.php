<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Log de Salários</title>
</head>

<body>
    <h2>Log de Salários</h2>

    <!-- Botão para voltar ao Dashboard -->
    <a href="../Dashboard.php">Voltar ao Dashboard</a>
    <!-- Botão para sair -->
    <a href="funcionarios/logout.php">Sair</a>

    <!-- Tabela de Log de Salários -->
    <h3>Tabela de Log de Salários</h3>
    <table border="1">
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