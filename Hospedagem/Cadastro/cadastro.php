<?php
require_once '../DataBase/conexao.php'; // Inclui o arquivo de conexão

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário estão preenchidos
    if (isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['senha']) && isset($_POST['perfil'])) {

        // Obtém os dados do formulário
        $nome = $_POST['nome'];
        $email = $_POST['email'];
        $senha = md5($_POST['senha']); // Recomenda-se utilizar métodos mais seguros para criptografar senhas
        $perfil = $_POST['perfil'];

        // Obtém a conexão do arquivo conexao.php
        $conexao = conexao();

        $query = $conexao->prepare("INSERT INTO usuarios (nome, email, senha, perfil) VALUES (:nome, :email, :senha, :perfil)");
        $query->bindParam(":nome", $nome);
        $query->bindParam(":email", $email);
        $query->bindParam(":senha", $senha);
        $query->bindParam(":perfil", $perfil);

        try {
            $query->execute();
            // Cadastro realizado com sucesso, redireciona para o index.php
            header("Location: ../index.php");
            exit;
        } catch (PDOException $e) {
            echo "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    } else {
        echo "Preencha todos os campos do formulário.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastro - Pousada Quinta do Ypuã</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

<div class="container">
    <h1>Cadastro</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite seu nome">
        </div>
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Digite seu e-mail">
        </div>
        <div class="form-group">
            <label for="senha">Senha</label>
            <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite sua senha">
        </div>
        <div class="form-group">
            <label for="perfil">Perfil</label>
            <input type="text" class="form-control" id="perfil" name="perfil" placeholder="Digite seu perfil">
        </div>
        <button type="submit" class="btn btn-primary">Cadastrar</button>
    </form>

    <!-- Botão para voltar ao menu principal -->
    <a href="../index.php" class="btn btn-secondary mt-3">Voltar ao Menu Principal</a>
</div>

</body>
</html>
