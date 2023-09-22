CREATE DATABASE saep_database;

USE saep_database;

CREATE TABLE
    IF NOT EXISTS usuarios (
        id INT(11) NOT NULL AUTO_INCREMENT,
        login VARCHAR(255) NOT NULL,
        senha VARCHAR(255) NOT NULL,
        PRIMARY KEY (id)
    );

INSERT INTO usuarios (login, senha) VALUES ('teste', '123');

CREATE TABLE
    atividades (
        numero INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        funcionario VARCHAR(255) NOT NULL,
        detalhes VARCHAR(255) NOT NULL
);