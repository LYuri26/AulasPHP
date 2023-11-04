<?php
include '../BancoDeDados/conexao.php';

$nome = isset($_GET['nome']) ? $_GET['nome'] : '';
$pontuacao = isset($_GET['pontuacao']) ? (int)$_GET['pontuacao'] : 0;

if (empty($nome)) {
    echo "<h2>Ocorreu um erro ao finalizar o quiz.</h2>";
    exit();
}

try {
    echo "<h2>Jogo finalizado!</h2>";
    echo "<h3>Nome: $nome</h3>";
    echo "<h3>Pontuação: $pontuacao</h3>";

    // Enviar dados para inserirdados.php
    include '../BancoDeDados/inserirdados.php';
} catch (PDOException $e) {
    die("Erro ao inserir dados: " . $e->getMessage());
}
?>

<script>
    setTimeout(function() {
        window.location.href = 'quiz.php';
    }, 5000); // Redireciona após 5 segundos (5000 milissegundos)
</script>