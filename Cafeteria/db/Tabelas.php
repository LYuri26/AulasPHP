<?php
function criarBancoETabelas()
{
    $host = "localhost";
    $dbname = "codebrew_cafe";
    $username = "root";
    $password = "";

    try {
        // Primeiro conecta sem especificar o banco de dados
        $conn = new PDO("mysql:host=$host;charset=utf8", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Verifica se o banco de dados existe
        $stmt = $conn->query("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$dbname'");
        if ($stmt->rowCount() == 0) {
            // Cria o banco de dados
            $conn->exec("CREATE DATABASE $dbname");
            $conn->exec("USE $dbname");

            // Cria as tabelas
            $conn->exec("CREATE TABLE IF NOT EXISTS bebidas (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome VARCHAR(255) NOT NULL,
                descricao TEXT NOT NULL,
                preco DECIMAL(8,2) NOT NULL,
                categoria VARCHAR(100) NOT NULL
            )");

            $conn->exec("CREATE TABLE IF NOT EXISTS pedidos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nome_cliente VARCHAR(255) NOT NULL,
                data_pedido DATE NOT NULL,
                horario_pedido TIME NOT NULL,
                valor_total DECIMAL(8,2) NOT NULL,
                itens_pedido TEXT NOT NULL
            )");

            // Cria o trigger usando DELIMITER (requer execução em modo não preparado)
            $sql = "
            DELIMITER $$
            CREATE TRIGGER IF NOT EXISTS antes_de_inserir_pedido
            BEFORE INSERT ON pedidos
            FOR EACH ROW
            BEGIN
                SET NEW.data_pedido = CURDATE();
                SET NEW.horario_pedido = CURTIME();
            END$$
            DELIMITER ;
            ";

            // Executa cada parte do trigger separadamente
            $conn->exec("DROP TRIGGER IF EXISTS antes_de_inserir_pedido");
            $conn->exec("CREATE TRIGGER antes_de_inserir_pedido
                        BEFORE INSERT ON pedidos
                        FOR EACH ROW
                        SET NEW.data_pedido = CURDATE(), NEW.horario_pedido = CURTIME()");

            // Insere dados iniciais
            $bebidas = [
                ['Java Latte', 'Café espresso com leite vaporizado', 12.90, 'Café'],
                ['Python Espresso', 'Café forte sem adições', 10.50, 'Café'],
                ['Ruby Chai', 'Chá preto com especiarias', 9.80, 'Chá'],
                ['JavaScript Juice', 'Suco natural de laranja', 8.50, 'Refresco']
            ];

            $stmt = $conn->prepare("INSERT INTO bebidas (nome, descricao, preco, categoria) VALUES (?, ?, ?, ?)");
            foreach ($bebidas as $bebida) {
                $stmt->execute($bebida);
            }

            echo "Banco de dados e tabelas criados com sucesso!";
        } else {
            echo "Banco de dados já existe.";
        }
    } catch (PDOException $e) {
        die("Erro ao criar banco de dados: " . $e->getMessage());
    } finally {
        if (isset($conn)) {
            $conn = null;
        }
    }
}

// Executa a função quando o arquivo é chamado diretamente
if (basename($_SERVER['PHP_SELF']) === 'Tabelas.php') {
    criarBancoETabelas();
}