<?php
/**
 * Configuração de conexão com o banco de dados - Ecoplast
 * 
 * Este arquivo contém as configurações essenciais para conexão com o MySQL/MariaDB
 * utilizando a extensão PDO (PHP Data Objects) para maior segurança e flexibilidade.
 */

// =============================================
// CONSTANTES DE CONFIGURAÇÃO DO BANCO DE DADOS
// =============================================

/**
 * Endereço do servidor de banco de dados
 * Padrão: 'localhost' ou IP do servidor
 */
define('DB_HOST', 'localhost');

/**
 * Nome do banco de dados a ser utilizado
 * Deve corresponder ao banco criado no SQL
 */
define('DB_NAME', 'ecoplast_db');

/**
 * Nome de usuário para acesso ao banco de dados
 * Em ambiente de produção, utilize um usuário com permissões restritas
 */
define('DB_USER', 'root');

/**
 * Senha do usuário do banco de dados
 * Em ambiente real, nunca deixe vazio ou com valores padrão
 * Recomenda-se armazenar em variáveis de ambiente
 */
define('DB_PASS', '');

// =============================================
// CONEXÃO COM O BANCO DE DADOS
// =============================================

try {
    /**
     * Cria uma nova instância PDO para conexão com MySQL
     * Parâmetros:
     * - DSN (Data Source Name): Tipo de banco, host e nome do banco
     * - Usuário
     * - Senha
     * - Opções adicionais (array)
     */
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME, 
        DB_USER, 
        DB_PASS,
        [
            // Configurações adicionais recomendadas
            PDO::ATTR_PERSISTENT => false, // Conexões persistentes podem ser habilitadas em produção
            PDO::ATTR_TIMEOUT => 30 // Tempo limite de conexão em segundos
        ]
    );
    
    /**
     * Define o modo de erro para exceções
     * Isso faz com que erros do banco sejam lançados como Exceptions
     */
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    /**
     * Define o modo padrão de fetch como array associativo
     * Isso faz com que os resultados sejam retornados como arrays associativos
     * onde as chaves são os nomes das colunas
     */
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
    /**
     * Configura o charset para utf8mb4 (suporte a caracteres especiais e emojis)
     * Importante para evitar problemas com acentuação e caracteres especiais
     */
    $pdo->exec("SET NAMES utf8mb4");
    
} catch (PDOException $e) {
    /**
     * Em caso de erro na conexão, encerra a execução e exibe mensagem
     * IMPORTANTE: Em produção, não exibir detalhes do erro diretamente
     * Recomenda-se registrar em log e mostrar mensagem genérica ao usuário
     */
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// =============================================
// RECOMENDAÇÕES PARA USO
// =============================================

/**
 * Para utilizar esta conexão em outros arquivos:
 * 
 * require_once 'caminho/para/este/arquivo.php';
 * 
 * E então usar a variável global $pdo para executar queries:
 * 
 * $stmt = $pdo->prepare("SELECT * FROM tabela");
 * $stmt->execute();
 * $resultados = $stmt->fetchAll();
 */