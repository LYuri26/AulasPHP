<?php
require_once 'config/db.php';

// Criação da tabela de clientes
$conexao->exec("
    CREATE TABLE IF NOT EXISTS cadastro_clientes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255),
        email VARCHAR(255),
        telefone VARCHAR(20)
    );
");

// Criação do log de cadastro de clientes
$conexao->exec("
    CREATE TABLE IF NOT EXISTS log_cadastro_clientes (
        id_log INT AUTO_INCREMENT PRIMARY KEY,
        id_cadastro_cliente INT,
        timestamp DATETIME,
        acao_realizada VARCHAR(50),
        FOREIGN KEY (id_cadastro_cliente) REFERENCES cadastro_clientes(id)
    );
");

// Trigger para log de inserção de cliente
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_clientes_insert AFTER INSERT ON cadastro_clientes
    FOR EACH ROW INSERT INTO log_cadastro_clientes (id_cadastro_cliente, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'inclusao');
");

// Trigger para log de atualização de cliente
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_clientes_update AFTER UPDATE ON cadastro_clientes
    FOR EACH ROW INSERT INTO log_cadastro_clientes (id_cadastro_cliente, timestamp, acao_realizada) 
    VALUES (NEW.id, NOW(), 'alteracao');
");

// Trigger para log de exclusão de cliente
$conexao->exec("
    CREATE TRIGGER IF NOT EXISTS trigger_log_clientes_delete AFTER DELETE ON cadastro_clientes
    FOR EACH ROW INSERT INTO log_cadastro_clientes (id_cadastro_cliente, timestamp, acao_realizada) 
    VALUES (OLD.id, NOW(), 'exclusao');
");

//echo "Tabela de clientes e logs criados com sucesso.";