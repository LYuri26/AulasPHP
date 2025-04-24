<?php
require_once './backend/config/db.php';
require_once './backend/clientes.php';
require_once './backend/produtos.php';
require_once './backend/vendas.php';
require_once './backend/itens_vendas.php';
require_once './backend/movimentacoes_estoque.php';
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>RetailHub - Sistema de Vendas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./public/css/estilo.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">RetailHub</h1>
        <p class="lead text-center mb-5">Sistema de Gerenciamento Integrado de Vendas, Estoque e Clientes</p>

        <div class="row row-cols-1 row-cols-md-3 g-4">

            <!-- Clientes -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Cadastro de Clientes</h5>
                        <p class="card-text">Gerencie os dados dos seus clientes.</p>
                        <a href="./public/pages/clientes.php" class="btn btn-primary w-100">Acessar</a>
                    </div>
                </div>
            </div>

            <!-- Produtos -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Cadastro de Produtos</h5>
                        <p class="card-text">Controle os produtos do estoque.</p>
                        <a href="./public/pages/produtos.php" class="btn btn-primary w-100">Acessar</a>
                    </div>
                </div>
            </div>

            <!-- Vendas -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Vendas</h5>
                        <p class="card-text">Registre e consulte vendas realizadas.</p>
                        <a href="./public/pages/vendas.php" class="btn btn-primary w-100">Acessar</a>
                    </div>
                </div>
            </div>

            <!-- Log de Vendas -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Log de Vendas</h5>
                        <p class="card-text">Audite as ações realizadas sobre vendas.</p>
                        <a href="./public/pages/log_vendas.php" class="btn btn-secondary w-100">Ver Log</a>
                    </div>
                </div>
            </div>

            <!-- Log de Produtos -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Log de Produtos</h5>
                        <p class="card-text">Auditoria de criação, edição e exclusão de produtos.</p>
                        <a href="./public/pages/log_cadastro_produtos.php" class="btn btn-secondary w-100">Ver Log</a>
                    </div>
                </div>
            </div>

            <!-- Log de Estoque -->
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Log de Movimentação de Estoque</h5>
                        <p class="card-text">Histórico das entradas e saídas de estoque.</p>
                        <a href="./public/pages/log_movimentacoes_estoque.php" class="btn btn-secondary w-100">Ver
                            Log</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bootstrap Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>