<?php
// Array com partes dos nomes dos membros originais do Linkin Park
$membros = ["Chester", "Mike", "Joe", "Brad", "Rob"];

// Gerar uma senha aleatória utilizando partes dos nomes dos membros
$senha = "";
for ($i = 0; $i < 8; $i++) {
    $random_index = mt_rand(0, count($membros) - 1);
    $parte_nome = $membros[$random_index];
    $senha .= substr($parte_nome, mt_rand(0, strlen($parte_nome) - 1), 1);
}

// Exibir a senha gerada
echo "Senha gerada: $senha";
?>
