CREATE DATABASE IF NOT EXISTS banco_usuario;

USE banco_usuario;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(150) NOT NULL,
    idade INT,
    senha VARCHAR(50),
    genero ENUM('M', 'F', 'Outro'),
    termos TINYINT(1) DEFAULT 0,
    data_cadastro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id) -- This is correct as it defines the primary key on `id`
);

CREATE INDEX idx_email ON usuarios(email);

INSERT INTO
    usuarios(nome, email, idade, senha, genero, termos)
VALUES
    (
        'João Silva',
        'joao@email.com',
        25,
        '12345678',
        'M',
        1
    ),
    (
        'Maria',
        'maria@email.com',
        18,
        'minhasenha',
        'F',
        1
    );