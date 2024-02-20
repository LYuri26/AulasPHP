// src/Database.php

<?php

class Database
{
    private $host = 'localhost';
    private $db_name = 'meu_projeto_test';
    private $username = 'root';
    private $password = '';
    public $conn;

    public function getConnection()
    {
        $this->conn = null;

        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de Conexão: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
?>
