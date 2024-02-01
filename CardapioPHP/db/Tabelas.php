<?php

include('Conexao.php'); // Inclui o arquivo de conexão com o banco de dados

try {
    // SQL para criar a tabela de hamburgueres
    $sqlCriacaoHamburgueres = "
        CREATE TABLE IF NOT EXISTS hamburgueres (
            id INT AUTO_INCREMENT PRIMARY KEY,
            nome VARCHAR(255) NOT NULL,
            descricao TEXT NOT NULL,
            preco DECIMAL(8, 2) NOT NULL
        );
    ";

    // SQL para criar a tabela de pedidos
    $sqlCriacaoPedidos = "
        CREATE TABLE IF NOT EXISTS pedidos (
            id INT AUTO_INCREMENT PRIMARY KEY,
            data_pedido DATE NOT NULL,
            horario_pedido TIME NOT NULL,
            valor_pedido DECIMAL(8, 2) NOT NULL,
            itens_do_pedido TEXT
        );
    ";

    // Executando o script SQL de criação da tabela de hamburgueres
    $conexao->exec($sqlCriacaoHamburgueres);

    // Mensagem para o console.log do navegador - Tabela de hamburgueres criada
    echo "<script>console.log('Tabela de hamburgueres criada com sucesso.');</script>";

    // Executando o script SQL de criação da tabela de pedidos
    $conexao->exec($sqlCriacaoPedidos);

    // Mensagem para o console.log do navegador - Tabela de pedidos criada
    echo "<script>console.log('Tabela de pedidos criada com sucesso.');</script>";

    // SQL para criar o trigger
    $sqlCriacaoTrigger = "
        CREATE TRIGGER IF NOT EXISTS antes_de_inserir_pedido
        BEFORE INSERT ON pedidos
        FOR EACH ROW
        SET NEW.data_pedido = CURDATE(), NEW.horario_pedido = CURTIME();
    ";

    // Executando o script SQL de criação do trigger
    $conexao->exec($sqlCriacaoTrigger);

    // Mensagem para o console.log do navegador - Trigger criado
    // echo "<script>console.log('Trigger criado com sucesso.');</script>";
} catch (PDOException $e) {
    //echo "<script>console.error('Erro na criação das tabelas ou trigger: " . $e->getMessage() . "');</script>";
} finally {
    // Fechando a conexão
    $conexao = null;
}
