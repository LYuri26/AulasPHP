<?php
include 'Conexao.php'; // Inclui o arquivo de conexão

try {
    // Tabela de Funcionários
    $queryFuncionarios = "
        CREATE TABLE IF NOT EXISTS funcionarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(100) NOT NULL,
            cargo VARCHAR(50) NOT NULL,
            departamento VARCHAR(50) NOT NULL
        )
    ";

    // Tabela de Log de Funcionários
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

    // Tabela de Histórico de Salários
    $queryHistoricoSalarios = "
        CREATE TABLE IF NOT EXISTS historico_salarios (
            id INT AUTO_INCREMENT PRIMARY KEY,
            salario_atual DECIMAL(10, 2) NOT NULL,
            data_reajuste DATE NOT NULL,
            tipo_reajuste VARCHAR(50) NOT NULL
        )
    ";

    // Tabela de Log de Histórico de Salários
    $queryLogHistoricoSalarios = "
        CREATE TABLE IF NOT EXISTS log_historico_salarios (
            log_id INT AUTO_INCREMENT PRIMARY KEY,
            id INT NOT NULL,
            data_modificacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            alteracao VARCHAR(255) NOT NULL,
            usuario VARCHAR(50) NOT NULL,
            FOREIGN KEY (id) REFERENCES historico_salarios(id) ON DELETE CASCADE
        )
    ";

    // Executa as queries
    $conexao->exec($queryFuncionarios);
    echo "<script>console.log('Tabela funcionarios criada com sucesso!');</script>";

    $conexao->exec($queryLogFuncionarios);
    echo "<script>console.log('Tabela log_funcionarios criada com sucesso!');</script>";

    $conexao->exec($queryHistoricoSalarios);
    echo "<script>console.log('Tabela historico_salarios criada com sucesso!');</script>";

    $conexao->exec($queryLogHistoricoSalarios);
    echo "<script>console.log('Tabela log_historico_salarios criada com sucesso!');</script>";

    echo "<script>console.log('Tabelas criadas com sucesso!');</script>";
} catch(PDOException $e) {
    echo "<script>console.error('Erro ao criar as tabelas: " . $e->getMessage() . "');</script>";
}
?>
