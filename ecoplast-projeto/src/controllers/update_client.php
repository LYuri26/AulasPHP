<?php
/**
 * Controller para atualização de clientes
 * 
 * Funcionalidades:
 * - Recebe dados do cliente via POST
 * - Atualiza registro no banco de dados
 * - Retorna resultado da operação em JSON
 */

// Carrega o modelo de clientes (arquivo com a classe ClientModel)
require_once __DIR__ . '/../models/client_model.php';

// Define o cabeçalho para retornar JSON
header('Content-Type: application/json');

// Inicializa o modelo de clientes
$clientModel = new ClientModel();

// Prepara os dados recebidos do formulário
$data = [
    'id' => $_POST['id'] ?? '',          // ID do cliente a ser atualizado
    'nome' => $_POST['nome'] ?? '',       // Nome completo
    'email' => $_POST['email'] ?? '',     // Endereço de e-mail
    'telefone' => $_POST['telefone'] ?? '', // Número de telefone
    'endereco' => $_POST['endereco'] ?? '', // Endereço completo
    'cidade' => $_POST['cidade'] ?? '',   // Cidade
    'estado' => $_POST['estado'] ?? '',   // Estado (UF)
    'cep' => $_POST['cep'] ?? '',         // CEP
    'status' => $_POST['status'] ?? 'ativo' // Status (padrão: ativo)
];

try {
    // =============================================
    // VALIDAÇÃO DOS DADOS RECEBIDOS (OPCIONAL)
    // =============================================
    // Pode-se adicionar validações aqui antes de atualizar
    // Exemplo: verificar se e-mail é válido, se campos obrigatórios estão preenchidos, etc.
    
    // =============================================
    // TENTATIVA DE ATUALIZAÇÃO
    // =============================================
    $success = $clientModel->updateClient($data);
    
    if ($success) {
        // Resposta de sucesso
        echo json_encode([
            'success' => true, 
            'message' => 'Cliente atualizado com sucesso',
            'updated_id' => $data['id'] // Retorna o ID atualizado
        ]);
    } else {
        // Caso o update retorne false sem lançar exceção
        http_response_code(422); // Unprocessable Entity
        echo json_encode([
            'success' => false, 
            'message' => 'Nenhuma alteração foi realizada ou cliente não encontrado'
        ]);
    }
    
} catch (PDOException $e) {
    // =============================================
    // ERROS DE BANCO DE DADOS
    // =============================================
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false, 
        'message' => 'Erro no banco de dados',
        // Em ambiente de desenvolvimento pode mostrar o erro completo:
        'error_details' => $e->getMessage()
    ]);
    
} catch (Exception $e) {
    // =============================================
    // OUTROS TIPOS DE ERROS
    // =============================================
    http_response_code(400); // Bad Request
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}