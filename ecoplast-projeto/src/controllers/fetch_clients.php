<?php
/**
 * Controller para manipulação de clientes
 * 
 * Funcionalidades:
 * - Listar todos os clientes
 * - Buscar um cliente específico por ID
 */

require_once __DIR__ . '/../models/client_model.php';
header('Content-Type: application/json');
$clientModel = new ClientModel();

try {
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
        
        if ($id === false) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'error' => 'ID inválido. Deve ser um número inteiro.'
            ]);
            exit;
        }

        $cliente = $clientModel->getClientById($id);
        
        if ($cliente) {
            echo json_encode([
                'success' => true,
                'data' => [$cliente] // Retorna como array para consistência
            ]);
        } else {
            http_response_code(404);
            echo json_encode([
                'success' => false,
                'error' => 'Cliente não encontrado'
            ]);
        }
    } else {
        $clientes = $clientModel->getAllClients();
        echo json_encode([
            'success' => true,
            'count' => count($clientes),
            'data' => $clientes
        ]);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro no banco de dados: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Erro no servidor: ' . $e->getMessage()
    ]);
}