// tests/DatabaseIntegrationTest.php

<?php

require_once './src/Database.php';

use PHPUnit\Framework\TestCase;

class DatabaseIntegrationTest extends TestCase
{
    public function testDatabaseConnection()
    {
        $database = new Database();
        $db = $database->getConnection();
        
        $this->assertInstanceOf('PDO', $db);
    }

    public function testTaskTableExists()
    {
        $database = new Database();
        $db = $database->getConnection();

        $stmt = $db->query('SHOW TABLES LIKE "tasks"');
        $this->assertTrue($stmt->rowCount() > 0);
    }
}

?>
