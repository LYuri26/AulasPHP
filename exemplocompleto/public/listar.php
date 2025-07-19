<?php
require_once '../config/environment.php';
require_once '../config/database.php';
session_start();

// Consulta mais complexa com ordenação
$sql = "SELECT 
            u.*,
            DATE_FORMAT(u.data_criacao, '%d/%m/%Y %H:%i') as data_formatada
        FROM usuarios u
        ORDER BY u.data_criacao DESC";

$usuarios = fetchAll($sql);

$titulo_pagina = "Lista de Usuários";
require_once '../templates/header.php';
require_once '../templates/navegacao.php';
require_once '../templates/mensagem.php';
?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Telefone</th>
            <th>Cadastrado em</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= $usuario->id ?></td>
                <td><?= htmlspecialchars($usuario->nome) ?></td>
                <td><?= htmlspecialchars($usuario->email) ?></td>
                <td><?= htmlspecialchars($usuario->telefone) ?></td>
                <td><?= $usuario->data_formatada ?></td>
                <td>
                    <a href="editar.php?id=<?= $usuario->id ?>" class="btn btn-sm btn-warning">Editar</a>
                    <a href="excluir.php?id=<?= $usuario->id ?>" class="btn btn-sm btn-danger"
                        onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once '../templates/footer.php'; ?>