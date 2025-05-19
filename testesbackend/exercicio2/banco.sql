-- Verifica se o banco já existe
DROP DATABASE IF EXISTS empresa;

CREATE DATABASE empresa CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;

USE empresa;

CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    preco DECIMAL(10, 2) NOT NULL
);

INSERT INTO
    produtos (nome, preco)
VALUES
    ('Notebook Gamer', 4999.99),
    ('Mouse RGB', 199.99);