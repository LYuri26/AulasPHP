<?php
require_once 'config/db.php';

// Criação da tabela de produtos
$conexao->exec("
    CREATE TABLE IF NOT EXISTS cadastro_produtos (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255),
        descricao VARCHAR(500),
        preco DECIMAL(10,2),
        quantidade_estoque INT
    );
");

// Criação do log de cadastro de produtos
$conexao->exec("
    CREATE TABLE IF NOT EXISTS log_cadastro_produtos (
        id_log INT AUTO_INCREMENT PRIMARY KEY,
        id_cadastro_produto INT,
        timestamp DATETIME,
        acao_realizada VARCHAR(50),
        FOREIGN KEY (id_cadastro_produto) REFERENCES cadastro_produtos(id)
    );
");

// Criação da tabela de movimentações de estoque
$conexao->exec("
    CREATE TABLE IF NOT EXISTS movimentacoes_estoque (
        id INT AUTO_INCREMENT PRIMARY KEY,
        id_produto INT,
        quantidade INT,
        tipo_movimentacao VARCHAR(20),
        data_movimentacao DATETIME,
        FOREIGN KEY (id_produto) REFERENCES cadastro_produtos(id)
    );
");

// Criação do log de movimentações de estoque
$conexao->exec("
    CREATE TABLE IF NOT EXISTS log_movimentacoes_estoque (
        id_log INT AUTO_INCREMENT PRIMARY KEY,
        id_movimentacao_estoque INT,
        timestamp DATETIME,
        acao_realizada VARCHAR(50),
        FOREIGN KEY (id_movimentacao_estoque) REFERENCES movimentacoes_estoque(id)
    );
");

// Trigger para log de inserção de produto
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_produtos_insert AFTER INSERT ON cadastro_produtos
    FOR EACH ROW INSERT INTO log_cadastro_produtos (id_cadastro_produto, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'inclusao');
");

// Trigger para log de atualização de produto
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_produtos_update AFTER UPDATE ON cadastro_produtos
    FOR EACH ROW INSERT INTO log_cadastro_produtos (id_cadastro_produto, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'alteracao');
");

// Trigger para log de exclusão de produto
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_produtos_delete AFTER DELETE ON cadastro_produtos
    FOR EACH ROW INSERT INTO log_cadastro_produtos (id_cadastro_produto, timestamp, acao_realizada) 
    VALUES (OLD.id, NOW(), 'exclusao');
");

// Trigger para log de movimentações de estoque (entrada)
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_estoque_insert AFTER INSERT ON movimentacoes_estoque
    FOR EACH ROW INSERT INTO log_movimentacoes_estoque (id_movimentacao_estoque, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'entrada');
");

// Trigger para log de movimentações de estoque (saída)
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_estoque_update AFTER UPDATE ON movimentacoes_estoque
    FOR EACH ROW INSERT INTO log_movimentacoes_estoque (id_movimentacao_estoque, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'saida');
");

// Trigger para log de exclusão de movimentação de estoque
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_estoque_delete AFTER DELETE ON movimentacoes_estoque
    FOR EACH ROW INSERT INTO log_movimentacoes_estoque (id_movimentacao_estoque, timestamp, acao_realizada) 
    VALUES (OLD.id, NOW(), 'exclusao');
");

//echo "Tabela de produtos, movimentações de estoque e logs criados com sucesso.";