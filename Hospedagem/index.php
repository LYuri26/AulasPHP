<?php

require_once './DataBase/conexao.php';

// Verifica se o usuário está logado
if (isset($_SESSION['usuario'])) {
  // O usuário está logado, redireciona para a página inicial
  header("Location: index.php");
  exit;
}

// O usuário não está logado, carrega a tela de login
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

    <form action="index.php" method="post">
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

  </div>

</body>
</html>

<?php

// Verifica se os dados do formulário estão preenchidos
if (empty($_POST['email']) || empty($_POST['senha'])) {
  echo "Preencha todos os campos do formulário.";
  exit;
}

// Conecta ao banco de dados
$conexao = conexao();

// Seleciona o usuário
$query = $conexao->prepare("SELECT * FROM usuarios WHERE email = :email AND senha = :senha");
$query->bindParam(":email", $_POST['email']);
$query->bindParam(":senha", md5($_POST['senha']));
$query->execute();

// Verifica se o usuário foi encontrado
if ($query->rowCount() === 0) {
  echo "Usuário ou senha inválidos.";
  exit;
}

// Cria a sessão do usuário
$usuario = $query->fetch(PDO::FETCH_ASSOC);
session_start();
$_SESSION['usuario'] = $usuario;

// Redireciona o usuário para a página inicial
header("Location: index.php");

?>
