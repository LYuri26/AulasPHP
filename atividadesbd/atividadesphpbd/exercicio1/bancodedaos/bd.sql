-- SQL para criação do banco de dados linkin_park_fans e da tabela usuarios
CREATE DATABASE IF NOT EXISTS linkin_park_fas;
USE linkin_park_fas;
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
-- Dados fictícios de fãs para inserção inicial
INSERT INTO usuarios (nome, email, senha)
VALUES
    ('João Silva', 'joao@example.com', 'senha123'),
    ('Maria Santos', 'maria@example.com', 'senha456'),
    ('Pedro Oliveira', 'pedro@example.com', 'senha789');
-- SQL para criação da tabela de fãs (ainda sem dados fictícios)
CREATE TABLE IF NOT EXISTS fas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    data_nascimento DATE,
    cidade VARCHAR(100),
    estado VARCHAR(50),
    pais VARCHAR(50),
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
