CREATE DATABASE saep_database;

USE  saep_database;

CREATE TABLE IF NOT EXISTS usuarios (
    id INT(11) NOT NULL AUTO_INCREMENT,
    login VARCHAR(255) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    PRIMARY KEY (id));

INSERT INTO usuarios (login, senha) VALUES ('teste', '123');
