-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS codebrew_cafe;
USE codebrew_cafe;

-- Tabela de bebidas
CREATE TABLE IF NOT EXISTS bebidas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    preco DECIMAL(8,2) NOT NULL,
    categoria VARCHAR(100) NOT NULL
);

-- Tabela de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_cliente VARCHAR(255) NOT NULL,
    data_pedido DATE NOT NULL,
    horario_pedido TIME NOT NULL,
    valor_total DECIMAL(8,2) NOT NULL,
    itens_pedido TEXT NOT NULL
);

-- Trigger para data e hora
DELIMITER $$
CREATE TRIGGER IF NOT EXISTS antes_de_inserir_pedido
BEFORE INSERT ON pedidos
FOR EACH ROW
BEGIN
    SET NEW.data_pedido = CURDATE();
    SET NEW.horario_pedido = CURTIME();
END$$
DELIMITER ;

-- Inserir dados iniciais
INSERT INTO bebidas (nome, descricao, preco, categoria) VALUES
('Java Latte', 'Café espresso com leite vaporizado', 12.90, 'Café'),
('Python Espresso', 'Café forte sem adições', 10.50, 'Café'),
('Ruby Chai', 'Chá preto com especiarias', 9.80, 'Chá'),
('JavaScript Juice', 'Suco natural de laranja', 8.50, 'Refresco');