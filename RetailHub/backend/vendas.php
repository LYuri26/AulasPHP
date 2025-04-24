<?php
require_once 'config/db.php';

// Criação da tabela de vendas
$conexao->exec("
    CREATE TABLE IF NOT EXISTS vendas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_cliente INT,
        data_venda DATETIME,
        valor_total DECIMAL(10,2),
        FOREIGN KEY (id_cliente) REFERENCES cadastro_clientes(id)
    );
");

// Criação da tabela de itens de venda
$conexao->exec("
    CREATE TABLE IF NOT EXISTS itens_vendas (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_venda INT,
        id_produto INT,
        quantidade INT,
        preco_unitario DECIMAL(10,2),
        FOREIGN KEY (id_venda) REFERENCES vendas(id),
        FOREIGN KEY (id_produto) REFERENCES cadastro_produtos(id)
    );
");

// Criação do log de vendas
$conexao->exec("
    CREATE TABLE IF NOT EXISTS log_vendas (
        id_log INT AUTO_INCREMENT PRIMARY KEY,
        id_venda INT,
        timestamp DATETIME,
        acao_realizada VARCHAR(50),
        FOREIGN KEY (id_venda) REFERENCES vendas(id)
    );
");

// Trigger para log de inserção de venda
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_vendas_insert AFTER INSERT ON vendas
    FOR EACH ROW INSERT INTO log_vendas (id_venda, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'inclusao');
");

// Trigger para log de atualização de venda
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_vendas_update AFTER UPDATE ON vendas
    FOR EACH ROW INSERT INTO log_vendas (id_venda, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'alteracao');
");

// Trigger para log de exclusão de venda
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_vendas_delete AFTER DELETE ON vendas
    FOR EACH ROW INSERT INTO log_vendas (id_venda, timestamp, acao_realizada) 
    VALUES (OLD.id, NOW(), 'exclusao');
");

//echo "Tabela de vendas, itens de vendas e logs criados com sucesso.";