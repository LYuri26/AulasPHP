<?php
// Conexão com o banco de dados
require_once '../backend/config/db.php';
require_once '../backend/clientes.php';
require_once '../backend/produtos.php';
require_once '../backend/vendas.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RetailHub - Sistema de Vendas</title>
    <!-- Link do Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./css/estilo.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <h1 class="text-center">Bem-vindo ao Sistema RetailHub</h1>
        <p class="lead text-center">Sistema de Gerenciamento Integrado de Vendas, Estoque e Clientes</p>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cadastro de Clientes</h5>
                        <p class="card-text">Gerencie os clientes e suas informações de contato.</p>
                        <a href="clientes.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Cadastro de Produtos</h5>
                        <p class="card-text">Gerencie os produtos do estoque, suas descrições e preços.</p>
                        <a href="produtos.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Vendas</h5>
                        <p class="card-text">Visualize as vendas realizadas e os itens vendidos.</p>
                        <a href="vendas.php" class="btn btn-primary">Acessar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>