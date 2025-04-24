-- Criação do banco de dados
CREATE DATABASE IF NOT EXISTS retailhub_sgi;
USE retailhub_sgi;

-- Criação da tabela de Cadastro de Produtos
CREATE TABLE cadastro_produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao VARCHAR(255),
    preco DECIMAL(10, 2) NOT NULL,
    quantidade_estoque INT NOT NULL
);

-- Criação da tabela de Cadastro de Clientes
CREATE TABLE cadastro_clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255),
    telefone VARCHAR(20)
);

-- Criação da tabela de Vendas
CREATE TABLE vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    data_venda DATETIME DEFAULT CURRENT_TIMESTAMP,
    valor_total DECIMAL(10, 2),
    FOREIGN KEY (id_cliente) REFERENCES cadastro_clientes(id)
);

-- Criação da tabela de Itens de Vendas
CREATE TABLE IF NOT EXISTS itens_vendas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT,
    id_produto INT,
    quantidade INT,
    preco_unitario DECIMAL(10, 2),
    FOREIGN KEY (id_venda) REFERENCES vendas(id),
    FOREIGN KEY (id_produto) REFERENCES cadastro_produtos(id)
);

-- Criação da tabela de Movimentações de Estoque
CREATE TABLE movimentacoes_estoque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_produto INT,
    quantidade INT,
    tipo_movimentacao VARCHAR(10), -- 'entrada' ou 'saída'
    data_movimentacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_produto) REFERENCES cadastro_produtos(id)
);

-- Criação da tabela de Log de Cadastro de Produtos
CREATE TABLE log_cadastro_produtos (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_cadastro_produto INT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    acao_realizada VARCHAR(50),
    FOREIGN KEY (id_cadastro_produto) REFERENCES cadastro_produtos(id)
);

-- Criação da tabela de Log de Vendas
CREATE TABLE log_vendas (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_venda INT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    acao_realizada VARCHAR(50),
    FOREIGN KEY (id_venda) REFERENCES vendas(id)
);

-- Criação da tabela de Log de Movimentações de Estoque
CREATE TABLE log_movimentacoes_estoque (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_movimentacao_estoque INT,
    timestamp DATETIME DEFAULT CURRENT_TIMESTAMP,
    acao_realizada VARCHAR(50),
    FOREIGN KEY (id_movimentacao_estoque) REFERENCES movimentacoes_estoque(id)
);
