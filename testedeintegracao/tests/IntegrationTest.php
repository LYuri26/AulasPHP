<?php
use PHPUnit\Framework\TestCase;

require_once 'src/Database.php';

class IntegrationTest extends TestCase {
    public function testDatabaseConnection() {
        $db = new Database('localhost', 'root', '', 'test_db');
        $conn = $db->getConnection();
        $this->assertInstanceOf(mysqli::class, $conn);
    }

    public function testUserData() {
        $db = new Database('localhost', 'root', '', 'test_db');
        $conn = $db->getConnection();
        $result = $conn->query("SELECT * FROM users WHERE id = 1");
        $user = $result->fetch_assoc();
        $this->assertEquals('John Doe', $user['name']);
        $this->assertEquals('john@example.com', $user['email']);
    }
}
?>
