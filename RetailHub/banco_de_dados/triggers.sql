USE retailhub_sgi;

-- Trigger para o log de cadastro de produtos
-- Trigger para o log de cadastro de produtos
DELIMITER //

CREATE TRIGGER IF NOT EXISTS after_insert_cadastro_produto
AFTER INSERT ON cadastro_produtos
FOR EACH ROW
BEGIN
    INSERT INTO log_cadastro_produtos (id_cadastro_produto, acao_realizada)
    VALUES (NEW.id, 'inclusão');
END;

CREATE TRIGGER IF NOT EXISTS after_update_cadastro_produto
AFTER UPDATE ON cadastro_produtos
FOR EACH ROW
BEGIN
    INSERT INTO log_cadastro_produtos (id_cadastro_produto, acao_realizada)
    VALUES (NEW.id, 'alteração');
END;

CREATE TRIGGER IF NOT EXISTS after_delete_cadastro_produto
AFTER DELETE ON cadastro_produtos
FOR EACH ROW
BEGIN
    INSERT INTO log_cadastro_produtos (id_cadastro_produto, acao_realizada)
    VALUES (OLD.id, 'exclusão');
END;

-- Trigger para o log de vendas
CREATE TRIGGER IF NOT EXISTS after_insert_venda
AFTER INSERT ON vendas
FOR EACH ROW
BEGIN
    INSERT INTO log_vendas (id_venda, acao_realizada)
    VALUES (NEW.id, 'inclusão');
END;

CREATE TRIGGER IF NOT EXISTS after_update_venda
AFTER UPDATE ON vendas
FOR EACH ROW
BEGIN
    INSERT INTO log_vendas (id_venda, acao_realizada)
    VALUES (NEW.id, 'alteração');
END;

CREATE TRIGGER IF NOT EXISTS after_delete_venda
AFTER DELETE ON vendas
FOR EACH ROW
BEGIN
    INSERT INTO log_vendas (id_venda, acao_realizada)
    VALUES (OLD.id, 'exclusão');
END;

-- Trigger para o log de movimentações de estoque (entrada)
CREATE TRIGGER IF NOT EXISTS after_insert_movimentacao_estoque
AFTER INSERT ON movimentacoes_estoque
FOR EACH ROW
BEGIN
    INSERT INTO log_movimentacoes_estoque (id_movimentacao_estoque, acao_realizada)
    VALUES (NEW.id, 'entrada');
    UPDATE cadastro_produtos SET quantidade_estoque = quantidade_estoque + NEW.quantidade WHERE id = NEW.id_produto;
END;

-- Trigger para o log de movimentações de estoque (saída)
CREATE TRIGGER IF NOT EXISTS after_update_movimentacao_estoque
AFTER UPDATE ON movimentacoes_estoque
FOR EACH ROW
BEGIN
    INSERT INTO log_movimentacoes_estoque (id_movimentacao_estoque, acao_realizada)
    VALUES (NEW.id, 'alteração');
    -- Atualizar o estoque após alteração
    UPDATE cadastro_produtos SET quantidade_estoque = quantidade_estoque - NEW.quantidade WHERE id = NEW.id_produto;
END;

CREATE TRIGGER IF NOT EXISTS after_delete_movimentacao_estoque
AFTER DELETE ON movimentacoes_estoque
FOR EACH ROW
BEGIN
    INSERT INTO log_movimentacoes_estoque (id_movimentacao_estoque, acao_realizada)
    VALUES (OLD.id, 'exclusão');
    -- Reverter a movimentação no estoque
    UPDATE cadastro_produtos SET quantidade_estoque = quantidade_estoque + OLD.quantidade WHERE id = OLD.id_produto;
END;

DELIMITER ;

-- Trigger para atualização de estoque após venda
CREATE TRIGGER IF NOT EXISTS after_insert_item_venda
AFTER INSERT ON itens_vendas
FOR EACH ROW
BEGIN
    -- Subtrair do estoque com base na quantidade de produtos vendidos
    UPDATE cadastro_produtos SET quantidade_estoque = quantidade_estoque - NEW.quantidade WHERE id = NEW.id_produto;
END;