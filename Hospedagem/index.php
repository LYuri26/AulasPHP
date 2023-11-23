<?php
session_start();

require_once './DataBase/conexao.php';

$erro = '';

// Verifica se houve envio do formulário
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se os campos foram preenchidos e não estão vazios
    if (!empty($_POST['email']) && !empty($_POST['senha'])) {
        $email = $_POST['email'];
        $senha = md5($_POST['senha']); // Considerando que a senha no banco está criptografada com MD5
        
        // Conecta-se ao banco de dados
        $conexao = conexao();

        // Verifica as credenciais no banco de dados e busca o nome do usuário
        $query = $conexao->prepare("SELECT nome FROM usuarios WHERE email = :email AND senha = :senha");
        $query->bindParam(":email", $email);
        $query->bindParam(":senha", $senha);
        $query->execute();

        // Verifica se encontrou um usuário correspondente
        if ($query->rowCount() === 1) {
            // Obtém o nome do usuário
            $resultado = $query->fetch(PDO::FETCH_ASSOC);
            $nomeUsuario = $resultado['nome'];

            // Usuário autenticado, guarda o nome na sessão e redireciona para menu.php
            $_SESSION['usuario'] = $nomeUsuario;
            header("Location: menu.php");
            exit;
        } else {
            // Credenciais inválidas, exibe uma mensagem de erro
            $erro = "Credenciais inválidas. Por favor, verifique seu e-mail e senha.";
        }
    } else {
        $erro = "Preencha todos os campos do formulário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Login - Pousada Quinta do Ypuã</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1>Login</h1>

    <?php if (!empty($erro)): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo $erro; ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail">
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
    </form>

    <div class="mt-3">
        <a href="./Cadastro/cadastro.php" class="btn btn-secondary">Criar Cadastro</a>
        <a href="recuperar_senha.php" class="btn btn-secondary">Recuperar Senha</a>
    </div>

</div>

</body>
</html>
