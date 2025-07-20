<?php
/**
 * Controller para criação de clientes - Ecoplast
 * 
 * Recebe dados via POST, valida e persiste no banco de dados
 */

// Carrega o modelo necessário para operações com clientes
require_once __DIR__ . '/../models/client_model.php';

// Define o cabeçalho para resposta JSON
header('Content-Type: application/json');

// Instancia o modelo de cliente
$clientModel = new ClientModel();

// =============================================
// TRATAMENTO DOS DADOS RECEBIDOS
// =============================================

/**
 * Prepara os dados recebidos do formulário:
 * - Remove espaços em branco no início/fim (trim)
 * - Define valores padrão quando não informados
 */
$data = [
    'nome' => trim($_POST['nome'] ?? ''),
    'email' => trim($_POST['email'] ?? ''),
    'telefone' => trim($_POST['telefone'] ?? ''),
    'endereco' => trim($_POST['endereco'] ?? ''),
    'cidade' => trim($_POST['cidade'] ?? ''),
    'estado' => trim($_POST['estado'] ?? ''),
    'cep' => trim($_POST['cep'] ?? ''),
    'status' => trim($_POST['status'] ?? 'ativo') // Valor padrão 'ativo'
];

// =============================================
// VALIDAÇÃO DOS DADOS
// =============================================

// Campos obrigatórios para validação
$camposObrigatorios = ['nome', 'email', 'telefone', 'endereco', 'cidade', 'estado'];
$erros = [];

// Verifica campos obrigatórios vazios
foreach ($camposObrigatorios as $campo) {
    if (empty($data[$campo])) {
        $erros[] = "O campo $campo é obrigatório";
    }
}

// Validação específica para e-mail
if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $erros[] = "E-mail inválido";
}

// Se houver erros, retorna com status 400 (Bad Request)
if (count($erros) > 0) {
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => implode(', ', $erros)
    ]);
    exit;
}

// =============================================
// PERSISTÊNCIA DOS DADOS
// =============================================

try {
    // Tenta criar o cliente no banco de dados
    $success = $clientModel->createClient($data);
    
    if ($success) {
        // Resposta de sucesso
        echo json_encode([
            'success' => true, 
            'message' => 'Cliente cadastrado com sucesso'
        ]);
    } else {
        // Caso o modelo retorne false sem lançar exceção
        echo json_encode([
            'success' => false, 
            'message' => 'Erro ao cadastrar cliente'
        ]);
    }
} catch (PDOException $e) {
    // Erros específicos do banco de dados
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Erro no banco de dados: ' . $e->getMessage()
    ]);
} catch (Exception $e) {
    // Outros tipos de erros
    http_response_code(400);
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
}