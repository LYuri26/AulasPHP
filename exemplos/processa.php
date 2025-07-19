<?php
session_start();

// Superglobais: captura de dados via POST
$nome = $_POST['nome'] ?? 'Não informado';
$idade = $_POST['idade'] ?? 0;
$nota1 = $_POST['nota1'] ?? 0;
$nota2 = $_POST['nota2'] ?? 0;

// Função para calcular média
function calcularMedia($n1, $n2)
{
    return ($n1 + $n2) / 2;
}

// Função com escopo local e array associativo
function avaliarAluno($nome, $media)
{
    $situacao = "";

    // Estrutura condicional if/elseif/else
    if ($media >= 7) {
        $situacao = "Aprovado";
    } elseif ($media >= 5) {
        $situacao = "Recuperação";
    } else {
        $situacao = "Reprovado";
    }

    // Array associativo
    return [
        'nome' => $nome,
        'media' => $media,
        'situacao' => $situacao
    ];
}

// Processamento
$media = calcularMedia($nota1, $nota2);
$aluno = avaliarAluno($nome, $media);

// Estrutura de repetição foreach
foreach ($aluno as $chave => $valor) {
    $_SESSION[$chave] = $valor;
}

// Redirecionamento com superglobal GET
header("Location: resultado.php?ok=1");
exit;