-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS estoque;

-- Utiliza o banco de dados criado
USE estoque;

-- Criação da tabela produtos
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    quantidade INT,
    preco_unitario DECIMAL(10, 2)
);
