<?php
include '../db/Conexao.php';

// Query para criar a tabela log_funcionarios se ela não existir
$queryLogFuncionarios = "
    CREATE TABLE IF NOT EXISTS log_funcionarios (
        log_id INT AUTO_INCREMENT PRIMARY KEY,
        id INT NOT NULL,
        data_modificacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        alteracao VARCHAR(255) NOT NULL,
        usuario VARCHAR(50) NOT NULL,
        FOREIGN KEY (id) REFERENCES funcionarios(id) ON DELETE CASCADE
    )
";

try {
    // Executar a criação da tabela log_funcionarios
    $conexao->exec($queryLogFuncionarios);
} catch(PDOException $e) {
    echo "Erro ao criar a tabela: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Log de Funcionários</title>
</head>

<body>
    <h2>Log de Funcionários</h2>

    <!-- Botão para voltar ao Dashboard -->
    <a href="../Dashboard.php">Voltar ao Dashboard</a>
    <!-- Botão para sair -->
    <a href="funcionarios/logout.php">Sair</a>

    <!-- Tabela de Log de Funcionários -->
    <h3>Tabela de Log de Funcionários</h3>
    <table border="1">
        <thead>
            <tr>
                <th>ID do Log</th>
                <th>ID do Funcionário</th>
                <th>Data de Modificação</th>
                <th>Alteração</th>
                <th>Usuário</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Query para buscar os registros da tabela log_funcionarios
            $query = "SELECT * FROM log_funcionarios";
            $stmt = $conexao->query($query);
            $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($logs as $log) {
                echo "<tr>";
                echo "<td>" . $log['log_id'] . "</td>";
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
