<?php
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/functions.php';

if (isLoggedIn()) {
    redirect('./dashboard.php');
}

$error = $_SESSION['error'] ?? '';
$oldValues = $_SESSION['old_values'] ?? [];
unset($_SESSION['error'], $_SESSION['old_values']);
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h3 class="card-title text-center mb-4">Login</h3>

                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?= $error ?></div>
                        <?php endif; ?>

                        <form action="includes/auth.php" method="POST" class="needs-validation" novalidate>
                            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                            <div class="mb-3">
                                <label for="username" class="form-label">Usuário ou Email</label>
                                <input type="text" class="form-control" id="username" name="username" required
                                    autofocus>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Senha</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" name="password" required>
                                    <button class="btn btn-outline-secondary toggle-password" type="button">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <button type="submit" name="login" class="btn btn-primary w-100">Entrar</button>
                        </form>

                        <div class="text-center mt-3">
                            <button class="btn btn-link" data-bs-toggle="modal" data-bs-target="#registerModal">
                                Criar nova conta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Cadastre-se</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="registerForm" action="includes/auth.php" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">

                        <div class="mb-3">
                            <label for="reg_username" class="form-label">Nome de Usuário</label>
                            <input type="text" class="form-control" id="reg_username" name="username"
                                value="<?= htmlspecialchars($oldValues['username'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor, informe um nome de usuário.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reg_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="reg_email" name="email"
                                value="<?= htmlspecialchars($oldValues['email'] ?? '') ?>" required>
                            <div class="invalid-feedback">
                                Por favor, informe um email válido.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reg_password" class="form-label">Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="reg_password" name="password" required
                                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[\W_]).{8,}">
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Mínimo 8 caracteres com maiúsculas, minúsculas, números e
                                símbolos</small>
                            <div class="progress mt-2" style="height: 5px;">
                                <div id="password-strength-bar" class="progress-bar" role="progressbar"></div>
                            </div>
                            <div class="invalid-feedback">
                                A senha deve conter pelo menos 8 caracteres, incluindo maiúsculas, minúsculas, números e
                                símbolos.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reg_confirm_password" class="form-label">Confirmar Senha</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="reg_confirm_password"
                                    name="confirm_password" required>
                                <button class="btn btn-outline-secondary toggle-password" type="button">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                As senhas devem coincidir.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="reg_photo" class="form-label">Foto de Perfil (opcional)</label>
                            <input type="file" class="form-control" id="reg_photo" name="photo" accept="image/*">
                            <small class="text-muted">Formatos: JPG, PNG, GIF (Máx. 2MB)</small>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="reg_terms" name="terms" required
                                <?= isset($oldValues['terms']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="reg_terms">Aceito os termos de serviço</label>
                            <div class="invalid-feedback">
                                Você deve concordar com os termos.
                            </div>
                        </div>

                        <button type="submit" name="register" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>

</html>