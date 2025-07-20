-- =============================================
-- CRIAÇÃO DO BANCO DE DADOS
-- =============================================

-- Cria o banco de dados se ele não existir
CREATE DATABASE IF NOT EXISTS ecoplast_db 
-- Define o conjunto de caracteres como utf8mb4 (suporta caracteres especiais e emojis)
CHARACTER SET utf8mb4 
-- Define a collation como unicode (para ordenação correta de caracteres internacionais)
COLLATE utf8mb4_unicode_ci;

-- Seleciona o banco de dados criado para uso nas próximas instruções
USE ecoplast_db;

-- =============================================
-- CRIAÇÃO DA TABELA DE CLIENTES
-- =============================================

-- Cria a tabela de clientes com os campos necessários
CREATE TABLE clientes (
    -- ID autoincrementável como chave primária
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Nome completo do cliente (obrigatório)
    nome VARCHAR(100) NOT NULL,
    -- E-mail do cliente (obrigatório e único)
    email VARCHAR(100) NOT NULL UNIQUE,
    -- Telefone do cliente (obrigatório)
    telefone VARCHAR(20) NOT NULL,
    -- Endereço completo (obrigatório)
    endereco VARCHAR(200) NOT NULL,
    -- Cidade (obrigatório)
    cidade VARCHAR(50) NOT NULL,
    -- Estado (sigla de 2 caracteres, obrigatório)
    estado CHAR(2) NOT NULL,
    -- CEP (opcional)
    cep VARCHAR(10),
    -- Data de cadastro com valor padrão sendo a data/hora atual
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    -- Status do cliente com valores pré-definidos e padrão 'ativo'
    status ENUM('ativo', 'inativo') DEFAULT 'ativo',
    
    -- Índice para otimizar buscas por e-mail
    INDEX idx_email (email),
    -- Índice para otimizar buscas por status
    INDEX idx_status (status),
    -- Índice composto para otimizar buscas por cidade e estado
    INDEX idx_cidade_estado (cidade, estado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;  -- Usa engine InnoDB com charset utf8mb4

-- =============================================
-- CRIAÇÃO DA TABELA DE LOGS
-- =============================================

-- Cria tabela para registrar atividades do sistema
CREATE TABLE logs (
    -- ID autoincrementável como chave primária
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Tipo de ação realizada (INSERT, UPDATE, DELETE)
    acao VARCHAR(50) NOT NULL,
    -- Descrição detalhada da ação
    descricao TEXT NOT NULL,
    -- Data/hora do registro com valor padrão sendo a data/hora atual
    data_hora DATETIME DEFAULT CURRENT_TIMESTAMP,
    
    -- Índice para otimizar buscas por data/hora
    INDEX idx_data_hora (data_hora)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;  -- Usa engine InnoDB com charset utf8mb4

-- =============================================
-- TRIGGERS PARA REGISTRO DE LOGS (CORRIGIDOS)
-- =============================================

-- Altera temporariamente o delimitador para permitir criação de triggers com múltiplos comandos
DELIMITER //

-- Trigger que executa após inserção de novo cliente
CREATE TRIGGER after_cliente_insert
AFTER INSERT ON clientes  -- Dispara após operação INSERT na tabela clientes
FOR EACH ROW  -- Executa para cada linha afetada
BEGIN
    -- Insere registro na tabela de logs
    INSERT INTO logs (acao, descricao)
    VALUES ('INSERT', CONCAT('Novo cliente cadastrado: ', NEW.nome, ' (ID: ', NEW.id, ')'));
END//

-- Trigger que executa após atualização de cliente
CREATE TRIGGER after_cliente_update
AFTER UPDATE ON clientes  -- Dispara após operação UPDATE na tabela clientes
FOR EACH ROW
BEGIN
    -- Insere registro na tabela de logs
    INSERT INTO logs (acao, descricao)
    VALUES ('UPDATE', CONCAT('Cliente atualizado: ', NEW.nome, ' (ID: ', NEW.id, ')'));
END//

-- Trigger que executa após exclusão de cliente
CREATE TRIGGER after_cliente_delete
AFTER DELETE ON clientes  -- Dispara após operação DELETE na tabela clientes
FOR EACH ROW
BEGIN
    -- Insere registro na tabela de logs
    INSERT INTO logs (acao, descricao)
    VALUES ('DELETE', CONCAT('Cliente removido: ', OLD.nome, ' (ID: ', OLD.id, ')'));
END//

-- Restaura o delimitador padrão
DELIMITER ;

-- =============================================
-- DADOS INICIAIS PARA TESTES
-- =============================================

-- Insere registros iniciais na tabela de clientes
INSERT INTO clientes (
    nome,
    email,
    telefone,
    endereco,
    cidade,
    estado
) VALUES (
    -- Primeiro cliente de teste
    'João Silva',
    'joao@exemplo.com',
    '(34) 9999-9999',
    'Rua A, 100',
    'Uberaba',
    'MG'
), (
    -- Segundo cliente de teste
    'Maria Souza',
    'maria@exemplo.com',
    '(34) 8888-8888',
    'Rua B, 200',
    'Uberaba',
    'MG'
);

-- =============================================
-- CONSULTAS DE TESTE
-- =============================================

-- Consulta todos os registros da tabela clientes
SELECT * FROM clientes;

-- Consulta todos os registros da tabela de logs
SELECT * FROM logs;