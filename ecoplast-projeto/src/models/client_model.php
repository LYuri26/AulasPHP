<?php
// Inclui o arquivo de configuração do banco de dados
require_once __DIR__ . '/../config/database.php';

// Classe Model para manipulação de dados de clientes
class ClientModel
{
    // Variável para armazenar a conexão PDO
    private $pdo;

    // Construtor da classe que recebe a conexão PDO
    public function __construct()
    {
        // Acessa a variável global $pdo
        global $pdo;
        // Atribui a conexão PDO à propriedade da classe
        $this->pdo = $pdo;
    }

    // Método para buscar todos os clientes
    public function getAllClients()
    {
        // Executa query SQL para selecionar todos os clientes ordenados por nome
        $stmt = $this->pdo->query("SELECT * FROM clientes ORDER BY nome");
        // Retorna todos os resultados como array
        return $stmt->fetchAll();
    }

    // Método para buscar um cliente pelo ID
    public function getClientById($id)
    {
        // Prepara query SQL para selecionar um cliente específico
        $stmt = $this->pdo->prepare("SELECT * FROM clientes WHERE id = ?");
        // Executa a query passando o ID como parâmetro
        $stmt->execute([$id]);
        // Retorna o resultado (uma única linha)
        return $stmt->fetch();
    }

    // Método para criar um novo cliente
    public function createClient($data)
    {
        // Lista de campos obrigatórios
        $camposObrigatorios = ['nome', 'email', 'telefone', 'endereco', 'cidade', 'estado'];
        // Verifica cada campo obrigatório
        foreach ($camposObrigatorios as $campo) {
            // Se campo estiver vazio, lança exceção
            if (empty($data[$campo])) {
                throw new Exception("O campo $campo é obrigatório");
            }
        }

        // Prepara query SQL para inserção de novo cliente
        $stmt = $this->pdo->prepare("
        INSERT INTO clientes 
        (nome, email, telefone, endereco, cidade, estado, cep, status, data_cadastro) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
    ");

        // Executa a query passando os valores dos campos
        return $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['telefone'],
            $data['endereco'],
            $data['cidade'],
            $data['estado'],
            $data['cep'],
            $data['status']
        ]);
    }

    // Método para atualizar um cliente existente
    public function updateClient($data)
    {
        // Prepara query SQL para atualização de cliente
        $stmt = $this->pdo->prepare("
            UPDATE clientes SET 
            nome = ?, 
            email = ?, 
            telefone = ?, 
            endereco = ?, 
            cidade = ?, 
            estado = ?, 
            cep = ?, 
            status = ? 
            WHERE id = ?
        ");

        // Executa a query passando os valores dos campos e o ID
        return $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['telefone'],
            $data['endereco'],
            $data['cidade'],
            $data['estado'],
            $data['cep'],
            $data['status'],
            $data['id']
        ]);
    }

    // Método para excluir um cliente
    public function deleteClient($id)
    {
        // Prepara query SQL para exclusão de cliente
        $stmt = $this->pdo->prepare("DELETE FROM clientes WHERE id = ?");
        // Executa a query passando o ID como parâmetro
        return $stmt->execute([$id]);
    }
}