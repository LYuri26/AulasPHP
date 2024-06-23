<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
include './conexao.php';

// Obtém os dados do formulário
$cantor = $_POST['cantor']; // Variável alterada de 'email' para 'cantor'
$senha = $_POST['senha'];

try {
    // Prepara a consulta SQL usando prepared statements
    $sql = "SELECT * FROM login WHERE cantor = :cantor AND senha = :senha"; // Consulta alterada para usar 'cantor' ao invés de 'email'
    $stmt = $pdo->prepare($sql);

    // Vincula os parâmetros de cantor e senha
    $stmt->bindParam(':cantor', $cantor, PDO::PARAM_STR); // Parâmetro alterado de ':email' para ':cantor'
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);

    // Executa a consulta
    $stmt->execute();

    // Verifica se encontrou algum registro
    if ($stmt->rowCount() > 0) {
        // Login bem-sucedido
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['cantor'] = $row['cantor']; // Sessão alterada para 'cantor'
        // Redireciona para o dashboard
        header("Location: ../paginas/dashboard.php");
        exit();
    } else {
        // Login falhou, redireciona de volta ao formulário de login com uma mensagem de erro
        header("Location: ../index.html?erro=1");
        exit();
    }
} catch (PDOException $e) {
    // Em caso de erro, redireciona para a página de login com uma mensagem de erro genérica
    header("Location: ../index.html?erro=2");
    exit();
}
?>
