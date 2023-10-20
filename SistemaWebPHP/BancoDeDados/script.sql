-- Criação do banco de dados "saep_database"
CREATE DATABASE IF NOT EXISTS saep_database;

-- Seleção do banco de dados
USE saep_database;

-- Criação da tabela "usuarios"
CREATE TABLE IF NOT EXISTS usuarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    login VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL, -- Adicionando campo de e-mail
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)
);

-- Inserção de registros na tabela "usuarios"
INSERT IGNORE INTO usuarios (login, email, senha) VALUES 
    ('teste', 'teste@example.com', '123'),
    ('usuario2', 'usuario2@example.com', 'senha2'),
    ('usuario3', 'usuario3@example.com', 'senha3');

-- Criação da tabela "atividades"
CREATE TABLE IF NOT EXISTS atividades (
    numero INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    funcionario VARCHAR(255) NOT NULL,
    detalhes VARCHAR(255) NOT NULL
);

-- Inserção de registros na tabela "atividades"
INSERT IGNORE INTO atividades (nome, funcionario, detalhes) VALUES 
    ('Atividade 1', 'Funcionario A', 'Detalhes 1'),
    ('Atividade 2', 'Funcionario B', 'Detalhes 2'),
    ('Atividade 3', 'Funcionario C', 'Detalhes 3');
