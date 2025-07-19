<?php
require_once '../config/environment.php';
require_once '../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitize($_POST['nome']);
    $email = sanitize($_POST['email']);
    $telefone = sanitize($_POST['telefone']);

    // Validação básica
    if (empty($nome) || empty($email)) {
        $_SESSION['mensagem'] = "Nome e e-mail são obrigatórios!";
        $_SESSION['tipo_mensagem'] = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = "E-mail inválido!";
        $_SESSION['tipo_mensagem'] = "danger";
    } else {
        try {
            $sql = "INSERT INTO usuarios (nome, email, telefone) VALUES (:nome, :email, :telefone)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Usuário cadastrado com sucesso!";
                $_SESSION['tipo_mensagem'] = "success";
                header("Location: listar.php");
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['mensagem'] = "Erro ao cadastrar usuário: " . $e->getMessage();
            $_SESSION['tipo_mensagem'] = "danger";
        }
    }
}

$titulo_pagina = "Cadastrar Usuário";
require_once '../templates/header.php';
require_once '../templates/navegacao.php';
require_once '../templates/mensagem.php';
?>

<form method="POST">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone">
    </div>
    <button type="submit" class="btn btn-primary">Cadastrar</button>
</form>

<?php require_once '../templates/footer.php'; ?>