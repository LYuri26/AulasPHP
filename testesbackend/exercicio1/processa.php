<?php

$conexao = mysqli_connect("localhost", "root", "", "banco_usuario");

if (!$conexao) {
    die("Erro na conexão com o banco de dados: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $idade = $_POST['idade'];
    $senha = $_POST['senha'];
    $genero = $_POST['genero'];
    $termos = isset($_POST['termos']) ? 1 : 0;  // Verifica se o checkbox foi marcado

    if ($nome == "" || $email == "" || $idade == "" || $senha == "") {
        echo "<div class='alert alert-warning' role='alert'>
                Todos os campos devem ser preenchidos!
              </div>";
    } else {
        $sql = "INSERT INTO usuarios (nome, email, idade, senha, genero, termos) VALUES (
            '$nome',
            '$email',
            $idade,
            '$senha',
            '$genero',
            '$termos'
        )";

        $resultado = mysqli_query($conexao, $sql);

        if ($resultado) {
            echo "<div class='alert alert-success' role='alert'>
                    Cadastro realizado com sucesso!
                  </div>";
            echo "<script>console.log('Cadastro efetuado');</script>";
        } else {
            echo "<div class='alert alert-danger' role='alert'>
                    Erro ao cadastrar: " . mysqli_error($conexao) . "
                  </div>";
        }
    }
} else {
    echo "<p>Requisição inválida, utilize o formulário!</p>";
}

mysqli_close($conexao);
