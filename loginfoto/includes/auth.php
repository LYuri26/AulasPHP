<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect('../login.php');
}

if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
    $_SESSION['error'] = 'Token de segurança inválido';
    redirect('../login.php');
}

// Processar Login
if (isset($_POST['login'])) {
    $username = sanitize($_POST['username']);
    $password = $_POST['password'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $username]);
        $user = $stmt->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            $_SESSION['error'] = 'Credenciais inválidas';
            redirect('../login.php');
        }

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['user_photo'] = $user['photo_path'] ?? $defaultPhoto;

        redirect('../dashboard.php');
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Erro ao fazer login';
        redirect('../login.php');
    }
}

// Processar Registro
if (isset($_POST['register'])) {
    $username = sanitize($_POST['username']);
    $email = sanitize($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $terms = isset($_POST['terms']);

    // Validações
    $errors = [];

    if (!$terms) {
        $errors[] = 'Você deve aceitar os termos de serviço.';
    }

    if ($password !== $confirm_password) {
        $errors[] = 'As senhas não coincidem.';
    }

    if (!validatePassword($password)) {
        $errors[] = 'A senha deve conter maiúsculas, minúsculas, números e símbolos (mínimo 8 caracteres).';
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode('<br>', $errors);
        $_SESSION['old_values'] = $_POST;
        redirect('../login.php');
    }

    try {
        // Verifica se usuário ou email já existem
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);

        if ($stmt->fetch()) {
            $_SESSION['error'] = 'Nome de usuário ou email já cadastrado.';
            $_SESSION['old_values'] = $_POST;
            redirect('../login.php');
        }

        // Processa upload da foto
        $photoPath = $defaultPhoto;
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            try {
                $photoPath = uploadPhoto($_FILES['photo']);
            } catch (Exception $e) {
                $_SESSION['error'] = 'Erro ao enviar foto: ' . $e->getMessage();
                $_SESSION['old_values'] = $_POST;
                redirect('../login.php');
            }
        }

        // Cria o hash da senha
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Insere no banco de dados
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, photo_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $photoPath]);

        $_SESSION['success'] = 'Registro realizado com sucesso! Faça login para continuar.';
        redirect('../login.php');
    } catch (Exception $e) {
        // Remove a foto se foi enviada mas ocorreu erro no registro
        if (isset($photoPath) && $photoPath !== $defaultPhoto && file_exists($photoPath)) {
            unlink($photoPath);
        }

        $_SESSION['error'] = 'Erro ao registrar: ' . $e->getMessage();
        $_SESSION['old_values'] = $_POST;
        redirect('../login.php');
    }
}

redirect('../login.php');
