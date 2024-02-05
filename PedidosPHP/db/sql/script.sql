-- Criar o banco de dados se não existir
CREATE DATABASE IF NOT EXISTS graosdb;

-- Usar o banco de dados graosdb
USE graosdb;

-- Criar a tabela de funcionários se não existir
CREATE TABLE IF NOT EXISTS funcionarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    cargo VARCHAR(100) NOT NULL,
    departamento VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL
);

-- Inserir funcionários fictícios se a tabela estiver vazia
INSERT INTO funcionarios (nome, cargo, departamento, email, senha) 
SELECT * FROM (
    SELECT 'Funcionário 1', 'Cargo 1', 'Departamento 1', 'funcionario1@example.com', 'senha1' UNION ALL
    SELECT 'Funcionário 2', 'Cargo 2', 'Departamento 2', 'funcionario2@example.com', 'senha2' UNION ALL
    SELECT 'Funcionário 3', 'Cargo 3', 'Departamento 1', 'funcionario3@example.com', 'senha3' UNION ALL
    SELECT 'Funcionário 4', 'Cargo 1', 'Departamento 3', 'funcionario4@example.com', 'senha4' UNION ALL
    SELECT 'Funcionário 5', 'Cargo 2', 'Departamento 2', 'funcionario5@example.com', 'senha5'
) AS tmp
WHERE NOT EXISTS (
    SELECT id FROM funcionarios
);

-- Criar a tabela de solicitações se não existir
CREATE TABLE IF NOT EXISTS solicitacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    funcionario_id INT,
    FOREIGN KEY (funcionario_id) REFERENCES funcionarios(id),
    nome_material VARCHAR(100) NOT NULL,
    quantidade INT NOT NULL,
    data_solicitacao DATE NOT NULL,
    status_solicitacao VARCHAR(50) NOT NULL
);
