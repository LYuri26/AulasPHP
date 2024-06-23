-- Criação do banco de dados linkin_park_album se ele não existir ainda
CREATE DATABASE IF NOT EXISTS linkin_park_album;

-- Seleciona o banco de dados linkin_park_album para uso
USE linkin_park_album;

-- Criação da tabela login se ela não existir ainda
CREATE TABLE IF NOT EXISTS login (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Chave primária com auto incremento
    cantor VARCHAR(100) NOT NULL,
    -- Campo para o nome do cantor (não nulo)
    senha VARCHAR(255) NOT NULL -- Campo para a senha (não nulo)
);

-- Inserção de dados fictícios na tabela login com nomes dos membros do Linkin Park
INSERT INTO
    login (cantor, senha)
VALUES
    ('Chester Bennington', 'senha123'),
    -- Chester Bennington em vez de João Silva
    ('Mike Shinoda', 'senha456'),
    -- Mike Shinoda em vez de Maria Santos
    ('Brad Delson', 'senha789'),
    -- Brad Delson em vez de Pedro Oliveira
    ('Rob Bourdon', 'senha101'),
    -- Rob Bourdon em vez de Pedro Oliveira (duplicado)
    ('Joe Hahn', 'senha102'),
    -- Joe Hahn em vez de Pedro Oliveira (duplicado)
    ('Dave Farrell', 'senha103');

-- Dave Farrell em vez de Pedro Oliveira (duplicado)
-- Criação da tabela musicas se ela não existir ainda
CREATE TABLE IF NOT EXISTS musicas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Chave primária com auto incremento
    musica VARCHAR(100) NOT NULL,
    -- Campo para o nome da música (não nulo)
    album VARCHAR(100) NOT NULL,
    -- Campo para o nome do álbum (não nulo)
    ano YEAR,
    -- Campo para o ano do lançamento do álbum
    descricao TEXT -- Campo para a descrição da música
);