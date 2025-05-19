<?php
$conn = new mysqli("localhost", "root", "", "empresa");

if ($conn->connect_error) {
    die("Erro de conexão com o banco de dados.");
}

$conn->set_charset("utf8mb4");