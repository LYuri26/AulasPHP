<?php

function conectar()
{
    // Define as informações de conexão com o banco de dados
    $host = "localhost"; // Endereço do servidor do banco de dados
    $user = "root"; // Nome de usuário do banco de dados
    $password = ""; // Senha do banco de dados
    $db = "lanchonete"; // Nome do banco de dados

    try {
        // Cria uma nova conexão PDO com o banco de dados
        $conexao = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);

        // Configura para lançar exceções em caso de erros
        $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Retorna a conexão estabelecida
        return $conexao;
    } catch (PDOException $e) {
        // Em caso de erro na conexão, exibe uma mensagem de erro no console do navegador
        echo "<script>console.error('Erro na conexão com o banco de dados: " . $e->getMessage() . "');</script>";

        // Retorna nulo para indicar uma falha na conexão
        return null;
    }
}

function fecharConexao($conexao)
{
    // Verifica se a conexão não é nula
    if ($conexao) {
        // Fecha a conexão com o banco de dados
        $conexao = null;
    }
}
