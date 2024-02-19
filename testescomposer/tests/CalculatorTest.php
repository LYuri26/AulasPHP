<?php
use PHPUnit\Framework\TestCase;

require_once './src/Calculator.php';

class CalculatorTest extends TestCase {
    public function testAddition() {
        $calculator = new Calculator();
        $result = $calculator->add(2, 3);
        $this->assertEquals(5, $result);
    }

    public function testSubtraction() {
        $calculator = new Calculator();
        $result = $calculator->subtract(5, 3);
        $this->assertEquals(2, $result);
    }
}
?>
