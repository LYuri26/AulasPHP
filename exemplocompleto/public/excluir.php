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

try {
    $sql = "DELETE FROM usuarios WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Usuário excluído com sucesso!";
        $_SESSION['tipo_mensagem'] = "success";
    } else {
        $_SESSION['mensagem'] = "Erro ao excluir usuário.";
        $_SESSION['tipo_mensagem'] = "danger";
    }
} catch (PDOException $e) {
    $_SESSION['mensagem'] = "Erro ao excluir usuário: " . $e->getMessage();
    $_SESSION['tipo_mensagem'] = "danger";
}

header("Location: listar.php");
exit;
