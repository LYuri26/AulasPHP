<?php
// Função para calcular o preço total de um produto
function calcularPrecoTotal($quantidade, $preco_unitario) {
    if ($quantidade < 0 || $preco_unitario < 0) {
        return -1; // Retorna -1 se os valores forem inválidos
    }
    return $quantidade * $preco_unitario;
}
?>
