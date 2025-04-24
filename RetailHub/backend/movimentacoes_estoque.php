<?php
require_once 'config/db.php';

// Função para adicionar movimentação de estoque
function adicionarMovimentacao($id_produto, $quantidade, $tipo_movimentacao)
{
    global $conexao;

    // Validação do tipo de movimentação
    if ($tipo_movimentacao !== 'entrada' && $tipo_movimentacao !== 'saída') {
        echo "Tipo de movimentação inválido!";
        return;
    }

    // Data e hora atuais
    $data_movimentacao = date('Y-m-d H:i:s');

    // Inserção na tabela de movimentações de estoque
    $stmt = $conexao->prepare("INSERT INTO movimentacoes_estoque (id_produto, quantidade, tipo_movimentacao, timestamp) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id_produto, $quantidade, $tipo_movimentacao, $data_movimentacao]);

    // Atualização do estoque no cadastro_produtos
    if ($tipo_movimentacao === 'entrada') {
        $stmt = $conexao->prepare("UPDATE cadastro_produtos SET quantidade_estoque = quantidade_estoque + ? WHERE id = ?");
    } else {
        $stmt = $conexao->prepare("UPDATE cadastro_produtos SET quantidade_estoque = quantidade_estoque - ? WHERE id = ?");
    }
    $stmt->execute([$quantidade, $id_produto]);

    // Inserir log de movimentação de estoque
    $stmt = $conexao->prepare("INSERT INTO log_movimentacoes_estoque (id_movimentacao_estoque, acao_realizada, timestamp) 
                               VALUES (LAST_INSERT_ID(), ?, ?)");
    $stmt->execute([$tipo_movimentacao, $data_movimentacao]);

    echo "Movimentação de estoque realizada com sucesso!";
}