<?php
require_once '../config/environment.php';
require_once '../config/database.php';
session_start();

$titulo_pagina = "Página Inicial";
require_once '../templates/header.php';
require_once '../templates/navegacao.php';
require_once '../templates/mensagem.php';
?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Bem-vindo ao sistema</h5>
        <p class="card-text">Sistema de cadastro de usuários com PHP e MySQL.</p>
        <a href="listar.php" class="btn btn-primary">Ver usuários cadastrados</a>
    </div>
</div>

<?php require_once '../templates/footer.php'; ?>