<?php
// Função para realizar consulta ao banco de dados
function consultarProdutos() {
    // Conexão com o banco de dados
    $conn = new mysqli('localhost', 'root', '', 'estoque');

    // Verifica se houve erro na conexão
    if ($conn->connect_error) {
        die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
    }

    // Query SQL para selecionar todos os produtos
    $sql = "SELECT * FROM produtos";

    // Executa a consulta
    $result = $conn->query($sql);

    // Fecha a conexão com o banco de dados
    $conn->close();
}

// Número de acessos simultâneos a serem simulados
$num_acessos = 100;

// Executa múltiplos acessos simultâneos
for ($i = 1; $i <= $num_acessos; $i++) {
    consultarProdutos();
}

echo "Teste de Carga - Simulação de $num_acessos acessos simultâneos concluída.<br>";
?>
