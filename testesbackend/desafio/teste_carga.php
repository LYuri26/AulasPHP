<?php
require_once 'funcoes.php';

try {
    $pdo = conectarBanco();
    for ($i = 0; $i < 50; $i++) {
        $nome = "ProdutoCarga" . $i;
        $qtd = rand(1, 100);
        inserirProduto($pdo, $nome, $qtd);
    }
    echo "✅ Carga executada com sucesso.";
} catch (Exception $e) {
    echo "❌ Erro durante carga: " . $e->getMessage();
}