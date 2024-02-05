<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./static/css/login.css">
    <script src="./static/js/script.js"></script>
</head>

<body>
    <header>
        <h1>Bem-vindo ao Sistema de Gestão Integrada (SGI) da Grãos BR</h1>
        <p>Olá! Este é o SGI da empresa Grãos BR.</p>
    </header>
    <div class="login-container">
        <h2>Faça o login</h2>
        <form id="login-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button id="loginButton" type="submit" onclick="showRedirectAlert()">Entrar</button>
        </form>
        <p id="login-error">Login inválido</p>
    </div>

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
    <footer>
        <div class="contato">
            <p>Entre em contato:</p>
            <p>Email: <a href="mailto:09113875@senaimgdocente.com.br">09113875@senaimgdocente.com.br</a></p>
        </div>
        <div class="informacoes-adicionais">
            <p>&copy; 2024 GrãosBR. Todos os direitos reservados.</p>
            <p>Endereço: Praça Frei Eugênio, R. São Benedito, 85, Uberaba - MG, 38010-280</p>
        </div>
    </footer>
</body>

</html>