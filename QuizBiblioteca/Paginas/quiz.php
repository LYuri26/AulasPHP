<?php
include '../BancoDeDados/conexao.php';

$nome = isset($_POST['nome']) ? $_POST['nome'] : '';

if (empty($nome)) {
    echo "<h2>Informe o seu nome:</h2>";
    echo "<form action='quiz.php' method='post'>";
    echo "<input type='text' name='nome'><br>";
    echo "<button type='submit'>Iniciar Quiz</button>";
    echo "</form>";
    exit();
}

$pergunta = isset($_POST['pergunta']) ? (int)$_POST['pergunta'] : 1;

$perguntas = [
    "Qual é a capital da França?",
    "Qual é a cor do céu em um dia claro?",
    // Adicione mais perguntas aqui
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Processar a resposta da pergunta
    $pontuacao = isset($_POST['resposta']) ? (int)$_POST['resposta'] : 0;
    $atualizarPontuacaoQuery = "UPDATE jogadores SET pontuacao = pontuacao + :pontuacao WHERE nome = :nome";
    $stmt = $pdo->prepare($atualizarPontuacaoQuery);
    $stmt->bindParam(':pontuacao', $pontuacao, PDO::PARAM_INT);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->execute();

    $pergunta++; // Avançar para a próxima pergunta
}

if ($pergunta > count($perguntas)) {
    // Todas as perguntas foram respondidas, redirecionar para a tela final
    header("Location: finalizar.php?nome=$nome&pontuacao=$pontuacao");
    exit();
}

echo "<h2>Bem-vindo, $nome!</h2>";
echo "<form action='quiz.php' method='post'>";
echo "<input type='hidden' name='nome' value='$nome'>";
echo "<input type='hidden' name='pergunta' value='$pergunta'>";

echo "<h2>Pergunta $pergunta:</h2>";
echo "<h3>{$perguntas[$pergunta - 1]}</h3>";

// Opções de resposta
echo "<button type='submit' name='resposta' value='0'>Opção 1</button>";
echo "<button type='submit' name='resposta' value='0'>Opção 2</button>";
echo "<button type='submit' name='resposta' value='0'>Opção 3</button>";
echo "<button type='submit' name='resposta' value='10'>Opção Correta</button>";

echo "</form>";
