-- SQL para criação do banco de dados linkin_park_fas e da tabela usuarios

-- Cria o banco de dados linkin_park_fas se ele não existir ainda
CREATE DATABASE IF NOT EXISTS linkin_park_fas;

-- Seleciona o banco de dados linkin_park_fas para uso
USE linkin_park_fas;

-- Cria a tabela usuarios se ela não existir ainda
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Chave primária auto incremento
    nome VARCHAR(100) NOT NULL,               -- Campo para o nome do usuário (não nulo)
    email VARCHAR(100) NOT NULL,              -- Campo para o email do usuário (não nulo)
    senha VARCHAR(255) NOT NULL,              -- Campo para a senha do usuário (não nulo)
    data_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Data de registro com valor padrão de timestamp atual
);

-- Dados fictícios de fãs para inserção inicial
INSERT INTO usuarios (nome, email, senha)
VALUES
    ('João Silva', 'joao@example.com', 'senha123'),
    ('Maria Santos', 'maria@example.com', 'senha456'),
    ('Pedro Oliveira', 'pedro@example.com', 'senha789');

-- SQL para criação da tabela de fãs (ainda sem dados fictícios)

-- Cria a tabela fas se ela não existir ainda
CREATE TABLE IF NOT EXISTS fas (
    id INT AUTO_INCREMENT PRIMARY KEY,        -- Chave primária auto incremento
    nome VARCHAR(100) NOT NULL,               -- Campo para o nome do fã (não nulo)
    email VARCHAR(100) NOT NULL,              -- Campo para o email do fã (não nulo)
    data_nascimento DATE,                     -- Campo para a data de nascimento do fã
    cidade VARCHAR(100),                      -- Campo para a cidade do fã
    estado VARCHAR(50),                       -- Campo para o estado do fã
    pais VARCHAR(50),                         -- Campo para o país do fã
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP  -- Data de cadastro com valor padrão de timestamp atual
);
