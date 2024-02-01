-- Criar o banco de dados
CREATE DATABASE IF NOT EXISTS lanchonete;

-- Selecionar o banco de dados criado
USE lanchonete;

-- Criar a tabela de hamburgueres
CREATE TABLE IF NOT EXISTS hamburgueres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Define o campo 'id' como chave primária e auto_increment para gerar valores automaticamente
    nome VARCHAR(255) NOT NULL,
    -- Define o campo 'nome' como uma string de até 255 caracteres e não nulo
    descricao TEXT NOT NULL,
    -- Define o campo 'descricao' como um texto (pode armazenar uma grande quantidade de texto) e não nulo
    preco DECIMAL(8, 2) NOT NULL -- Define o campo 'preco' como um número decimal com 8 dígitos no total e 2 dígitos após a vírgula, não nulo
);

-- Criar a tabela de pedidos
CREATE TABLE IF NOT EXISTS pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    -- Define o campo 'id' como chave primária e auto_increment para gerar valores automaticamente
    data_pedido DATE NOT NULL,
    -- Define o campo 'data_pedido' como uma data e não nulo
    horario_pedido TIME NOT NULL,
    -- Define o campo 'horario_pedido' como uma hora e não nulo
    valor_pedido DECIMAL(8, 2) NOT NULL,
    -- Define o campo 'valor_pedido' como um número decimal com 8 dígitos no total e 2 dígitos após a vírgula, não nulo
    itens_do_pedido TEXT -- Define o campo 'itens_do_pedido' como um texto (pode armazenar uma grande quantidade de texto)
);

-- Adicionar um trigger para inserir automaticamente a data e a hora
CREATE TRIGGER IF NOT EXISTS antes_de_inserir_pedido -- Cria um trigger chamado 'antes_de_inserir_pedido' que será executado antes de inserir um novo registro na tabela 'pedidos'
BEFORE
INSERT
    ON pedidos -- Define que o trigger será acionado antes de uma operação de inserção na tabela 'pedidos'
    FOR EACH ROW -- Indica que o trigger será executado para cada linha afetada pela operação de inserção
    BEGIN
SET
    NEW.data_pedido = CURDATE();

-- Define a data do pedido como a data atual
SET
    NEW.horario_pedido = CURTIME();

-- Define o horário do pedido como a hora atual
END;

DELIMITER;

-- Inserir dados na tabela de hamburgueres
INSERT INTO
    hamburgueres (nome, descricao, preco)
VALUES
    (
        'Java Burger',
        -- Nome do hambúrguer
        'Hamburguer de carne, queijo, alface e molho especial.',
        -- Descrição do hambúrguer
        25.99 -- Preço do hambúrguer
    ),
    (
        'JavaScript Joy',
        'Hamburguer vegetariano com hambúrguer de quinoa, abobrinha grelhada, alface e molho de ervas.',
        23.99
    ),
    -- Outros registros de hambúrgueres seguem o mesmo padrão
...(
        'HTML Heat',
        'Hamburguer de carne, bacon, queijo pepper jack, jalapeños e molho picante.',
        29.99
    ),
    (
        'SQL Supreme',
        'Hamburguer de carne, queijo suíço, cogumelos e molho de alho.',
        26.99
    ),
    (
        'React Vegano',
        'Hamburguer vegano com hambúrguer de grão-de-bico, abacate, tomate e molho vegano.',
        21.99
    ),
    (
        'Swift Sensation',
        'Hamburguer de frango, queijo suíço, cogumelos e maionese de mostarda.',
        28.99
    ),
    (
        'CSS Crunch',
        'Hamburguer vegetariano com hambúrguer de lentilha, cebola caramelizada, alface e maionese de alho.',
        24.99
    ),
    (
        'Angular Adventure',
        'Hamburguer de carne, queijo suíço, picles, cebola roxa e molho de mostarda e mel.',
        32.99
    ),
    (
        'Ruby Royale',
        'Hamburguer vegetariano com hambúrguer de feijão preto, abacate, tomate e molho de iogurte.',
        25.99
    ),
    (
        'PHP Fusion',
        'Hamburguer de carne, queijo provolone, cogumelos salteados e molho de cebola caramelizada.',
        30.99
    ),
    (
        'Go Gourmet',
        'Hamburguer vegetariano com hambúrguer de grão-de-bico, abobrinha grelhada, pimentões e molho de tahine.',
        26.99
    ),
    (
        'TypeScript Tasty',
        'Hamburguer de frango, queijo gouda, abacate e maionese de ervas.',
        31.99
    ),
    (
        'Perl Perfection',
        'Hamburguer vegetariano com hambúrguer de lentilha, queijo feta, azeitonas e molho de tzatziki.',
        27.99
    ),
    (
        'Scala Supreme',
        'Hamburguer de carne, queijo gorgonzola, cebola roxa caramelizada e rúcula.',
        33.99
    ),
    (
        'DevOps Delight',
        'Hamburguer de carne, bacon, queijo suíço, cogumelos e maionese de alho.',
        34.99
    ),
    (
        'Vue Vegano',
        'Hamburguer vegano com hambúrguer de grão-de-bico, abobrinha grelhada, alface e maionese vegana.',
        28.99
    ),
    (
        'Vegan Script',
        'Hamburguer vegano com hambúrguer de grão-de-bico, alface, tomate e molho vegano.',
        19.99
    );