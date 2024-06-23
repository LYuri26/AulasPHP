<?php
// Função para obter todos os fãs da tabela
function getFans($pdo)
{
    $sql = "SELECT * FROM fas";
    $stmt = $pdo->query($sql);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Função para obter os dados do fã pelo ID
function getFanById($pdo, $id)
{
    $sql = "SELECT * FROM fas WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Função para cadastrar um novo fã na tabela
function cadastrarFan($pdo, $nome, $email, $data_nascimento, $cidade, $estado, $pais)
{
    $sql = "INSERT INTO fas (nome, email, data_nascimento, cidade, estado, pais) 
            VALUES (:nome, :email, :data_nascimento, :cidade, :estado, :pais)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
    $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
    $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
    $stmt->bindParam(':pais', $pais, PDO::PARAM_STR);
    return $stmt->execute();
}

// Função para editar um fã na tabela
function editarFan($pdo, $id, $nome, $email, $data_nascimento, $cidade, $estado, $pais)
{
    try {
        // SQL para atualizar o registro na tabela fas
        $sql = "UPDATE fas SET 
                nome = :nome, 
                email = :email, 
                data_nascimento = :data_nascimento, 
                cidade = :cidade, 
                estado = :estado, 
                pais = :pais 
                WHERE id = :id";

        // Preparando a declaração
        $stmt = $pdo->prepare($sql);

        // Vinculando parâmetros com os valores fornecidos
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
        $stmt->bindParam(':cidade', $cidade, PDO::PARAM_STR);
        $stmt->bindParam(':estado', $estado, PDO::PARAM_STR);
        $stmt->bindParam(':pais', $pais, PDO::PARAM_STR);

        // Executando a declaração
        $stmt->execute();

        // Retornando true se a atualização for bem-sucedida
        return true;
    } catch (PDOException $e) {
        // Em caso de exceção, retornamos false para indicar falha na atualização
        return false;
    }
}

// Função para excluir um fã na tabela
function excluirFan($pdo, $id)
{
    try {
        $sql = "DELETE FROM fas WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Em caso de exceção, retornamos false para indicar falha na exclusão
        return false;
    }
}
?>
