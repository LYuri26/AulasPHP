<?php
require_once '../config/environment.php';
require_once '../config/database.php';
session_start();

if (!isset($_GET['id'])) {
    header("Location: listar.php");
    exit;
}

$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
if (!$id) {
    $_SESSION['mensagem'] = "ID inválido!";
    $_SESSION['tipo_mensagem'] = "danger";
    header("Location: listar.php");
    exit;
}

// Busca o usuário no banco
try {
    $sql = "SELECT * FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $usuario = $stmt->fetch();

    if (!$usuario) {
        $_SESSION['mensagem'] = "Usuário não encontrado!";
        $_SESSION['tipo_mensagem'] = "danger";
        header("Location: listar.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao buscar usuário: " . $e->getMessage();
    $_SESSION['tipo_mensagem'] = "danger";
    header("Location: listar.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = sanitize($_POST['nome']);
    $email = sanitize($_POST['email']);
    $telefone = sanitize($_POST['telefone']);

    // Validação
    if (empty($nome) || empty($email)) {
        $_SESSION['mensagem'] = "Nome e e-mail são obrigatórios!";
        $_SESSION['tipo_mensagem'] = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = "E-mail inválido!";
        $_SESSION['tipo_mensagem'] = "danger";
    } else {
        try {
            $sql = "UPDATE usuarios SET nome = :nome, email = :email, telefone = :telefone WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $_SESSION['mensagem'] = "Usuário atualizado com sucesso!";
                $_SESSION['tipo_mensagem'] = "success";
                header("Location: listar.php");
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['mensagem'] = "Erro ao atualizar usuário: " . $e->getMessage();
            $_SESSION['tipo_mensagem'] = "danger";
        }
    }
}

$titulo_pagina = "Editar Usuário";
require_once '../templates/header.php';
require_once '../templates/navegacao.php';
require_once '../templates/mensagem.php';
?>

<form method="POST">
    <div class="mb-3">
        <label for="nome" class="form-label">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?= $usuario->nome ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">E-mail</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $usuario->email ?>" required>
    </div>
    <div class="mb-3">
        <label for="telefone" class="form-label">Telefone</label>
        <input type="text" class="form-control" id="telefone" name="telefone" value="<?= $usuario->telefone ?>">
    </div>
    <button type="submit" class="btn btn-primary">Atualizar</button>
</form>

<?php require_once '../templates/footer.php'; ?>