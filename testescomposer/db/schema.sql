-- Criação do banco de dados (se ainda não existir)
CREATE DATABASE IF NOT EXISTS calculator_db;

-- Seleção do banco de dados
USE calculator_db;

-- Criação da tabela (se ainda não existir)
CREATE TABLE IF NOT EXISTS calculator_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    a INT,
    b INT,
    operation VARCHAR(10),
    result INT
);
