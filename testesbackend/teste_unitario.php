<?php
// Inclui o arquivo com a função a ser testada
include './funcoes.php';

// Teste Unitário - Função calcularPrecoTotal
echo "Teste Unitário - Função calcularPrecoTotal:<br>";

// Teste 1: Quantidade e preço unitário válidos
$quantidade = 10;
$preco_unitario = 20.99;
$esperado = 209.9;
$resultado = calcularPrecoTotal($quantidade, $preco_unitario);
echo "Teste 1: ";
echo ($resultado === $esperado ? "Sucesso" : "Falhou") . "<br>";

// Teste 2: Quantidade negativa
$quantidade = -5;
$preco_unitario = 20.99;
$esperado = -1;
$resultado = calcularPrecoTotal($quantidade, $preco_unitario);
echo "Teste 2: ";
echo ($resultado === $esperado ? "Sucesso" : "Falhou") . "<br>";

// Teste 3: Preço unitário negativo
$quantidade = 10;
$preco_unitario = -20.99;
$esperado = -1;
$resultado = calcularPrecoTotal($quantidade, $preco_unitario);
echo "Teste 3: ";
echo ($resultado === $esperado ? "Sucesso" : "Falhou") . "<br>";

// Fecha o teste
echo "Teste concluído.<br>";
?>
