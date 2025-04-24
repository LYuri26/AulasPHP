<?php
require_once 'config/db.php';

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
        timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
        acao_realizada VARCHAR(50),
        FOREIGN KEY (id_venda) REFERENCES vendas(id)
    );
");

// Triggers para log de inserção, atualização e exclusão de venda
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_vendas_insert AFTER INSERT ON vendas
    FOR EACH ROW INSERT INTO log_vendas (id_venda, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'inclusao');
");

$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_vendas_update AFTER UPDATE ON vendas
    FOR EACH ROW INSERT INTO log_vendas (id_venda, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'alteracao');
");

$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_vendas_delete AFTER DELETE ON vendas
    FOR EACH ROW INSERT INTO log_vendas (id_venda, timestamp, acao_realizada) 
    VALUES (OLD.id, NOW(), 'exclusao');
");

// echo "Tabela de itens de vendas e logs criados com sucesso.";