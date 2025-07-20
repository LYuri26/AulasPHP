<?php
/**
 * Controller para exclusão de clientes - Ecoplast
 * 
 * Responsável por:
 * - Receber o ID do cliente a ser excluído via POST
 * - Validar o ID recebido
 * - Chamar o modelo para realizar a exclusão
 * - Retornar o resultado da operação em JSON
 */

// Carrega o modelo necessário para operações com clientes
require_once __DIR__ . '/../models/client_model.php';

// Define o cabeçalho para resposta JSON
header('Content-Type: application/json');

// Instancia o modelo de cliente
$clientModel = new ClientModel();

// Obtém o ID do cliente a ser excluído
// Usa o operador de coalescência nula para evitar undefined index
$id = $_POST['id'] ?? '';

try {
    // =============================================
    // VALIDAÇÃO DO ID RECEBIDO
    // =============================================
    if (empty($id)) {
        throw new Exception('ID do cliente não informado');
    }

    // =============================================
    // TENTATIVA DE EXCLUSÃO
    // =============================================
    $success = $clientModel->deleteClient($id);
    
    if ($success) {
        // Resposta de sucesso
        echo json_encode([
            'success' => true, 
            'message' => 'Cliente excluído com sucesso',
            'deleted_id' => $id // Adiciona o ID excluído na resposta
        ]);
    } else {
        // Caso o modelo retorne false sem lançar exceção
        echo json_encode([
            'success' => false, 
            'message' => 'Erro ao excluir cliente'
        ]);
    }
    
} catch (PDOException $e) {
    // =============================================
    // TRATAMENTO DE ERROS DO BANCO DE DADOS
    // =============================================
    http_response_code(500); // Internal Server Error
    echo json_encode([
        'success' => false, 
        'message' => 'Erro no banco de dados: ' . $e->getMessage()
    ]);
    
} catch (Exception $e) {
    // =============================================
    // TRATAMENTO DE OUTROS ERROS
    // =============================================
    http_response_code(400); // Bad Request
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}