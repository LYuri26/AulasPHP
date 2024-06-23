<?php
// Função para obter todas as músicas da tabela
function getMusicas($pdo)
{
    $sql = "SELECT * FROM musicas"; // Consulta alterada para tabela 'Musicas' ao invés de 'fas'
    $stmt = $pdo->query($sql); // Prepara e executa a consulta SQL
    return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os resultados como um array associativo
}

// Função para obter os dados de uma música pelo ID
function getMusicasById($pdo, $id)
{
    $sql = "SELECT * FROM musicas WHERE id = :id"; // Consulta alterada para tabela 'Musicas' ao invés de 'fas'
    $stmt = $pdo->prepare($sql); // Prepara a consulta SQL para execução
    $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Vincula o parâmetro :id com o valor fornecido, garantindo que seja um inteiro
    $stmt->execute(); // Executa a consulta preparada
    return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna a primeira linha do resultado como um array associativo
}   

// Função para cadastrar uma nova música na tabela
function cadastrarMusicas($pdo, $musica, $album, $ano, $descricao)
{
    $sql = "INSERT INTO musicas (musica, album, ano, descricao) 
            VALUES (:musica, :album, :ano, :descricao)"; // Instrução de inserção alterada para tabela 'musicas' ao invés de 'fas'
    $stmt = $pdo->prepare($sql); // Prepara a instrução SQL para execução
    $stmt->bindParam(':musica', $musica, PDO::PARAM_STR); // Vincula o parâmetro :musica com o valor fornecido como string
    $stmt->bindParam(':album', $album, PDO::PARAM_STR); // Vincula o parâmetro :album com o valor fornecido como string
    $stmt->bindParam(':ano', $ano, PDO::PARAM_INT); // Vincula o parâmetro :ano com o valor fornecido como inteiro
    $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR); // Vincula o parâmetro :descricao com o valor fornecido como string
    return $stmt->execute(); // Executa a instrução preparada e retorna true se bem-sucedida, false caso contrário
}

// Função para editar uma música na tabela
function editarMusicas($pdo, $id, $musica, $album, $ano, $descricao)
{
    try {
        $sql = "UPDATE musicas SET 
                musica = :musica, 
                album = :album, 
                ano = :ano, 
                descricao = :descricao 
                WHERE id = :id"; // Instrução de atualização alterada para tabela 'musicas' ao invés de 'fas'
        $stmt = $pdo->prepare($sql); // Prepara a instrução SQL para execução
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Vincula o parâmetro :id com o valor fornecido como inteiro
        $stmt->bindParam(':musica', $musica, PDO::PARAM_STR); // Vincula o parâmetro :musica com o valor fornecido como string
        $stmt->bindParam(':album', $album, PDO::PARAM_STR); // Vincula o parâmetro :album com o valor fornecido como string
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT); // Vincula o parâmetro :ano com o valor fornecido como inteiro
        $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR); // Vincula o parâmetro :descricao com o valor fornecido como string
        $stmt->execute(); // Executa a instrução preparada
        return true; // Retorna true se a atualização foi bem-sucedida
    } catch (PDOException $e) {
        return false; // Em caso de exceção, retorna false indicando falha na atualização
    }
}

// Função para excluir uma música na tabela
function excluirMusicas($pdo, $id)
{
    try {
        $sql = "DELETE FROM musicas WHERE id = :id"; // Instrução de exclusão alterada para tabela 'musicas' ao invés de 'fas'
        $stmt = $pdo->prepare($sql); // Prepara a instrução SQL para execução
        $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Vincula o parâmetro :id com o valor fornecido como inteiro
        $stmt->execute(); // Executa a instrução preparada
        return true; // Retorna true se a exclusão foi bem-sucedida
    } catch (PDOException $e) {
        return false; // Em caso de exceção, retorna false indicando falha na exclusão
    }
}
?>
