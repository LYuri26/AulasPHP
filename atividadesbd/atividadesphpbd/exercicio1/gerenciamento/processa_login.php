<?php
// Inicia a sessão
session_start();

// Inclui o arquivo de conexão com o banco de dados
include './conexao.php';

// Obtém os dados do formulário
$email = $_POST['email'];
$senha = $_POST['senha'];

try {
    // Prepara a consulta SQL usando prepared statements
    $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
    $stmt = $pdo->prepare($sql);

    // Vincula os parâmetros de email e senha
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha, PDO::PARAM_STR);

    // Executa a consulta
    $stmt->execute();

    // Verifica se encontrou algum registro
    if ($stmt->rowCount() > 0) {
        // Login bem-sucedido
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['nome'] = $row['nome'];
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
