<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./static/css/login.css">

</head>

<body class="d-flex flex-column min-vh-100">
    <header class="bg-secondary text-white py-4 mb-4">
        <div class="container">
            <h1 class="mb-3">Bem-vindo ao Sistema de Gestão Integrada (SGI) da Grãos BR</h1>
            <p class="lead">Olá! Este é o SGI da empresa Grãos BR.</p>
        </div>
    </header>

    <main class="container my-auto">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow">
                    <div class="card-body p-4">
                        <h2 class="card-title text-center mb-4">Faça o login</h2>
                        <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            method="POST">
                            <div class="mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="senha" class="form-label">Senha:</label>
                                <input type="password" class="form-control" id="senha" name="senha" required>
                            </div>
                            <button id="loginButton" class="btn btn-success w-100 py-2" type="submit"
                                onclick="showRedirectAlert()">Entrar</button>
                            <p id="login-error" class="text-danger mt-2 text-center" style="display: none;">Login
                                inválido</p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php
    // Iniciando a sessão
    session_start();

    // Incluindo o arquivo de conexão com o banco de dados
    include './db/db_connect.php';

    // Verificando se o formulário de login foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Capturando os dados do formulário
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        try {
            // Query para buscar o usuário com o email e senha fornecidos
            $query = "SELECT id, nome, cargo FROM funcionarios WHERE email = :email AND senha = :senha";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->bindParam(':senha', $senha, PDO::PARAM_STR);
            $statement->execute();

            // Verificando se o usuário foi encontrado
            if ($statement->rowCount() == 1) {
                // Armazenando o ID, nome e cargo do usuário em variáveis de sessão
                $usuario = $statement->fetch(PDO::FETCH_ASSOC);
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_cargo'] = $usuario['cargo'];

                // Redirecionando para a página principal se o login for bem-sucedido
                header("Location: ./paginas/principal.html");
                exit();
            } else {
                // Exibindo mensagem de erro na tela
                echo '<script>document.getElementById("login-error").style.display = "block";</script>';
            }
        } catch (PDOException $e) {
            // Exibindo mensagem de erro no console do navegador
            echo '<script>';
            echo 'console.error("Erro ao fazer login: ' . $e->getMessage() . '");';
            echo '</script>';
        }
    }
    ?>

    <footer class="bg-secondary text-white py-3 mt-auto">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1">Entre em contato:</p>
                    <p class="mb-1">Email: <a href="mailto:09113875@senaimgdocente.com.br"
                            class="text-white">09113875@senaimgdocente.com.br</a></p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="mb-1">&copy; 2024 GrãosBR. Todos os direitos reservados.</p>
                    <p class="mb-0">Endereço: Praça Frei Eugênio, R. São Benedito, 85, Uberaba - MG, 38010-280</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="./static/js/script.js"></script>
</body>

</html>