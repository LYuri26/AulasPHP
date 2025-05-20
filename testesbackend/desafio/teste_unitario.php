<?php
require_once 'funcoes.php';

try {
    $pdo = conectarBanco();
    $id = inserirProduto($pdo, "ProdutoTesteUnitario", 10);

    if ($id > 0) {
        echo "✅ Teste de inserção passou. ID inserido: $id";
    } else {
        echo "❌ Teste falhou: retorno inválido.";
    }
} catch (Exception $e) {
    echo "❌ Exceção capturada: " . $e->getMessage();
}