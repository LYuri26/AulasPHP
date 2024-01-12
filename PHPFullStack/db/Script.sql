CREATE DATABASE IF NOT EXISTS RH;
USE RH;
-- Inserindo dados na tabela 'login'
INSERT INTO login (usuario, nome, senha, email) VALUES
('user1', 'Usuário 1', 'senha1', 'user1@example.com'),
('user2', 'Usuário 2', 'senha2', 'user2@example.com'),
('user3', 'Usuário 3', 'senha3', 'user3@example.com');

-- Inserindo dados na tabela 'funcionarios'
INSERT INTO funcionarios (nome, cargo, departamento) VALUES
('Funcionário 1', 'Cargo 1', 'Departamento 1'),
('Funcionário 2', 'Cargo 2', 'Departamento 2'),
('Funcionário 3', 'Cargo 3', 'Departamento 3');

-- Inserindo dados na tabela 'log_funcionarios'
INSERT INTO log_funcionarios (id, alteracao, usuario) VALUES
(1, 'Alteração 1', 'Admin'),
(2, 'Alteração 2', 'Admin'),
(3, 'Alteração 3', 'Admin');

-- Inserindo dados na tabela 'historico_salarios'
INSERT INTO historico_salarios (id_funcionario, salario_atual, data_reajuste, tipo_reajuste) VALUES
(1, 5000.00, '2024-01-01', 'Reajuste 1'),
(2, 6000.00, '2024-02-01', 'Reajuste 2'),
(3, 7000.00, '2024-03-01', 'Reajuste 3');

-- Inserindo dados na tabela 'log_historico_salarios'
INSERT INTO log_historico_salarios (id, alteracao, usuario) VALUES
(1, 'Alteração 1', 'Admin'),
(2, 'Alteração 2', 'Admin'),
(3, 'Alteração 3', 'Admin');
