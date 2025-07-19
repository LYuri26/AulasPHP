<?php
session_start();

// Estrutura condicional switch
switch ($_GET['ok'] ?? 0) {
    case 1:
        $mensagem = "Dados processados com sucesso!";
        break;
    default:
        $mensagem = "Erro no processamento.";
        break;
}

// Estrutura de repetição while
$i = 0;
$chaves = array_keys($_SESSION);
echo "<h2>Resultado do Aluno</h2>";
echo "<p><strong>$mensagem</strong></p>";

while ($i < count($_SESSION)) {
    $chave = $chaves[$i];
    $valor = $_SESSION[$chave];
    echo "<p>$chave: $valor</p>";
    $i++;
}

// Superglobal SERVER
echo "<p><small>Executado por: " . $_SERVER['SERVER_NAME'] . "</small></p>";